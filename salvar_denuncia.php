<?php
/**
 * ARQUIVO: salvar_denuncia.php
 * Processa o formulário de login.html e insere a denúncia no banco de dados.
 */

// Inclui o arquivo de conexão com o banco de dados (necessita do conexao.php)
require_once 'conexao.php';

// 1. Recebe e sanitiza os dados do formulário (POST)
$tipo_denuncia = isset($_POST['tipo_denuncia']) ? $_POST['tipo_denuncia'] : null;
$detalhes = isset($_POST['detalhes']) ? $_POST['detalhes'] : null;

// Garante que latitude e longitude sejam '0.0' se a detecção de GPS falhar
$latitude = isset($_POST['latitude']) && !empty($_POST['latitude']) ? $_POST['latitude'] : '0.0'; 
$longitude = isset($_POST['longitude']) && !empty($_POST['longitude']) ? $_POST['longitude'] : '0.0'; 

// 2. Prepara a query SQL com placeholders (?) para segurança
$sql = "INSERT INTO denuncias (tipo_denuncia, detalhes, latitude, longitude) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// 3. Verifica se a preparação da query foi bem-sucedida
if ($stmt === false) {
    // Se a query tiver erro de sintaxe ou coluna, ele irá parar aqui.
    die("ERRO FATAL: Falha na Preparacao da Query: " . $conn->error); 
}

// 4. Liga os parâmetros (Binding parameters): 'ssss' indica que todos são strings
$stmt->bind_param("ssss", $tipo_denuncia, $detalhes, $latitude, $longitude);

// 5. Executa a query
if ($stmt->execute()) {
    // SUCESSO! Redireciona para o login.html e adiciona o parâmetro 'status=sucesso'
    header("Location: login.html?status=sucesso");
    exit(); // CRUCIAL: Interrompe o script para garantir que o redirecionamento ocorra
} else {
    // FALHA: Se o erro ocorrer na execução (ex: falta de dados), ele irá parar e mostrar o erro
    die("ERRO DE INSERÇÃO: Falha na Execucao da Insercao: " . $stmt->error); 
}

// 6. Fecha o statement e a conexão (se o script não tiver saído no 'exit()')
$stmt->close();
$conn->close();
?>