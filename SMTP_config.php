<?php
/* параметры подключения к почтовому серверу
•	Имя пользователя: keks@phpdemo.ru;
•	Отправитель: keks@phpdemo.ru;
•	Пароль: htmlacademy;
•	SMTP сервер: phpdemo.ru;
•	Порт: 25;
•	Шифрование: нет.
*/
$username = 'keks@phpdemo.ru';
$host = 'smtp.phpdemo.ru';
$port = 25;
$password = 'htmlacademy';
$sender = 'keks@phpdemo.ru';
$transport = (new Swift_SmtpTransport($host, $port))
    ->setUsername($username)
    ->setPassword($password);
