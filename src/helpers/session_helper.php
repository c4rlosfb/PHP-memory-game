<?php
// src/helpers/session_helper.php

function require_login() {
    // session_start(); // REMOVIDO: session_start() deve ser chamado apenas uma vez no topo do script PHP
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
}

function get_current_user_id() {
    // session_start(); // REMOVIDO
    return $_SESSION['user_id'] ?? null;
}

function get_current_user_name() {
    // session_start(); // REMOVIDO
    return $_SESSION['user_name'] ?? null;
}
?>