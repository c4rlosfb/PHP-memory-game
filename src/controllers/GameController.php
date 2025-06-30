<?php
// src/controllers/GameController.php

require_once '../config/database.php';
require_once '../helpers/session_helper.php'; // Para pegar o ID do usuário

session_start(); // Inicia a sessão para este controller
require_login(); // Garante que o usuário esteja logado para acessar este controller

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'save_game':
            saveGameResult($db);
            break;
        case 'get_history': // Para o histórico
            getHistory($db);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
            break;
    }
}

function saveGameResult($db) {
    $user_id = get_current_user_id();
    $tempo = $_POST['time'] ?? 0;
    $modo = $_POST['mode'] ?? ''; // Será '1_jogador' ou '2_jogadores'
    $vencedor = $_POST['winner'] ?? '';
    $pontos = $_POST['points'] ?? 0;

    if (!$user_id) {
        echo json_encode(['success' => false, 'message' => 'Usuário não logado.']);
        return;
    }

    if (empty($modo) || empty($vencedor)) {
        echo json_encode(['success' => false, 'message' => 'Dados incompletos para salvar a partida.']);
        return;
    }

    $query = "INSERT INTO partidas (usuario_id, tempo, modo, vencedor, pontos) VALUES (:usuario_id, :tempo, :modo, :vencedor, :pontos)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':usuario_id', $user_id);
    $stmt->bindParam(':tempo', $tempo);
    $stmt->bindParam(':modo', $modo);
    $stmt->bindParam(':vencedor', $vencedor);
    $stmt->bindParam(':pontos', $pontos);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Partida salva com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar partida: ' . $stmt->errorInfo()[2]]); // Adicionado erro para debug
    }
}

function getHistory($db) {
    $user_id = get_current_user_id();

    if (!$user_id) {
        echo json_encode(['success' => false, 'message' => 'Usuário não logado.']);
        return;
    }

    $query = "SELECT data, tempo, modo, vencedor, pontos FROM partidas WHERE usuario_id = :user_id ORDER BY data DESC";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'history' => $history]);
}
?>