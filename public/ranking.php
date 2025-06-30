<?php
// public/ranking.php
session_start();
require_once '../src/helpers/session_helper.php';
require_once '../src/config/database.php'; // Incluímos a conexão com o BD
require_login();

// --- LÓGICA PHP PARA BUSCAR O RANKING ---
$ranking_data = [];
$error_message = '';

try {
    $database = new Database();
    $db = $database->getConnection();

    // Query para buscar o ranking, agora incluindo derrotas e empates
    $query = "SELECT u.nome, r.total_partidas, r.vitorias, r.derrotas, r.empates, r.tempo_medio
              FROM ranking r
              JOIN usuarios u ON r.usuario_id = u.id
              ORDER BY r.vitorias DESC, r.derrotas ASC, r.tempo_medio ASC"; // Ordena por vitórias (mais é melhor), depois derrotas (menos é melhor)

    $stmt = $db->prepare($query);
    $stmt->execute();
    $ranking_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $error_message = 'Erro ao carregar o ranking. Tente novamente mais tarde.';
}
// --- FIM DA LÓGICA PHP ---
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Geral - Jogo da Memória</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Ranking Geral</h1>
        <table class="styled-table" id="rankingTable">
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Nome do Usuário</th>
                    <th>Partidas</th>
                    <th>Vitórias</th>
                    <th>Derrotas</th> <th>Empates</th>  <th>Tempo Médio</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($error_message): ?>
                    <tr>
                        <td colspan="7"><?php echo htmlspecialchars($error_message); ?></td>
                    </tr>
                <?php elseif (empty($ranking_data)): ?>
                    <tr>
                        <td colspan="7">Nenhum jogador no ranking ainda.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($ranking_data as $index => $player): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($player['nome']); ?></td>
                            <td><?php echo htmlspecialchars($player['total_partidas']); ?></td>
                            <td><?php echo htmlspecialchars($player['vitorias']); ?></td>
                            <td><?php echo htmlspecialchars($player['derrotas']); ?></td> <td><?php echo htmlspecialchars($player['empates']); ?></td>  <td>
                                <?php
                                    $minutes = floor($player['tempo_medio'] / 60);
                                    $seconds = $player['tempo_medio'] % 60;
                                    echo sprintf('%02d:%02d', $minutes, $seconds);
                                ?>
                            </td>
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