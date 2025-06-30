// public/js/auth.js

document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');
    const registerMessage = document.getElementById('registerMessage');
    const loginMessage = document.getElementById('loginMessage');

    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(registerForm);
            formData.append('action', 'register');

            try {
                const response = await fetch('../src/controllers/AuthController.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                registerMessage.textContent = data.message;
                registerMessage.style.color = data.success ? 'green' : 'red';
                if (data.success) {
                    registerForm.reset(); // Limpa o formulário após sucesso
                    setTimeout(() => {
                        window.location.href = 'login.php'; // Redireciona para login
                    }, 1500);
                }
            } catch (error) {
                console.error('Erro ao cadastrar:', error);
                registerMessage.textContent = 'Erro ao conectar com o servidor.';
                registerMessage.style.color = 'red';
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            formData.append('action', 'login');

            try {
                const response = await fetch('../src/controllers/AuthController.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                loginMessage.textContent = data.message;
                loginMessage.style.color = data.success ? 'green' : 'red';
                if (data.success && data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                }
            } catch (error) {
                console.error('Erro ao fazer login:', error);
                loginMessage.textContent = 'Erro ao conectar com o servidor.';
                loginMessage.style.color = 'red';
            }
        });
    }

    // Exemplo de como fazer logout (pode ser um botão na página game.php)
    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', async () => {
            const formData = new FormData();
            formData.append('action', 'logout');

            try {
                const response = await fetch('../src/controllers/AuthController.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                }
            } catch (error) {
                console.error('Erro ao fazer logout:', error);
            }
        });
    }
});