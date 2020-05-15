<?php
require('vendor/autoload.php');
require_once('init.php');
require_once('SMTP_config.php');

/**
 * Отправка уведомления о предстоящих задачах
 * @param string $email email получателя
 * @param string $mes Текст Сообщения
 */
function send_message($email, $mes, $transport, $sender, $username)
{
    // Формирование сообщения
    $message = new Swift_Message("Уведомление от сервиса \"Дела в порядке\"");
    $message->setTo(["$email" => "$email"]);
    $message->setBody("$mes");
    $message->setFrom($sender, $username);
    // Отправка сообщения
    $mailer = new Swift_Mailer($transport);
    $mailer->send($message);
}

$notifications = notifications($con);
$count = count($notifications);
if ($count) {
    $previous = $notifications[0];
    for ($i = 1; $i < $count; $i++) {
        $current = $notifications[$i];
        if ($previous['email'] === $current['email']) {
            $previous['name_task'] = $previous['name_task'] . "\n"
                . $current['name_task'];
        } else {
            $text = "Уважаемый, " . $previous['user_name'] . ".  У вас запланирована задача \n" .
                $previous['name_task'] . " на " . $previous['date_of_completion'] . ".";
            send_message($previous['email'], $text, $transport, $sender, $username);
            $previous = $current;
        }
    }
    $text = "Уважаемый, " . $previous['user_name'] . ".  У вас запланирована задача \n" .
        $previous['name_task'] . " на " . $previous['date_of_completion'] . ".";
    send_message($previous['email'], $text, $transport, $sender, $username);
}


