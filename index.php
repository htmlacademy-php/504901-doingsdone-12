<?php
require_once('helpers.php');
require_once('data.php');
require_once('init.php');

$id = $_GET['id'] ?? '';

$page_content = include_template('main.php', ['tasks' => get_tasks($current_user, $id , $con),
    'projects' => get_projects($current_user, $con),
    'show_complete_tasks' => $show_complete_tasks, 'id_project' => $id, 'con' => $con]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);


