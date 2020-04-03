<?php
require_once('helpers.php');
require_once('data.php');

$con = mysqli_connect("localhost", "root", "","doings_done");
$sql = "SELECT name FROM projects WHERE id_user = 1;";
$result = mysqli_query($con, $sql);
$projects = mysqli_fetch_all($result,  MYSQLI_ASSOC);
$sql = "SELECT *, name, id_user FROM tasks JOIN projects ON tasks.id_project = projects.id_project WHERE id_user = 1";
$result = mysqli_query($con, $sql);
$tasks = mysqli_fetch_all($result,  MYSQLI_ASSOC);

$data = ['tasks' => $tasks, 'projects' => $projects, 'show_complete_tasks' => $show_complete_tasks];

$page_content = include_template('main.php', ['tasks' => $tasks, 'projects' => $projects, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);


