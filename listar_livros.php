<?php
/*
CREATE DATABASE biblioteca;

USE biblioteca;

CREATE TABLE livro (
  id INT NOT NULL AUTO_INCREMENT ,
  nome VARCHAR(60) NOT NULL ,
  ano INT NOT NULL ,
  PRIMARY KEY (id)
);

INSERT INTO livro(nome, ano) values
  ('Glória a Deus', 2011),
  ('Código Limpo', 2014),
  ('Domain Driven Design', 2013);

 */

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblioteca;
                       charset=utf8",'root', '');
} catch (PDOException $e) {
    die('Error, não pude conectar: ' . $e->getMessage() . '  <br>  ');
}

$consulta = $pdo->query('SELECT * FROM livro');

$_Livros = $consulta->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json; charset=utf-8');
// php -S localhost:80
echo json_encode($_Livros);