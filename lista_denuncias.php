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
    } else {
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
    </head>
<body>
    <h1>Lista de Denúncias Recebidas</h1>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'atualizado'): ?>
        <p style="color: green;">Status da denúncia atualizado com sucesso!</p>
    <?php endif; ?>

    <?php if (empty($denuncias)): ?>
        <p>Não há denúncias registradas.</p>
    <?php else: ?>
        <table border="1">
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
                    <td><?php echo htmlspecialchars($d['status']); ?></td>
                    <td>
                        <?php if ($d['status'] == 'Pendente'): ?>
                            <a href="lista_denuncias.php?acao=resolver&id=<?php echo $d['id']; ?>" 
                               onclick="return confirm('Tem certeza que deseja marcar esta denúncia como resolvida?');">
                                Resolver
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

    <p><a href="login.html">Voltar para o formulário de denúncia</a></p>

</body>
</html>