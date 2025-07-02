CREATE DATABASE memory_game_db;
USE memory_game_db;

-- Tabela de Usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Partidas
CREATE TABLE partidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    tempo INT, -- Tempo em segundos
    modo ENUM('1_jogador', '2_jogadores') NOT NULL,
    vencedor VARCHAR(255), -- Pode ser o nome do usuário ou 'Empate'/'Jogador 1'/'Jogador 2'
    pontos INT, -- Pontuação do jogador (ou jogador 1 se for 2 jogadores)
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de Ranking
CREATE TABLE ranking (
    usuario_id INT PRIMARY KEY,
    total_partidas INT DEFAULT 0,
    vitorias INT DEFAULT 0,
    tempo_medio INT DEFAULT 0, -- Tempo médio em segundos para partidas ganhas
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Gatilhos (TRIGGERS) para atualizar o ranking automaticamente
DROP TRIGGER IF EXISTS after_partida_insert;

-- Cria o novo trigger com a lógica para derrotas e empates
DELIMITER //
CREATE TRIGGER after_partida_insert
AFTER INSERT ON partidas
FOR EACH ROW
BEGIN
    DECLARE v_tempo_medio INT;
    DECLARE user_name_from_id VARCHAR(255);

    -- Pega o nome do usuário que jogou (sempre o jogador 1)
    SELECT nome INTO user_name_from_id FROM usuarios WHERE id = NEW.usuario_id;

    -- Tenta inserir um novo registro no ranking ou atualiza um existente
    INSERT INTO ranking (usuario_id, total_partidas, vitorias, derrotas, empates)
    VALUES (
        NEW.usuario_id,
        1,
        IF(NEW.vencedor = user_name_from_id, 1, 0), -- Incrementa vitória se o vencedor for o jogador 1
        IF(NEW.vencedor != user_name_from_id AND NEW.vencedor != 'Empate', 1, 0), -- Incrementa derrota se o vencedor NÃO for o jogador 1 e NÃO for empate
        IF(NEW.vencedor = 'Empate', 1, 0) -- Incrementa empate se o resultado for 'Empate'
    )
    ON DUPLICATE KEY UPDATE
        total_partidas = total_partidas + 1,
        vitorias = vitorias + IF(NEW.vencedor = user_name_from_id, 1, 0),
        derrotas = derrotas + IF(NEW.vencedor != user_name_from_id AND NEW.vencedor != 'Empate', 1, 0),
        empates = empates + IF(NEW.vencedor = 'Empate', 1, 0);

    -- Recalcula o tempo médio APENAS para partidas que o usuário venceu
    SELECT AVG(tempo) INTO v_tempo_medio
    FROM partidas
    WHERE usuario_id = NEW.usuario_id AND vencedor = user_name_from_id;

    -- Atualiza o tempo médio no ranking
    UPDATE ranking
    SET tempo_medio = IFNULL(v_tempo_medio, 0)
    WHERE usuario_id = NEW.usuario_id;
END;
//
DELIMITER ;