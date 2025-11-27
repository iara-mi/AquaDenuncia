<?php

$host = 'sql108.infinityfree.com'; 
$usuario = 'if0_40530559';
$senha = 'y6MFjpU2nAg';       
$dbname = 'if0_40530559_alerta'; 


$conn = new mysqli($host, $usuario, $senha, $dbname);

if ($conn->connect_error) {

    die("Falha na conexão com o banco de dados. Contate o administrador.");
}

$conn->set_charset("utf8");

?>