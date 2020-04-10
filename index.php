<?php
require_once('helpers.php');
require_once('data.php');
require_once('init.php');

$id = $_GET['id'] ?? '';
$sort = $_GET['s'] ?? '';
$direction = $_GET['d'] ?? '';

$page_content = include_template('main.php', ['tasks' => get_tasks($current_user, $id, $sort, $direction, $con),
    'projects' => get_projects($current_user, $con),
    'show_complete_tasks' => $show_complete_tasks,
    'id_project' => $id,
    'con' => $con,
    'sort' => $sort,
    'direction' => $direction]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);


