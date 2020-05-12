<?php
require_once('init.php');
$rules = [
    'name' => function () {
        return validateFilled($_POST['name']);
    }
];
if (isset($_SESSION['user_id'])) {
    $layout_content = project_add($rules, $con, $show_complete_tasks);
} else {
    $layout_content = redirect();
}
print($layout_content);
