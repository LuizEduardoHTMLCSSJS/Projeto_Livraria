CREATE DATABASE livraria;

USE livraria;

CREATE TABLE autores (
    id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nacionalidade VARCHAR(50)
);

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE livros (
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

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20)
);

CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_cliente INT NOT NULL,
    valor_total DECIMAL(10,2),

    FOREIGN KEY (id_cliente)
        REFERENCES clientes(id_cliente)
);

CREATE TABLE itens_pedido (
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
('Machado de Assis', 'Brasileiro'),
('J. K. Rowling', 'Britânica');

INSERT INTO categorias (nome)
VALUES
('Romance'),
('Fantasia'),
('Ficção');

INSERT INTO livros
(titulo, autor, preco, imagem)
VALUES
('Dom Casmurro', 'Machado de Assis', 39.90, 'assets/dom_casmurro.jpg'),
('Harry Potter e a Pedra Filosofal', 'J. K. Rowling', 49.90, 'assets/harry_potter.jpg');