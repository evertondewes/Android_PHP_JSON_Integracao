<?php
/*
listar_livros.php

create database controle_clientes;

use  controle_clientes;

CREATE table cliente(
    id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(250),
 rua VARCHAR(150),
 numero int,
 bairro varchar(100)
 );
*/

//file_put_contents('entrada.txt', $_GET['nome'], FILE_APPEND);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=controle_clientes;
                       charset=utf8", 'root', '');


    $metodo = $_SERVER['REQUEST_METHOD'];

    switch ($metodo) {
        case 'GET':
            if (isset($_GET['nome'])) {
                $consulta = $pdo->query('SELECT * FROM livro WHERE nome like "%' . $_GET['nome'] . '%" ');
            } else {
                $consulta = $pdo->query('SELECT * FROM livro');
            }
            $_Livros = $consulta->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json; charset=utf-8');

            echo json_encode($_Livros);
            break;

        case 'POST':
            $entrada = file_get_contents('php://input');
            $cliente = json_decode($entrada);

            $pdo->query("INSERT INTO cliente(nome, rua, numero, bairro) values('$cliente->nome', '$cliente->rua', $cliente->numero, '$cliente->bairro'); ");
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

} catch (Exception $e) {
    file_put_contents('exception.txt', print_r($e, true), FILE_APPEND);
}

