<?php
require_once('init.php');
$user = [];
$errors = [];
$rules = [
    'email' => function () {
        $empty = validateFilled($_POST['email']);
        if ($empty) {
            return $empty;
        }
        return validate_email($_POST['email']);
    },
    'password' => function () {
        return validateFilled($_POST['password']);
    }
];

if (isset($_POST['auth'])) {
    $errors = validation_form($rules);
    $errors = array_filter($errors);
    if (!count($errors)) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = read_user($email, $con);
        if (isset($user[0]['email'])) {
            if (password_verify($password, $user[0]['password'])) {
                $_SESSION['user_name'] = $user[0]['name'];
                $_SESSION['user_id'] = $user[0]['id_user'];
                header("Location: /index.php?");
            }
        }
        $errors['auth'] = "Неверный email или пароль";
    }
}
$page_content = include_template('auth.php', [
        'con' => $con,
        'errors' => $errors
    ]
);
$layout_content = include_template('layout.php',
    ['content' => $page_content, 'title' => 'Регистрация', 'user' => $user]);

print($layout_content);
