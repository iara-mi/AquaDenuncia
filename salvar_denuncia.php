<?php
/**
 * ARQUIVO: salvar_denuncia.php
 * Processa o formulário, insere a denúncia e EXIBE A PÁGINA DE CONFIRMAÇÃO DIRETAMENTE.
 */

// Inclui o arquivo de conexão
require_once 'conexao.php';

// 1. Recebe e trata os dados
$tipo_denuncia = isset($_POST['tipo_denuncia']) ? $_POST['tipo_denuncia'] : null;
$detalhes = isset($_POST['detalhes']) ? $_POST['detalhes'] : null;

// Garante que lat/lon tenham valor mesmo que o GPS falhe
$latitude = isset($_POST['latitude']) && !empty($_POST['latitude']) ? $_POST['latitude'] : '0.0'; 
$longitude = isset($_POST['longitude']) && !empty($_POST['longitude']) ? $_POST['longitude'] : '0.0'; 

// 2. Prepara a query SQL
$sql = "INSERT INTO denuncias (tipo_denuncia, detalhes, latitude, longitude) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

$status_mensagem = "";
$status_cor = "";
$status_titulo = "";

// 3. Verifica a preparação e liga os parâmetros
if ($stmt === false) {
    $status_titulo = "Erro Grave no Sistema";
    $status_mensagem = "Falha na Preparação da Query. Verifique o log do servidor.";
    $status_cor = "red";
} else {
    $stmt->bind_param("ssss", $tipo_denuncia, $detalhes, $latitude, $longitude);

    // 4. Executa a inserção
    if ($stmt->execute()) {
        $status_titulo = "✅ Sucesso! Denúncia Registrada.";
        $status_mensagem = "Sua denúncia foi registrada com sucesso! Agradecemos sua colaboração na proteção dos recursos hídricos.";
        $status_cor = "#4CAF50"; // Verde
    } else {
        $status_titulo = "❌ Erro ao Registrar a Denúncia";
        $status_mensagem = "Houve uma falha na inserção dos dados. Por favor, tente novamente. Detalhes do erro: " . $conn->error;
        $status_cor = "red";
    }
    $stmt->close();
}
$conn->close();

// 5. Imprime a página HTML de Confirmação
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Denúncia</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f4f4; text-align: center; }
        .logo-header { background-color: #008CBA; color: white; padding: 20px; font-size: 2.5em; width: 100%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .logo-header span { font-weight: bold; color: #4CAF50; }
        .message-box { max-width: 600px; margin-top: 50px; padding: 40px; border-radius: 10px; background-color: white; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); border-left: 8px solid <?php echo $status_cor; ?>; }
        h1 { color: <?php echo $status_cor; ?>; margin-bottom: 20px; }
        p { color: #333; font-size: 1.1em; line-height: 1.6; }
        .back-link { margin-top: 30px; font-size: 1.1em; color: #008CBA; text-decoration: none; font-weight: bold; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    
    <div class="logo-header">
        Aqua<span>Denuncia</span>
    </div>

    <div class="message-box">
        <h1><?php echo $status_titulo; ?></h1>
        <p><?php echo $status_mensagem; ?></p>
        
        <a href="login.html" class="back-link">Voltar e Fazer Nova Denúncia</a>
        <br>
        <a href="lista_denuncias.php" class="back-link" style="color: #4CAF50;">Ver Denúncias Registradas (Admin)</a>
    </div>

</body>
</html>