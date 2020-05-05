<?php
require_once('init.php');
$user = [];
$page_content = null;

if (isset($_SESSION['user_id'])) {
    $user = ['id' => $_SESSION['user_id'], 'name' => $_SESSION['user_name']];
    if (isset($_GET['search'])) {
        $text = trim($_GET['text']);
        $page_content = include_template('main.php', ['tasks' => search_tasks($text, $_SESSION['user_id'], $con),
            'projects' => get_projects($_SESSION['user_id'], $con),
            'show_complete_tasks' => $show_complete_tasks,
            'con' => $con,
            'search' => true,
            'id_user' => $_SESSION['user_id']]);
    }
    else {
        if (isset($_GET['task_id'])) {
            print('change');
            change_status($_GET['task_id'], $con);
        }
        $id = $_GET['id'] ?? '';
        $sort = $_GET['s'] ?? '';
        $direction = $_GET['d'] ?? '';
        $filter = $_GET['f'] ?? '';
        $page_content = include_template('main.php', ['tasks' => get_tasks($_SESSION['user_id'], $id, $sort, $direction, $filter, $con),
            'projects' => get_projects($_SESSION['user_id'], $con),
            'show_complete_tasks' => $show_complete_tasks,
            'id_project' => $id,
            'con' => $con,
            'sort' => $sort,
            'direction' => $direction,
            'search' => false,
            'filter' => $filter,
            'id_user' => $_SESSION['user_id']]);
    }
}
else {
    $page_content = include_template('guest.php', []);
 }
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке', 'user' => $user]);
print($layout_content);


