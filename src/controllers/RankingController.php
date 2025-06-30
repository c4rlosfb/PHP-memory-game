<?php
// src/controllers/RankingController.php

require_once '../config/database.php';
require_once '../helpers/session_helper.php';

session_start(); // Inicia a sessão para este controller
require_login(); // Garante que o usuário esteja logado

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'get_ranking':
            getRanking($db);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
            break;
    }
}

function getRanking($db) {
    // Ordenar por vitórias (desc), tempo_medio (asc) e total_partidas (desc)
    $query = "SELECT u.nome, r.total_partidas, r.vitorias, r.tempo_medio
              FROM ranking r
              JOIN usuarios u ON r.usuario_id = u.id
              ORDER BY r.vitorias DESC, r.tempo_medio ASC, r.total_partidas DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'ranking' => $ranking]);
}
?>