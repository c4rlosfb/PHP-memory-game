<?php
// public/history.php
session_start();
require_once '../src/helpers/session_helper.php';
require_once '../src/config/database.php';
require_login();

// --- LÓGICA PHP PARA BUSCAR O HISTÓRICO ---
$history_data = [];
$error_message = '';
$user_id = get_current_user_id();

try {
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT data, tempo, modo, vencedor, pontos 
              FROM partidas 
              WHERE usuario_id = :user_id 
              ORDER BY data DESC";
              
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $history_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $error_message = 'Erro ao carregar o histórico. Tente novamente mais tarde.';
}
// --- FIM DA LÓGICA PHP ---
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Partidas - Jogo da Memória</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Histórico de Partidas de <?php echo htmlspecialchars(get_current_user_name()); ?></h1>
        <table class="styled-table" id="historyTable">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Tempo</th>
                    <th>Modo</th>
                    <th>Vencedor</th>
                    <th>Pontos</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($error_message): ?>
                    <tr>
                        <td colspan="5"><?php echo htmlspecialchars($error_message); ?></td>
                    </tr>
                <?php elseif (empty($history_data)): ?>
                    <tr>
                        <td colspan="5">Nenhuma partida encontrada.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($history_data as $match): ?>
                        <tr>
                            <td><?php echo htmlspecialchars(date('d/m/Y H:i:s', strtotime($match['data']))); ?></td>
                            <td>
                                <?php
                                    $minutes = floor($match['tempo'] / 60);
                                    $seconds = $match['tempo'] % 60;
                                    echo sprintf('%02d:%02d', $minutes, $seconds);
                                ?>
                            </td>
                            <td><?php echo $match['modo'] === '1_jogador' ? '1 Jogador' : '2 Jogadores'; ?></td>
                            <td><?php echo htmlspecialchars($match['vencedor']); ?></td>
                            <td><?php echo htmlspecialchars($match['pontos']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <p><a href="game.php">Voltar para o jogo</a></p>
    </div>
    <?php include '../src/views/footer.php'; ?>
</body>
</html>