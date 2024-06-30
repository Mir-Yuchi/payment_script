<?php
$name = 'Payment'; // Имя платежки

$phone = '+79520047753'; // Номер телефона к котому привязан юмани (Будет виден для СБП)
$card = '2204120117343125'; // Номер карты YooMoney (МИР - будет виден для перевода)
$ym_token = '4100118725729312.96962D4AA044F0A81B0A0CFEB0A01A7C8C48924B41E6765F5BED55AC945C8AF7937E3AAB37F4FA7A845A71EADC4B61E83E60A2435DAABA5DE7FA8A17961F23F46718762E5EFC43E16FB6E7CABFBE6984DB1A113A6C0BBD3904001B6830E1DB588A4EA4BC201C98A392AEE895B6512C402BC8E9C7EC9DC87711CA05B6FFDFFB0A';
// Токен от YooMoney - получаем по гайду 
$ym_secret = 'wq15BaWmKYBGN3edK35BSqUj
'; // Секретный ключ со страницы https://yoomoney.ru/transfer/myservices/http-notification
$ym_number = '4100118725729312'; // Номер кошелька YooMoney

// Формат номеров для перевода (Номер, формат команды, с переменными CARD; SUM)
// Не рекомендуется трогать
$beeline_send = ["7878", "Mir %CARD% %SUM%"];
$mts_send = ["6111", "card %CARD% %SUM%"];
$megafon_send = ["8900", "card %CARD% %SUM%"];

$mysql = new mysqli('localhost', 'root', 'vertrigo', 'pay_db'); // host, user, password, db
$success_url = 'https://cvlture.studio/status.php'; // путь к status.php

$secret_key = '5710610322:AAGLIQeXbPkY1kytmw73eVE9wvF2JWiWinE';  