<?php

require_once 'conexao.php';

$tipo_denuncia = $_POST['tipo_denuncia'] ?? '';
$detalhes = $_POST['detalhes'] ?? '';

$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';

if (empty($tipo_denuncia) || empty($detalhes) || empty($latitude) || empty($longitude)) {
    die("Erro: Por favor, preencha todos os campos e autorize o GPS.");
}

$sql = "INSERT INTO denuncias (tipo_denuncia, detalhes, latitude, longitude, status, data_criacao) 
        VALUES (?, ?, ?, ?, 'Pendente', NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $tipo_denuncia, $detalhes, $latitude, $longitude); 

if ($stmt->execute()) {
    header("Location: lista_denuncias.php?sucesso=true");
    exit();
} else {
    echo "Erro ao salvar a denúncia: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>