<?php

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/livraria.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Garante que a tabela exista no banco
    $pdo->exec("CREATE TABLE IF NOT EXISTS livros (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        autor TEXT NOT NULL,
        preco REAL NOT NULL,
        categoria TEXT
    )");
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
    $titulo    = trim($_POST['titulo'] ?? '');
    $autor     = trim($_POST['autor'] ?? '');
    $preco     = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);
    $categoria = trim($_POST['categoria'] ?? '');

    
    if (!empty($titulo) && !empty($autor) && $preco !== false) {
        
        try {
            
            $sql = "INSERT INTO livros (titulo, autor, preco, categoria) VALUES (:titulo, :autor, :preco, :categoria)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':titulo'    => $titulo,
                ':autor'     => $autor,
                ':preco'     => $preco,
                ':categoria' => $categoria
            ]);

            
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer . "?status=sucesso");
            exit;

        } catch (PDOException $e) {
            die("Erro ao salvar no banco de dados: " . $e->getMessage());
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
