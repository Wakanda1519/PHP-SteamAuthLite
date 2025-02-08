<?php
session_start();

require_once 'OpenID.php';

try {
    $openid = new LightOpenID($_SERVER['HTTP_HOST']);
    
    if (!$openid->mode) {
        // Инициируем запрос авторизации через Steam
        $openid->identity = 'http://steamcommunity.com/openid';
        header('Location: ' . $openid->authUrl());
        exit();

    } elseif ($openid->mode == 'cancel') {
        echo 'Пользователь отменил авторизацию.';
        exit();

    } else {
        if ($openid->validate()) {
            // Получаем Steam ID из идентификатора
            $_SESSION['steam_id'] = substr($openid->identity, strrpos($openid->identity, '/') + 1);
            $steamid = $_SESSION['steam_id'];
            // Перенаправляем на success_url с передачей steamid и флага close для закрытия окна
            header('Location: ' . $_GET['success_url'] . '?steamid=' . $steamid . '&close=1');
            exit();

        } else {
            header('Location: ' . $_GET['failure_url']);
            exit();
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
