<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Авторизация через Steam</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            .centered {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #121212;
                color: #ffffff;
            }
            .box {
                background-color: #1e1e1e;
                color: #ffffff;
            }
            .button.is-link {
                background-color: #3b3b3b;
                color: #ffffff;
            }
            .button.is-link:hover {
                background-color: #575757;
            }
        </style>
    </head>
    <body>
        <?php if(isset($_SESSION['steam_id'])): ?>
            <section class="section centered">
                <div class="container has-text-centered">
                    <h1 class="title has-text-light">Вы авторизованы!</h1>
                    <p class="has-text-light">Ваш Steam ID: <span class="has-text-weight-bold"><?= htmlspecialchars($_SESSION['steam_id']) ?></span></p>
                </div>
            </section>
        <?php else: ?>
            <section class="section centered">
                <div class="container" data-aos="fade-up">
                    <div class="columns is-centered">
                        <div class="column is-half">
                            <div class="box">
                                <div class="field">
                                    <div class="control">
                                        <a href="#" id="auth-steam" class="button is-link is-fullwidth is-medium">
                                            <span class="icon">
                                                <i class="fab fa-steam"></i>
                                            </span>
                                            <span>Авторизоваться</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
        <script>
        // Если эта страница открыта в качестве всплывающего окна после авторизации,
        // отправляем родительскому окну полученный steamid и закрываем окно.
        (function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('close')) {
                const steamid = urlParams.get('steamid');
                if (steamid && window.opener) {
                    window.opener.postMessage({ steamid: steamid }, window.location.origin);
                }
                window.close();
            }
        })();
        
        // Обработчик клика по кнопке "Авторизоваться"
        document.getElementById('auth-steam') && document.getElementById('auth-steam').addEventListener('click', function(e) {
            e.preventDefault();
            // Используем текущий URL как success и failure URL
            const currentUrl = window.location.origin + window.location.pathname;
            const successUrl = encodeURIComponent(currentUrl);
            const failureUrl = encodeURIComponent(currentUrl);
            // Формируем URL для файла авторизации
            const authUrl = `SteamAuthLite/Auth.php?success_url=${successUrl}&failure_url=${failureUrl}`;
            
            const width = 800, height = 600;
            const left = (screen.width / 2) - (width / 2);
            const top = (screen.height / 2) - (height / 2);
            // Открываем окно авторизации
            const authWindow = window.open(authUrl, '_blank', `width=${width},height=${height},top=${top},left=${left}`);
            
            // Слушаем сообщение от всплывающего окна (когда придёт steamid)
            window.addEventListener('message', function(event) {
                if (event.origin === window.location.origin && event.data.steamid) {
                    // Обновление страницы для отображения авторизации
                    location.reload();
                }
            });
        });
        </script>
    </body>
</html>