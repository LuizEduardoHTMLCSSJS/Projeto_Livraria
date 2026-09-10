CREATE DATABASE IF NOT EXISTS livraria;


USE livraria;

CREATE TABLE IF NOT EXISTS autores (
    id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nacionalidade VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS livros (
    id_livro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(250) NOT NULL,
    id_autor INT,
    id_categoria INT,

    FOREIGN KEY (id_autor)
        REFERENCES autores(id_autor),

    FOREIGN KEY (id_categoria)
        REFERENCES categorias(id_categoria)
);

CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_cliente INT NOT NULL,
    valor_total DECIMAL(10,2),

    FOREIGN KEY (id_cliente)
        REFERENCES clientes(id_cliente)
);

CREATE TABLE IF NOT EXISTS itens_pedido (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_livro INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido),

    FOREIGN KEY (id_livro)
        REFERENCES livros(id_livro)
);

INSERT INTO autores (nome, nacionalidade)
VALUES
('Irmãos Grimm', 'Alemã'),
('J. R. R. Tolkien', 'Britânica'),
('C. S. Lewis', 'Britânica'),
('John Green', 'Americana'),
('Miguel de Cervantes', 'Espanhola');


INSERT INTO categorias (nome)
VALUES
('Fantasia'),
('Drama'),
('Clássico');

INSERT INTO livros
(titulo, preco, imagem, id_autor, id_categoria)
VALUES
('Branca de Neve', 29.90, 'assets/livro1.png', 1, 1),
('O Senhor dos Anéis', 59.90, 'assets/livro2.png', 2, 1),
('As Crônicas de Nárnia', 44.90, 'assets/livro3.png', 3, 1),
('A Culpa é das Estrelas', 34.90, 'assets/livro4.png', 4, 2),
('Dom Quixote', 39.90, 'assets/livro5.png', 5, 3);