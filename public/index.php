<?php
// public/index.php
session_start(); // Inicia a sessão para verificar se o usuário já está logado

// Se o usuário já estiver logado, redireciona para a página do jogo
if (isset($_SESSION['user_id'])) {
    header('Location: game.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo da Memória - Bem-vindo!</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Jogo da Memória!</h1>
        <p>Teste sua memória e divirta-se encontrando os pares de cartas.</p>
        <p>Para começar a jogar, faça login ou cadastre-se.</p>

        <div class="options">
            <a href="login.php"><button>Fazer Login</button></a>
            <a href="register.php"><button>Criar Conta</button></a>
        </div>

        <p class="small-text">Este é um projeto para praticar suas habilidades em PHP, CSS, JavaScript e MySQL.</p>
    </div>
    <?php include '../src/views/footer.php'; ?>