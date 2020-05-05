<?php
require_once('init.php');
$rules = [
    'name' => function () {
        return validateFilled($_POST['name']);
    },
    'date' => function () {
        return isCorrectDate($_POST['date']);
    }
];

if (isset($_SESSION['user_id'])) {
    $layout_content = add_task($rules, $con, $show_complete_tasks);
} else {
    $layout_content = redirect();
}
print($layout_content);
