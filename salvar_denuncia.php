<?php

include "conexao.php"; 

$feedback = '';
$sucesso = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $tipo = isset($_POST['tipo_desperdicio']) ? $conn->real_escape_string($_POST['tipo_desperdicio']) : '';
    $detalhes = isset($_POST['detalhes']) ? $conn->real_escape_string($_POST['detalhes']) : '';
    $latitude = isset($_POST['latitude']) ? $conn->real_escape_string($_POST['latitude']) : '';
    $longitude = isset($_POST['longitude']) ? $conn->real_escape_string($_POST['longitude']) : '';
    
    if (empty($tipo) || empty($latitude) || empty($longitude)) {
        $feedback = "Erro: Tipo de desperdício e localização GPS são obrigatórios.";
    } else {
        
        $sql = "INSERT INTO denuncias (tipo_desperdicio, detalhes, latitude, longitude, status, data_hora) 
                VALUES ('$tipo', '$detalhes', '$latitude', '$longitude', 'Aberto', NOW())";

        if ($conn->query($sql) === TRUE) {
            $feedback = "Denúncia registrada com sucesso! Agradecemos a sua vigilância.";
            $sucesso = true;
        } else {
            $feedback = "Erro ao registrar a denúncia: " . $conn->error;
        }
    }

    $conn->close();
} else {

    $feedback = "Acesso inválido. Por favor, utilize o formulário de denúncia.";
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status da Denúncia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { 
            max-width: 600px; 
            margin-top: 50px; 
            text-align: center; 
            padding: 40px !important;
        }
    </style>
</head>
<body>

<div class="container rounded shadow-lg 
    <?php echo $sucesso ? 'bg-success text-white' : 'bg-danger text-white'; ?>">
    
    <h1 class="mb-4">
        <?php echo $sucesso ? '✅ Sucesso!' : '❌ Erro!'; ?>
    </h1>
    
    <p class="lead mb-4"><?php echo $feedback; ?></p>
    
    <a href="login.html" class="btn 
        <?php echo $sucesso ? 'btn-light text-success' : 'btn-light text-danger'; ?>">
        Voltar ao Formulário
    </a>
</div>

</body>
</html>