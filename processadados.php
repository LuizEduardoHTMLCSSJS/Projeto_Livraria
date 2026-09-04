<?php
//Processamento dos dados da Livraria

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $autor  = $_POST['autor'] ?? '';
    $preco  = $_POST['preco'] ?? '';

    echo "<h1>Livro Cadastrado com Sucesso!</h1>";
    echo "<p><strong>Título:</strong> " . htmlspecialchars($titulo) . "</p>";
    echo "<p><strong>Autor:</strong> " . htmlspecialchars($autor) . "</p>";
    echo "<p><strong>Preço:</strong> R$ " . htmlspecialchars($preco) . "</p>";
} else {
    echo "<p>Aguardando envio do formulário...</p>";
}
?>