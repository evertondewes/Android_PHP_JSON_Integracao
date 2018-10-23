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

//file_put_contents('entrada.txt', $_GET['nome'], FILE_APPEND);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=biblioteca;
                       charset=utf8",'root', '');
} catch (PDOException $e) {
    die('Error, não pude conectar: ' . $e->getMessage() . '  <br>  ');
}


$metodo =  $_SERVER['REQUEST_METHOD'];

switch ($metodo){
    case 'GET':
        if(isset($_GET['nome'])) {
            $consulta = $pdo->query('SELECT * FROM livro WHERE nome like "%' . $_GET['nome'] . '%" ');
        } else{
            $consulta = $pdo->query('SELECT * FROM livro');
        }
        $_Livros = $consulta->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($_Livros);
        break;

    case 'POST':
        $entrada = file_get_contents('php://input');
        $livro = json_decode($entrada);

        $pdo->query("INSERT INTO livro(nome, ano) values('$livro->nome', $livro->ano); ");
        break;

    case 'PUT':
        $entrada = file_get_contents('php://input');
        $livro = json_decode($entrada);

        $sql = "UPDATE livro SET ano = $livro->ano WHERE nome = '$livro->nome'; ";

        $pdo->query($sql);
        break;

    case 'DELETE':
        $entrada = file_get_contents('php://input');
        $livro = json_decode($entrada);

        $sql = "DELETE FROM livro WHERE nome = '$livro->nome'; ";

        $pdo->query($sql);
        break;
}

