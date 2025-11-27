<?php

require_once 'conexao.php';

if (isset($_GET['acao']) && $_GET['acao'] == 'resolver' && isset($_GET['id'])) {
    $id_denuncia = $_GET['id'];
    
    $sql_update = "UPDATE denuncias SET status = 'Resolvido', data_resolucao = NOW() WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $id_denuncia); 
    
    if ($stmt_update->execute()) {
        header("Location: lista_denuncias.php?status=atualizado");
        exit();
    }
}

$sql_select = "SELECT id, tipo_denuncia, detalhes, latitude, longitude, status, data_criacao FROM denuncias ORDER BY data_criacao DESC";
$resultado = $conn->query($sql_select);

if ($resultado->num_rows > 0) {
    $denuncias = $resultado->fetch_all(MYSQLI_ASSOC);
} else {
    $denuncias = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Denúncias - Cidadão Alerta</title>
    
    <style>
        .logo-header {
            background-color: #008CBA; 
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 2.8em;
            margin-bottom: 25px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo-header span {
            font-weight: bold;
            color: #4CAF50;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #008CBA;
            color: white;
        }
    </style>
</head>
<body>
    
    <div class="logo-header">
        Aqua<span>Denuncia</span>
    </div>
    <h1>Lista de Denúncias Recebidas</h1>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'atualizado'): ?>
        <p style="color: #4CAF50; font-weight: bold; text-align: center;">Status da denúncia atualizado com sucesso!</p>
    <?php endif; ?>

    <?php if (empty($denuncias)): ?>
        <p style="text-align: center;">Não há denúncias registradas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Detalhes</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($denuncias as $d): ?>
                <tr>
                    <td><?php echo htmlspecialchars($d['id']); ?></td>
                    <td><?php echo htmlspecialchars($d['tipo_denuncia']); ?></td>
                    <td><?php echo htmlspecialchars($d['detalhes']); ?></td>
                    <td><?php echo htmlspecialchars($d['latitude']); ?></td>
                    <td><?php echo htmlspecialchars($d['longitude']); ?></td>
                    <td><?php echo htmlspecialchars($d['data_criacao']); ?></td>
                    <td>
                        <?php 
                            $status_color = ($d['status'] == 'Pendente') ? 'orange' : '#4CAF50';
                            echo '<span style="color: ' . $status_color . '; font-weight: bold;">' . htmlspecialchars($d['status']) . '</span>'; 
                        ?>
                    </td>
                    <td>
                        <?php if ($d['status'] == 'Pendente'): ?>
                            <a href="lista_denuncias.php?acao=resolver&id=<?php echo $d['id']; ?>" 
                               onclick="return confirm('Tem certeza que deseja marcar como Resolvida?');" 
                               style="color: #008CBA; font-weight: bold;">
                                **Resolver**
                            </a>
                        <?php else: ?>
                            Resolvido
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="text-align: center; margin-top: 20px;"><a href="login.html" style="color: #008CBA;">Voltar para o formulário de denúncia</a></p>

</body>
</html>