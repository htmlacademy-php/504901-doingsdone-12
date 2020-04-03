<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$current_user = 1;
/**
 * Получить список проектов текущего пользователя
 * @param  integer $id Идентификатор текущего пользователя
 * @return Ассоциативный массив проектов текущего пользователя
 */
function get_projects($id) {
    $con = mysqli_connect("localhost", "root", "", "doings_done");
    $sql = "SELECT name FROM projects WHERE id_user = $id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
/**
 * Получить список задач текущего пользователя
 * @param  integer $id Идентификатор текущего пользователя
 * @return Ассоциативный массив задач текущего пользователя
 */
function get_tasks($id)
{
    $con = mysqli_connect("localhost", "root", "", "doings_done");
    $sql = "SELECT *, name, id_user FROM tasks JOIN projects ON tasks.id_project = projects.id_project WHERE id_user = $id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

