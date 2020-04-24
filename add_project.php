<?php
require_once('helpers.php');
require_once('data.php');
require_once('init.php');
session_start();
$user = [];
if (isset($_SESSION['user_id'])) {
    //$user_id = $_SESSION['user_id'];
    $user = ['id' => $_SESSION['user_id'], 'name' => $_SESSION['user_name']];
    $errors = [];
    $rules = [
        'name' => function() {
            return validateFilled($_POST['name']);
        }
     ];

    if (isset($_POST['add_project'])) {

        foreach ($_POST as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $errors[$key] = $rule();
            }
        }
        if(!isset($errors['name'])) {
            $errors['name'] = unique_project($_POST['name'], $con);
        }
        $errors = array_filter($errors);

        if (!count($errors)) {
            $name = htmlspecialchars($_POST['name']);
            $id_user = $user['id'];
            $id_project= write_project($name, $id_user, $con);
            header("Location: /index.php?id=$id_project");
        }
    }
    $page_content = include_template('new_project.php', [
            'projects' => get_projects($user['id'], $con),
            'show_complete_tasks' => $show_complete_tasks,
            'con' => $con,
            'errors' => $errors
        ]
    );
    $layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Добавление проекта' , 'user' => $user]);
} else {
    $page_content = include_template('guest.php', []);
    $layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке', 'user' => $user]);
}
print($layout_content);
