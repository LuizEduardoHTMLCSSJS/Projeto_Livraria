<?php

require_once 'conexao.php';

$conexaoObj = new Conexao();
$pdo = $conexaoObj->conectar();

// Caminho da imagem padrão para todos os livros cadastrados
const IMAGEM_PADRAO = 'assets/validar.png';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo    = trim($_POST['titulo'] ?? '');
    $autor     = trim($_POST['autor'] ?? '');
    $preco     = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);
    $categoria = trim($_POST['categoria'] ?? '');

    if (!empty($titulo) && !empty($autor) && $preco !== false && $preco >= 0) {

        try {
            $pdo->beginTransaction();

            // 1. Verifica se o autor já existe; se não, cria
            $stmt = $pdo->prepare("SELECT id_autor FROM autores WHERE nome = :nome");
            $stmt->execute([':nome' => $autor]);
            $idAutor = $stmt->fetchColumn();

            if (!$idAutor) {
                $stmt = $pdo->prepare("INSERT INTO autores (nome) VALUES (:nome)");
                $stmt->execute([':nome' => $autor]);
                $idAutor = $pdo->lastInsertId();
            }

            // 2. Verifica se a categoria já existe (se foi informada); se não, cria
            $idCategoria = null;
            if (!empty($categoria)) {
                $stmt = $pdo->prepare("SELECT id_categoria FROM categorias WHERE nome = :nome");
                $stmt->execute([':nome' => $categoria]);
                $idCategoria = $stmt->fetchColumn();

                if (!$idCategoria) {
                    $stmt = $pdo->prepare("INSERT INTO categorias (nome) VALUES (:nome)");
                    $stmt->execute([':nome' => $categoria]);
                    $idCategoria = $pdo->lastInsertId();
                }
            }

            // 3. Insere o livro já com os IDs corretos e a imagem fixa
            $sql = "INSERT INTO livros (titulo, preco, imagem, id_autor, id_categoria) 
                    VALUES (:titulo, :preco, :imagem, :id_autor, :id_categoria)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo'       => $titulo,
                ':preco'        => $preco,
                ':imagem'       => IMAGEM_PADRAO,
                ':id_autor'     => $idAutor,
                ':id_categoria' => $idCategoria
            ]);

            $pdo->commit();

            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer . "?status=sucesso");
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Erro ao cadastrar livro: " . $e->getMessage());
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer . "?status=erro");
            exit;
        }

    } else {
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header("Location: " . $referer . "?status=erro");
        exit;
    }

} else {
    header('Location: index.php');
    exit;
}