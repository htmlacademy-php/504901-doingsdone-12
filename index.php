<?php
require_once('helpers.php');
require_once('data.php');

$id = $_GET['id'] ?? '';

$page_content = include_template('main.php', ['tasks' => get_tasks($current_user, $id),
    'projects' => get_projects($current_user), 'show_complete_tasks' => $show_complete_tasks, 'id_project' => $id]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);


