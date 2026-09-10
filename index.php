<?php

require_once 'conexao.php';

$conexaoObj = new Conexao();
$pdo = $conexaoObj->conectar();

$sql = "
    SELECT
        l.id_livro,
        l.titulo,
        l.preco,
        l.imagem,
        a.nome AS autor
    FROM livros l
    LEFT JOIN autores a
        ON l.id_autor = a.id_autor
";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Minha Biblioteca</title>
  <link href="https://fonts.googleapis.com/css2?family=UnifrakturCook&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="estilo.css">
</head>
<body>

<div id="bouncer">L</div>

<script>
  const el = document.getElementById('bouncer');
  let x = 50, y = 50;
  let dx = 2, dy = 2;

  function animar() {
    const larguraMax = window.innerWidth - el.offsetWidth;
    const alturaMax = window.innerHeight - el.offsetHeight;

    x += dx;
    y += dy;

    if (x <= 0 || x >= larguraMax) dx *= -1;
    if (y <= 0 || y >= alturaMax) dy *= -1;

    el.style.transform = `translate(${x}px, ${y}px)`;
    requestAnimationFrame(animar);
  }

  animar();
</script>

  <header>
    <h1>Catalogo da Livraria</h1>
    <a href="cadastro.html" class="btn-novo">Nova Historia</a>
  </header>

  <div class="grid-livros">

    <?php foreach ($livros as $livro) { ?>

      <div class="card-livro">
        <a href="leitura.php?livro=<?php echo $livro['id_livro']; ?>">
          <img src="<?php echo htmlspecialchars($livro['imagem']); ?>" alt="Capa do livro">
        </a>
        <div class="info">
          <h3><?php echo htmlspecialchars($livro['titulo']); ?></h3>
          <p><?php echo htmlspecialchars($livro['autor']); ?></p>
          <p>
            R$
            <?php echo number_format($livro['preco'], 2, ',', '.'); ?>
          </p>
        </div>
      </div>

    <?php } ?>

  </div>
</body>
</html>