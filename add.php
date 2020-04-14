<?php
require_once('helpers.php');
require_once('data.php');
require_once('init.php');
session_start();
$user = [];
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
$errors = [];
$rules = [
    'name' => function() {
        return validateFilled($_POST['name']);
    },
    'date' => function() {
        return isCorrectDate($_POST['date']);
    }
];

if (isset($_POST['add_task'])) {

    foreach ($_POST as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    $errors = array_filter($errors);
    if (!count($errors)) {
        $name_task = htmlspecialchars($_POST['name']);
        $id_project = $_POST['project'];
        $date = $_POST['date'];
        $filename = null;
        if (isset($_FILES['file'])) {
            $filename = $_FILES['file']['name'];
            $file_path = __DIR__ . '/uploads/';
            move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $filename);
        }
        write_task($name_task, $id_project, $date, $filename,$con);
        header("Location: /index.php?id=$id_project&&s=2&&d=desc");
    }
}
$page_content = include_template('new_task.php', [
    'projects' => get_projects($current_user, $con),
    'show_complete_tasks' => $show_complete_tasks,
    'con' => $con,
    'errors' => $errors
    ]
 );
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Добавление задачи' , 'user' => $user]);

print($layout_content);
