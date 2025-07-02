# 🧠 Jogo da Memória com PHP e MySQL

Este é um projeto acadêmico/pessoal que implementa o clássico Jogo da Memória com uma aplicação web full-stack, utilizando PHP para o backend, MySQL para o armazenamento de dados e JavaScript puro para a interatividade do frontend.

O sistema conta com cadastro de usuários, login, modo de 1 e 2 jogadores, histórico de partidas e um ranking geral de jogadores.

![Screenshot do Game](/assets/Screenshot.png)

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
    git clone https://github.com/c4rlosfb/PHP-memory-game.git
    cd PHP-memory-game
    ```

2.  **Configure o Banco de Dados**

      * Abra seu gerenciador de banco de dados (MySQL Workbench, por exemplo).
      * Crie um novo banco de dados chamado `memory_game_db`.
      * Execute o script SQL que está no caminho `public/sql/database.sql` para criar as tabelas necessárias.

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

-----

## 👥 Participantes

Este projeto foi desenvolvido com dedicação por:

  * **[Carlos Felipe Barbosa]** - ([@c4rlosfb](https://github.com/c4rlosfb)) 
  * **[Celso Augusto de Oliveira Junior]** - ([@Celso](https://github.com/celsohd21))
---

## 📝 Licença

Este projeto está licenciado sob a Licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

