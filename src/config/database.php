<?php
// src/config/database.php

class Database {
    private $host = "localhost"; // Geralmente 'localhost'
    private $db_name = "memory_game_db"; // Nome do seu banco de dados
    private $username = "root"; // Seu usuário do MySQL
    private $password = "root"; // Sua senha do MySQL

    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>