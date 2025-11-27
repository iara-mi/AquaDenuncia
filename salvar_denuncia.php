<?php
/**
 * ARQUIVO: salvar_denuncia.php
 * Processa o formulário de login.html e insere a denúncia no banco de dados.
 */

// 1. Inclui o arquivo de conexão
require_once 'conexao.php';

// 2. Recebe e sanitiza os dados do formulário
$tipo_denuncia = isset($_POST['tipo_denuncia']) ? $_POST['tipo_denuncia'] : null;
$detalhes = isset($_POST['detalhes']) ? $_POST['detalhes'] : null;
// Usamos a atribuição '0' ou '1' se o campo estiver vazio para evitar erros de tipo na query
$latitude = isset($_POST['latitude']) && !empty($_POST['latitude']) ? $_POST['latitude'] : '0'; 
$longitude = isset($_POST['longitude']) && !empty($_POST['longitude']) ? $_POST['longitude'] : '0'; 

// 3. Prepara a query SQL com Statement
$sql = "INSERT INTO denuncias (tipo_denuncia, detalhes, latitude, longitude) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// 4. Verifica se a preparação da query foi bem-sucedida
if ($stmt === false) {
    // Isso deve alertar sobre erro de sintaxe SQL ou problema de conexão
    die("Erro na preparação da query: " . $conn->error); 
}

// 5. Liga os parâmetros (Todos como string 's' é mais seguro para lat/lon)
$stmt->bind_param("ssss", $tipo_denuncia, $detalhes, $latitude, $longitude);

// 6. Executa a query
if ($stmt->execute()) {
    // Sucesso
    header("Location: login.html?status=sucesso");
} else {
    // Falha
    // Isso deve alertar sobre problema na tabela ou dados
    die("Erro ao executar a inserção: " . $stmt->error); 
}

// 7. Fecha o statement e a conexão
$stmt->close();
$conn->close();
?>