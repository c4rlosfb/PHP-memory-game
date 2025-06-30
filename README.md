# 🧠 Jogo da Memória com PHP e MySQL

Este é um projeto acadêmico/pessoal que implementa o clássico Jogo da Memória com uma aplicação web full-stack, utilizando PHP para o backend, MySQL para o armazenamento de dados e JavaScript puro para a interatividade do frontend.

O sistema conta com cadastro de usuários, login, modo de 1 e 2 jogadores, histórico de partidas e um ranking geral de jogadores.

![alt text](/public/IMG/image-8.png)
![alt text](/public/IMG/image-9.png)
![alt text](/public/IMG/image-10.png)
![alt text](/public/IMG/image-11.png)
![alt text](/public/IMG/image-12.png)
![alt text](/public/IMG/image-14.png)
![alt text](/public/IMG/image-15.png)
![alt text](/public/IMG/image-16.png)
![alt text](/public/IMG/image-17.png)

-----

## ✨ Funcionalidades Principais

  * **👤 Autenticação de Usuários:** Sistema completo de Cadastro e Login.
  * **🔑 Segurança:** Senhas armazenadas de forma segura com criptografia (hash).
  * **🎮 Modos de Jogo:**
      * **1 Jogador:** Jogue contra o tempo e tente bater seus recordes.
      * **2 Jogadores (Local):** Dispute com um amigo, inserindo o nome do segundo jogador.
  * **📊 Placar Dinâmico:** O placar é atualizado em tempo real, mudando de cor para indicar a vez de cada jogador.
  * **💾 Persistência de Dados:** Os resultados de cada partida são salvos no banco de dados.
  * **🏆 Histórico e Ranking:**
      * Página de **Histórico** individual para o usuário logado.
      * Página de **Ranking Geral** que classifica os jogadores por vitórias e tempo médio.
  * **🖥️ Interface Interativa:** Interface fluida e responsiva construída com HTML, CSS e JavaScript, sem o uso de frameworks.

-----

## 🛠️ Tecnologias Utilizadas

  * **Frontend:**
      * HTML5
      * CSS3
      * JavaScript (ES6+)
      * AJAX (Fetch API)
  * **Backend:**
      * PHP 8+
  * **Banco de Dados:**
      * MySQL
  * **Ambiente de Desenvolvimento:**
      * Servidor Web (Apache, Nginx, etc.)
      * MySQL Workbench (para gerenciamento do BD)

-----

## 🚀 Instalação e Configuração

Siga os passos abaixo para rodar o projeto em seu ambiente local.

### Pré-requisitos

  * Um servidor web com suporte a PHP (como Apache)
  * Servidor de Banco de Dados MySQL
  * Um navegador web moderno

### Passo a Passo

1.  **Clone o Repositório**

    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    cd seu-repositorio
    ```

2.  **Configure o Banco de Dados**

      * Abra seu gerenciador de banco de dados (MySQL Workbench, por exemplo).
      * Crie um novo banco de dados chamado `memory_game_db`.
      * Execute o script SQL abaixo para criar todas as tabelas e o trigger de atualização do ranking.


    ```sql
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
        tempo INT,
        modo ENUM('1_jogador', '2_jogadores') NOT NULL,
        vencedor VARCHAR(255),
        pontos INT,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    );

    -- Tabela de Ranking
    CREATE TABLE ranking (
        usuario_id INT PRIMARY KEY,
        total_partidas INT DEFAULT 0,
        vitorias INT DEFAULT 0,
        tempo_medio INT DEFAULT 0,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    );

    -- Gatilho (TRIGGER) para atualizar o ranking automaticamente
    DELIMITER //
    CREATE TRIGGER after_partida_insert
    AFTER INSERT ON partidas
    FOR EACH ROW
    BEGIN
        DECLARE v_tempo_medio INT;
        DECLARE user_name_from_id VARCHAR(255);
        SELECT nome INTO user_name_from_id FROM usuarios WHERE id = NEW.usuario_id;
        INSERT INTO ranking (usuario_id, total_partidas, vitorias)
        VALUES (NEW.usuario_id, 1, IF(NEW.vencedor = user_name_from_id, 1, 0))
        ON DUPLICATE KEY UPDATE
            total_partidas = total_partidas + 1,
            vitorias = vitorias + IF(NEW.vencedor = user_name_from_id, 1, 0);
        SELECT AVG(tempo) INTO v_tempo_medio
        FROM partidas
        WHERE usuario_id = NEW.usuario_id AND vencedor = user_name_from_id;
        UPDATE ranking
        SET tempo_medio = IFNULL(v_tempo_medio, 0)
        WHERE usuario_id = NEW.usuario_id;
    END;
    //
    DELIMITER ;
    ```


3.  **Configure a Conexão PHP**

      * Abra o arquivo `src/config/database.php`.
      * Altere as variáveis `$host`, `$username` e `$password` com as credenciais do seu banco de dados MySQL local.

    <!-- end list -->

    ```php
    class Database {
        private $host = "127.0.0.1";
        private $db_name = "memory_game_db";
        private $username = "root";
        private $password = "sua-senha-aqui"; // <-- MUDE AQUI
        // ...
    }
    ```

4.  **Inicie o Servidor**

      * Coloque a pasta do projeto no diretório raiz do seu servidor web (ex: `htdocs` no XAMPP, `www` no WAMP).
      * Certifique-se de que os serviços Apache e MySQL estão em execução.

5.  **Acesse o Jogo**

      * Abra seu navegador e acesse `http://localhost/nome-da-pasta-do-projeto/public/`.

-----

## 📺 Vídeo de Demonstração

Para uma visão geral do projeto e uma explicação detalhada do código e de seu funcionamento, assista ao vídeo abaixo:

**[Clique aqui para assistir ao vídeo de apresentação do projeto](https://www.google.com/search?q=https://www.youtube.com/LINK_DO_SEU_VIDEO)**

*(Lembre-se de gravar o vídeo, subi-lo no YouTube ou outra plataforma e substituir o link acima\!)*

-----

## 👥 Participantes

Este projeto foi desenvolvido com dedicação por:

  * **[Carlos Felipe Barbosa]** - ([@c4rlosfb](https://github.com/c4rlosfb))
  * **[Celso Augusto de Oliveira Junior]** - ([@Celso](https://github.com/celsohd21))

