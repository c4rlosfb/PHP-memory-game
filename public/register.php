<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Jogo da Memória</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastre-se</h1>
        <form id="registerForm">
            <label for="nome">Nome de Usuário:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="confirm_senha">Confirmar Senha:</label>
            <input type="password" id="confirm_senha" name="confirm_senha" required>

            <button type="submit">Cadastrar</button>
            <p id="registerMessage" class="message"></p>
        </form>
        <p>Já tem uma conta? <a href="login.php">Faça login aqui!</a></p>
    </div>
    <script src="js/auth.js"></script>
    <?php include '../src/views/footer.php'; ?>