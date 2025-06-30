<?php
// src/controllers/AuthController.php

require_once '../config/database.php';

session_start(); // Inicia a sessão PHP (apenas uma vez para este script)

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'register':
            registerUser($db);
            break;
        case 'login':
            loginUser($db);
            break;
        case 'logout':
            logoutUser();
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
            break;
    }
}

function registerUser($db) {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirm_senha = $_POST['confirm_senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha) || empty($confirm_senha)) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
        return;
    }

    if ($senha !== $confirm_senha) {
        echo json_encode(['success' => false, 'message' => 'As senhas não coincidem.']);
        return;
    }

    // Verificar se o email já existe
    $query = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado.']);
        return;
    }

    // Criptografar a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir usuário no banco de dados
    $query = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (:nome, :email, :senha_hash)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha_hash', $senha_hash);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar usuário.']);
    }
}

function loginUser($db) {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        echo json_encode(['success' => false, 'message' => 'E-mail e senha são obrigatórios.']);
        return;
    }

    $query = "SELECT id, nome, senha_hash FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $row['senha_hash'];

        if (password_verify($senha, $hashed_password)) {
            // Login bem-sucedido, armazena informações na sessão
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nome'];
            echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso!', 'redirect' => 'game.php']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Senha incorreta.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    }
}

function logoutUser() {
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destrói a sessão
    echo json_encode(['success' => true, 'message' => 'Deslogado com sucesso!', 'redirect' => 'index.php']);
}
?>