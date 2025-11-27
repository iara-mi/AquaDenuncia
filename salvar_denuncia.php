<?php
require_once 'conexao.php';

$tipo_denuncia = $_POST['tipo_denuncia'] ?? '';
$detalhes = $_POST['detalhes'] ?? '';

$latitude = !empty($_POST['latitude']) ? $_POST['latitude'] : '-23.550520';
$longitude = !empty($_POST['longitude']) ? $_POST['longitude'] : '-46.633309';

if (empty($tipo_denuncia) || empty($detalhes)) {
    die("Erro: Por favor, preencha o tipo de denúncia e os detalhes.");
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