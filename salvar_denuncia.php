<?php
/**
 * ARQUIVO: salvar_denuncia.php
 * Processa o formulário de login.html e insere a denúncia no banco de dados.
 */

// Inclui o arquivo de conexão
require_once 'conexao.php';

// Recebe e sanitiza os dados do formulário
$tipo_denuncia = isset($_POST['tipo_denuncia']) ? $_POST['tipo_denuncia'] : null;
$detalhes = isset($_POST['detalhes']) ? $_POST['detalhes'] : null;

// Mesmo que o GPS falhe no celular, definimos como '0.0' para garantir que a inserção funcione
$latitude = isset($_POST['latitude']) && !empty($_POST['latitude']) ? $_POST['latitude'] : '0.0'; 
$longitude = isset($_POST['longitude']) && !empty($_POST['longitude']) ? $_POST['longitude'] : '0.0'; 

// 1. Prepara a query SQL
$sql = "INSERT INTO denuncias (tipo_denuncia, detalhes, latitude, longitude) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// 2. Verifica se a preparação da query foi bem-sucedida
if ($stmt === false) {
    // Se a query falhar aqui, o problema é SQL (nome de coluna, etc.)
    die("ERRO 01: Falha na Preparacao da Query: " . $conn->error); 
}

// 3. Liga os parâmetros
$stmt->bind_param("ssss", $tipo_denuncia, $detalhes, $latitude, $longitude);

// 4. Executa a query
if ($stmt->execute()) {
    // SUCESSO! Redireciona para o login.html com o parâmetro de sucesso
    header("Location: login.html?status=sucesso");
} else {
    // FALHA na execução da inserção.
    // Isso deve mostrar o erro de constraint (restrição) ou dados.
    die("ERRO 02: Falha na Execucao da Insercao: " . $stmt->error); 
}

// 5. Fecha statement e conexão
$stmt->close();
$conn->close();
exit(); // Garante que nada mais seja executado
?>