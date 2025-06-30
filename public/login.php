<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jogo da Memória</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form id="loginForm">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
            <p id="loginMessage" class="message"></p>
        </form>
        <p>Não tem uma conta? <a href="register.php">Cadastre-se aqui!</a></p>
    </div>
    <script src="js/auth.js"></script>
    <?php include '../src/views/footer.php'; ?>