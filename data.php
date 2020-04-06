<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$current_user = 1;

/**
 * Получить список проектов текущего пользователя
 * @param  integer $id Идентификатор текущего пользователя
 * @param  $con Идентификатор соединения с БД
 * @return Ассоциативный массив проектов текущего пользователя
 */
function get_projects($id, $con) {
    $sql = "SELECT * FROM projects WHERE id_user = $id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
/**
 * Получить список задач текущего пользователя
 * @param  integer $id_user Идентификатор текущего пользователя
 * @param  integer $id_project Идентификатор текущего проекта
 * @param  $con Идентификатор соединения с БД
 * @return Ассоциативный массив задач текущего пользователя
 */
function get_tasks($id_user, $id_project, $con)
{
    $sql = "SELECT *, name, id_user FROM tasks JOIN projects ON tasks.id_project = projects.id_project WHERE id_user = $id_user";
    if ($id_project) {
        $sql = $sql . " and tasks.id_project= $id_project";
    }
    $result = mysqli_query($con, $sql);
    if (!mysqli_num_rows($result)) {
        http_response_code(404);
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Подсчитывает количество задач для проекта
 * @param  integer $id_project Идентификатор текущего проекта
 * @param $con Идентификатор соединения с БД
 * @return integer Количество задач
 */
function count_tasks($id_project, $con) {
 //   $con = mysqli_connect("localhost", "root", "", "doings_done");
    $sql = "SELECT * FROM tasks WHERE tasks.id_project = $id_project";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}
