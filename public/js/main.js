// public/js/main.js - VERSÃO FINAL COMPLETA

document.addEventListener('DOMContentLoaded', () => {
    // Seletores de elementos DOM
    const gameBoard = document.getElementById('gameBoard');
    const matchedPairsDisplay = document.getElementById('matchedPairs');
    const attemptsDisplay = document.getElementById('attempts');
    const timerDisplay = document.getElementById('timer');
    const resetButton = document.getElementById('resetButton');
    const singlePlayerBtn = document.getElementById('singlePlayerBtn');
    const twoPlayersBtn = document.getElementById('twoPlayersBtn');
    const playerTurnDisplay = document.getElementById('playerTurnDisplay');
    const initialMessage = document.querySelector('.initial-message');
    const modeSelection = document.querySelector('.mode-selection');
    const gameContentWrapper = document.querySelector('.game-content-wrapper');
    const twoPlayerSetup = document.getElementById('twoPlayerSetup');
    const player2NameInput = document.getElementById('player2Name');
    const startTwoPlayerGameBtn = document.getElementById('startTwoPlayerGameBtn');

    // Variáveis de estado do jogo
    let cards = [], flippedCards = [], matchedPairs = 0, attempts = 0;
    let timerInterval, seconds = 0, gameStarted = false, gameMode = '';
    let currentPlayer = 1, player1Score = 0, player2Score = 0;
    let player1Name = currentUserName;
    let player2Name = '';

    const cardValues = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

    // Funções de controle da UI
    function showModeSelection() {
        initialMessage.classList.remove('hidden');
        modeSelection.classList.remove('hidden');
        twoPlayerSetup.classList.add('hidden');
        gameContentWrapper.classList.add('hidden');
        playerTurnDisplay.classList.add('hidden');
    }

    function showTwoPlayerSetup() {
        initialMessage.classList.add('hidden');
        modeSelection.classList.add('hidden');
        twoPlayerSetup.classList.remove('hidden');
    }

    function showGameArea() {
        twoPlayerSetup.classList.add('hidden');
        gameContentWrapper.classList.remove('hidden');
        playerTurnDisplay.classList.remove('hidden');
    }

    // Função principal de inicialização do jogo
    function initializeGame(mode, p2Name = 'Jogador 2') {
        gameMode = mode;
        if (gameMode === '2_jogadores') {
            player2Name = p2Name;
        }
        
        cards = []; flippedCards = []; matchedPairs = 0; attempts = 0;
        seconds = 0; player1Score = 0; player2Score = 0; currentPlayer = 1;
        gameStarted = false;

        clearInterval(timerInterval);
        timerDisplay.textContent = '00:00';
        matchedPairsDisplay.textContent = '0';
        attemptsDisplay.textContent = '0';
        gameBoard.innerHTML = '';

        showGameArea();
        const shuffledCards = shuffle([...cardValues, ...cardValues]);
        createCards(shuffledCards);
        updatePlayerTurnDisplay();
    }

    // Função que atualiza o texto e a COR da vez do jogador
    function updatePlayerTurnDisplay() {
        playerTurnDisplay.classList.remove('player-1-turn', 'player-2-turn');

        if (gameMode === '1_jogador') {
            playerTurnDisplay.innerHTML = 'Modo: 1 Jogador';
        } else {
            const turnName = currentPlayer === 1 ? player1Name : player2Name;
            playerTurnDisplay.innerHTML = `Vez de: ${turnName}<br><span class="score-display">(Pares: ${player1Name}=${player1Score} | ${player2Name}=${player2Score})</span>`;
            if (currentPlayer === 1) {
                playerTurnDisplay.classList.add('player-1-turn');
            } else {
                playerTurnDisplay.classList.add('player-2-turn');
            }
        }
    }
    
    // Função para embaralhar as cartas
    function shuffle(array) {
        let currentIndex = array.length, randomIndex;
        while (currentIndex != 0) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex--;
            [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
        }
        return array;
    }

    // Função para criar as cartas no tabuleiro
    function createCards(shuffledValues) {
        shuffledValues.forEach((value) => {
            const card = document.createElement('div');
            card.classList.add('card');
            card.dataset.value = value;
            card.innerHTML = `<div class="card-inner"><div class="card-face card-back">?</div><div class="card-face card-front">${value}</div></div>`;
            card.addEventListener('click', handleCardClick);
            gameBoard.appendChild(card);
        });
    }

    // Função para iniciar o cronômetro
    function startTimer() {
        if (!gameStarted) {
            timerInterval = setInterval(() => {
                seconds++;
                const minutes = Math.floor(seconds / 60);
                timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds % 60).padStart(2, '0')}`;
            }, 1000);
            gameStarted = true;
        }
    }

    // Função para lidar com o clique na carta
    function handleCardClick(event) {
        const clickedCard = event.currentTarget;
        if (clickedCard.classList.contains('flipped') || clickedCard.classList.contains('matched') || flippedCards.length === 2) {
            return;
        }
        startTimer();
        clickedCard.classList.add('flipped');
        flippedCards.push(clickedCard);
        if (flippedCards.length === 2) {
            processTurn();
        }
    }

    // Função para processar a jogada (verificar se o par combina)
    function processTurn() {
        attempts++;
        attemptsDisplay.textContent = attempts;
        const [card1, card2] = flippedCards;
        gameBoard.style.pointerEvents = 'none';

        if (card1.dataset.value === card2.dataset.value) {
            setTimeout(() => {
                matchedPairs++;
                if (gameMode === '2_jogadores') {
                    currentPlayer === 1 ? player1Score++ : player2Score++;
                }
                card1.classList.add('matched');
                card2.classList.add('matched');
                flippedCards = [];
                gameBoard.style.pointerEvents = 'auto';
                updatePlayerTurnDisplay();
                checkForWin();
            }, 800);
        } else {
            setTimeout(() => {
                card1.classList.remove('flipped');
                card2.classList.remove('flipped');
                if (gameMode === '2_jogadores') {
                    switchPlayer();
                }
                flippedCards = [];
                gameBoard.style.pointerEvents = 'auto';
            }, 1000);
        }
    }

    // Função para trocar o jogador
    function switchPlayer() {
        currentPlayer = currentPlayer === 1 ? 2 : 1;
        updatePlayerTurnDisplay();
    }

    // Função para verificar se o jogo terminou
    function checkForWin() {
        if (matchedPairs === cardValues.length) {
            clearInterval(timerInterval);
            let finalMessage = 'Parabéns! Você encontrou todos os pares!';
            if (gameMode === '2_jogadores') {
                if (player1Score > player2Score) {
                    finalMessage = `Fim de Jogo! ${player1Name} venceu com ${player1Score} pares!`;
                } else if (player2Score > player1Score) {
                    finalMessage = `Fim de Jogo! ${player2Name} venceu com ${player2Score} pares!`;
                } else {
                    finalMessage = 'Fim de Jogo! Houve um empate!';
                }
            }
            setTimeout(() => {
                alert(finalMessage);
                saveGameResult();
            }, 500);
        }
    }

    // Função para salvar o resultado do jogo no banco de dados
    async function saveGameResult() {
        let winner = '';
        let points = 0;

        if (gameMode === '1_jogador') {
            winner = player1Name;
            points = (cardValues.length * 100) - (attempts * 5);
        } else { // Modo 2 Jogadores
            if (player1Score > player2Score) {
                winner = player1Name;
            } else if (player2Score > player1Score) {
                winner = player2Name;
            } else {
                winner = 'Empate';
            }
            // A pontuação salva no BD é sempre a do jogador logado (Jogador 1)
            points = player1Score; 
        }

        const formData = new FormData();
        formData.append('action', 'save_game');
        formData.append('time', seconds);
        formData.append('mode', gameMode);
        formData.append('winner', winner);
        formData.append('points', points < 0 ? 0 : points);

        try {
            const response = await fetch('../src/controllers/GameController.php', { method: 'POST', body: formData });
            const data = await response.json();
            if (data.success) {
                window.location.href = 'ranking.php';
            } else {
                alert('Erro ao salvar o resultado: ' + data.message);
            }
        } catch (error) {
            alert('Erro de conexão ao salvar o resultado.');
        }
    }

    // Event Listeners (escutadores de eventos para os botões)
    singlePlayerBtn.addEventListener('click', () => initializeGame('1_jogador'));
    twoPlayersBtn.addEventListener('click', showTwoPlayerSetup);
    startTwoPlayerGameBtn.addEventListener('click', () => {
        let p2Name = player2NameInput.value.trim() || 'Jogador 2';
        initializeGame('2_jogadores', p2Name);
    });
    resetButton.addEventListener('click', () => {
        clearInterval(timerInterval);
        showModeSelection();
    });

    // Estado inicial da página ao carregar
    showModeSelection();
});