<?php

$host = 'localhost';
$usuario = 'root'; 
$senha = '';
$dbname = 'hackathon_desperdicio';

$conn = new mysqli($host, $usuario, $senha, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>