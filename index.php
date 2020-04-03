<?php
require_once('helpers.php');
require_once('data.php');

$data = ['tasks' => $tasks, 'projects' => $projects, 'show_complete_tasks' => $show_complete_tasks];

$page_content = include_template('main.php', ['tasks' => $tasks, 'projects' => $projects, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);


