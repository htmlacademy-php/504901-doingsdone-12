<?php
require_once('helpers.php');
require_once('data.php');

$page_content = include_template('main.php', ['tasks' => get_tasks($current_user), 'projects' => get_projects($current_user), 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);


