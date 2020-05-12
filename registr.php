<?php
require_once('init.php');
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
    },
    'name' => function () {
        return validateFilled($_POST['name']);
    }
];

if (isset($_POST['add_user'])) {
    $errors = validation_form($rules);
    if (!isset($errors['email'])) {
        $errors['email'] = unique_email($_POST['email'], $con);
    }
    $errors = array_filter($errors);
    if (!count($errors)) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        write_user($name, $email, $password, $con);
        header("Location: /index.php?");

    }
}
$page_content = include_template('new_user.php', [
        'con' => $con,
        'errors' => $errors
    ]
);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Регистрация', 'user' => []]);

print($layout_content);
