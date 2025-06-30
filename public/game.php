<?php
// public/game.php
session_start();
require_once '../src/helpers/session_helper.php';
require_login();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo da Memória</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="game-container">
        <h1>Bem-vindo, <?php echo htmlspecialchars(get_current_user_name()); ?>!</h1>
        <div id="playerTurnDisplay" class="player-turn-display hidden"></div>
        <p class="initial-message">Selecione o modo de jogo:</p>
        <div class="mode-selection">
            <button id="singlePlayerBtn">1 Jogador</button>
            <button id="twoPlayersBtn">2 Jogadores</button>
        </div>

        <div id="twoPlayerSetup" class="two-player-setup hidden">
            <label for="player2Name">Nome do Jogador 2:</label>
            <input type="text" id="player2Name" placeholder="Digite o nome aqui">
            <button id="startTwoPlayerGameBtn">Iniciar Jogo</button>
        </div>

        <div class="game-content-wrapper hidden">
            <div id="gameBoard" class="game-board">
                </div>
            <div class="game-sidebar">
                <div class="game-info">
                    <p>Pares encontrados: <span id="matchedPairs">0</span></p>
                    <p>Tentativas: <span id="attempts">0</span></p>
                    <p>Tempo: <span id="timer">00:00</span></p>
                </div>
                <button id="resetButton" class="game-action-button">Reiniciar Jogo / Selecionar Modo</button>
                <div class="navigation-links">
                    <a href="history.php"><button class="nav-button">Histórico</button></a>
                    <a href="ranking.php"><button class="nav-button">Ranking</button></a>
                </div>
                <button id="logoutButton" class="logout-btn">Sair</button>
            </div>
        </div>
    </div>

    <script>
        const currentUserName = "<?php echo htmlspecialchars(get_current_user_name()); ?>";
    </script>
    <script src="js/auth.js"></script>
    <script src="js/main.js"></script>
    <?php include '../src/views/footer.php'; ?>
</body>
</html>