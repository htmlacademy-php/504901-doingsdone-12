<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

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
 * @param  integer $sort Номер поля для сортировки
 * @param  string $direction Направление сортировки
 * @param  $con Идентификатор соединения с БД
 * @return Ассоциативный массив задач текущего пользователя
 */
function get_tasks($id_user, $id_project, $sort, $direction, $con)
{
    $sql = "SELECT *, name, id_user FROM tasks JOIN projects ON tasks.id_project = projects.id_project WHERE id_user = $id_user";
    if ($id_project) {
        $sql = $sql . " and tasks.id_project= $id_project";
    }
    if ($sort) {
        $sql = $sql . " ORDER BY $sort";
    }
    if ($direction) {
        $sql = $sql . " $direction";
    }
    $result = mysqli_query($con, $sql);
    if (!mysqli_num_rows($result)) {
        http_response_code(404);
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Подсчитывает количество задач для проекта
 * @param integer $id_project Идентификатор текущего проекта
 * @param $con Идентификатор соединения с БД
 * @return integer Количество задач
 */
function count_tasks($id_project, $con) {
    $sql = "SELECT * FROM tasks WHERE tasks.id_project = $id_project";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}

/**
 * Добавление задачи в базу данных
 * @param string $name_task Название задачи
 * @param integer $id_project Идентификатор проекта
 * @param string $date Дата завершения
 * @param string $file Ссылка на файл
 * @param $con Идентификатор соединения с БД
 * @return integer Количество задач
 */
function write_task($name_task, $id_project, $date, $file, $con) {
    $sql = "INSERT INTO tasks SET name_task = '$name_task', id_project = $id_project";
    if (!is_null($date) and !empty($date)) {
        $sql = $sql . ", date_of_completion = '$date'";
    }
    if (!is_null($file) and !empty($file)) {
        $sql = $sql . ", file = '$file'";
    }
    $result = mysqli_query($con, $sql);
}

/**
 * Проверка уникальности email
 * @param string $email email пользователя
 * @param $con Идентификатор соединения с БД
 * @return integer количество найденных записей
 */
function count_email($email, $con) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    //print($sql);
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result);
}
/**
 * Проверка уникальности e-mail
 * @param  string Имя поля формы
 * @param $con Идентификатор соединения с БД
 * @return string Текст ошибки
 */
function unique_email($name, $con) {
    if (count_email($_POST['email'], $con)) {
        return "Такой E-mail уже зарегистрирован";
    }
    return null;
}
/**
 * Добавление задачи в базу данных
 * @param string $name Имя пользователя
 * @param string $email email
 * @param string $password Пароль
 * @param $con Идентификатор соединения с БД
 */
function write_user($name, $email, $password, $con) {
    $sql = "INSERT INTO users SET name = '$name', email = '$email',password = '$password'";
    $result = mysqli_query($con, $sql);
}

/**
 * Проверка зарегистрированного пользователя
 * @param string $email email пользователя
 * @param string $password hash пароля
 * @param $con Идентификатор соединения с БД
 * @return Ассоциативный массив данных пользователя
 */
function read_user($email, $con) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    //print($sql);
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
