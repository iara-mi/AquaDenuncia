<?php

$servername = "localhost";
$username = "root"; // Deve ser root
$password = "";     // Deve ser vazio
$dbname = "hackathon_desperdicio"; // Nome do seu banco de dados

$conn = new mysqli($host, $usuario, $senha, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>