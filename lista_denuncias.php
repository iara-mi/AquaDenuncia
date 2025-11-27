<?php
include 'conexao.php';

$mensagem_status = ''; 

if (isset($_GET['acao']) && $_GET['acao'] == 'resolver' && isset($_GET['id'])) {
    
    $id_remover = $conn->real_escape_string($_GET['id']);
    
    $sql_update = "UPDATE denuncias SET status = 'Resolvido' WHERE id = '$id_remover'";
    
    if ($conn->query($sql_update) === TRUE) {
        $mensagem_status = "Denúncia #$id_remover marcada como RESOLVIDA com sucesso!";
    } else {
        $mensagem_status = "Erro ao resolver denúncia: " . $conn->error;
    }
}

$sql_select = "SELECT id, tipo_desperdicio, detalhes, latitude, longitude, DATE_FORMAT(data_hora, '%d/%m/%Y %H:%i') AS data_formatada 
               FROM denuncias 
               WHERE status = 'Aberto' 
               ORDER BY data_hora DESC";

$resultado = $conn->query($sql_select);


$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Denúncias Abertas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> 
        body { background-color: #f8f9fa; }
        .container { margin-top: 30px; margin-bottom: 50px; }
        .table-responsive { overflow-x: auto; }
    </style>
</head>
<body>

<div class="container">
    <h3 class="mb-4 text-center text-secondary">Painel de Denúncias Abertas (Status: Ações Pendentes)</h3>

    <?php if (!empty($mensagem_status)): ?>
        <div class="alert alert-<?php echo strpos($mensagem_status, 'sucesso') !== false ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo $mensagem_status; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <p class="text-end mb-3">
        <a href="login.html" class="btn btn-outline-primary btn-sm">Criar Nova Denúncia</a>
    </p>

    <?php if ($resultado && $resultado->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Detalhes</th>
                        <th>Data/Hora</th>
                        <th>Localização</th>
                        <th>Ação (UPDATE)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><span class="badge bg-danger"><?php echo htmlspecialchars($row['tipo_desperdicio']); ?></span></td>
                        <td><?php echo htmlspecialchars(substr($row['detalhes'], 0, 50)); ?>...</td>
                        <td><?php echo $row['data_formatada']; ?></td>
                        <td>
                            <a href="https://maps.google.com/?q=<?php echo $row['latitude'] . ',' . $row['longitude']; ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Ver no Mapa">
                                Mapa
                            </a>
                        </td>
                        <td>
                            <a href="?acao=resolver&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success" 
                               onclick="return confirm('Tem certeza que deseja marcar esta denúncia como RESOLVIDA?')">
                                🛠️ Resolver
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-success text-center">
            🎉 Nenhuma denúncia aberta encontrada no momento!
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>