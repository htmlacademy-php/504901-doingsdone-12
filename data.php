<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0,1);

/**
 * Получить список проектов текущего пользователя
 * @param  integer $id Идентификатор текущего пользователя
 * @param  object $con Идентификатор соединения с БД
 * @return array Ассоциативный массив проектов текущего пользователя
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
 * @param  string $filter Фильтр
 * @param  object $con Идентификатор соединения с БД
 * @return array Ассоциативный массив задач текущего пользователя
 */
function get_tasks($id_user, $id_project, $sort, $direction, $filter, $con)
{
    $sql = "SELECT *, name, id_user FROM tasks JOIN projects ON tasks.id_project = projects.id_project WHERE id_user = $id_user";
    if ($id_project) {
        $sql = $sql . " and tasks.id_project= $id_project";
    }
    if ($filter === 'now') {
        $dt = date('Y-m-d');
        $sql = $sql . " and date_of_completion = '$dt'";
    }
    if ($filter === 'tomorrow') {
        $dt = date('Y-m-d');
        $dt = date('Y-m-d', strtotime($dt) + 24 * 3600);
        $sql = $sql . " and date_of_completion = '$dt'";
    }
    if ($filter === 'overdue') {
        $dt = date('Y-m-d');
        $sql = $sql . " and date_of_completion < '$dt'";
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
 * @param object $con Идентификатор соединения с БД
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
 * @param object $con Идентификатор соединения с БД
 */
function write_task($name_task, $id_project, $date, $file, $con) {
    $sql = "INSERT INTO tasks SET name_task = '$name_task', id_project = $id_project";
    if (!is_null($date) and !empty($date)) {
        $sql = $sql . ", date_of_completion = '$date'";
    }
    if (!is_null($file) and !empty($file)) {
        $sql = $sql . ", file = '$file'";
    }
    mysqli_query($con, $sql);
}

/**
 * Проверка уникальности e-mail
 * @param  string $email email пользователя
 * @param object $con Идентификатор соединения с БД
 * @return string Текст ошибки
 */
function unique_email($email, $con) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result)) {
        return "Такой E-mail уже зарегистрирован";
    }
    return null;
}

/**
 * Проверка уникальности названия проекта
 * @param  string Название проекта
 * @param object $con Идентификатор соединения с БД
 * @return string Текст ошибки
 */
function unique_project($name, $con) {
    $sql = "SELECT * FROM projects WHERE name = '$name'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result)) {
        return "Такой проект уже зарегистрирован";
    }
    return null;
}

/**
 * Добавление пользователя в базу данных
 * @param string $name Имя пользователя
 * @param string $email email
 * @param string $password
 * @param object $con Идентификатор соединения с БД
 */
function write_user($name, $email, $password, $con) {
    $sql = "INSERT INTO users SET name = '$name', email = '$email',password = '$password'";
    mysqli_query($con, $sql);
}

/**
 * Проверка зарегистрированного пользователя
 * @param string $email email пользователя
 * @param object $con Идентификатор соединения с БД
 * @return array Ассоциативный массив данных пользователя
 */
function read_user($email, $con) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Поиск задач
 * @param string $text Текст для поиска
 * @param integer $id_user id пользователя
 * @param object $con Идентификатор соединения с БД
 * @return array Ассоциативный массив найденных данных
 */
function search_tasks($text, $id_user, $con) {
    $sql = "SELECT *, name, id_user FROM tasks JOIN projects ON tasks.id_project = projects.id_project WHERE id_user = $id_user";
    if ($text) {
        $sql = $sql .  " and MATCH(name_task) AGAINST('$text')";
    }
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Добавление проекта в базу данных
 * @param string $name Название проекта
 * @param integer $id_user Идентификатор пользователя
 * @param object $con Идентификатор соединения с БД
 * @return integer Идентификатор добавленной записи
 */
function write_project($name, $id_user, $con) {
    $sql = "INSERT INTO projects SET name = '$name', id_user = $id_user";
    mysqli_query($con, $sql);
    return mysqli_insert_id($con);
}

/**
 * Изменение статуса задачи
 * @param integer $id_task Идентификатор задачи
 * @param object $con Идентификатор соединения с БД
 */
function change_status($id_task, $con) {
    $sql = "UPDATE tasks SET status = 1 - status WHERE  id_task = $id_task";
    mysqli_query($con, $sql);
}

/**
 * Уведомления о предстоящих задачах
 * @param object $con Идентификатор соединения с БД
 * @return array Ассоциативный массив найденных данных
 */
function notifications($con)
{
    $sql = "SELECT name_task, date_of_completion, users.email as email, users.name as user_name FROM tasks";
    $sql = $sql . " INNER JOIN projects on tasks.id_project = projects.id_project";
    $sql = $sql . " INNER JOIN users ON projects.id_user = users.id_user";
    $sql = $sql . " WHERE date_of_completion = CURRENT_DATE AND status = 0 ORDER BY projects.id_user";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Вывод страницы добавления новой задачи
 * @param array $rules Правила валидации
 * @param object $con Идентификатор соединения с БД
 * @param integer $show_complete_tasks Значение флага показ завершенных задач
 * @return string Разметка страницы
 */
function add_task($rules, $con, $show_complete_tasks) {
    $user = ['id' => $_SESSION['user_id'], 'name' => $_SESSION['user_name']];
    $errors = [];
    if (isset($_POST['add_task'])) {
        $errors = validation_form($rules);
        $errors = array_filter($errors);
        if (!count($errors)) {
            $name_task = htmlspecialchars($_POST['name']);
            $id_project = htmlspecialchars($_POST['project']);
            $date = htmlspecialchars($_POST['date']);
            $filename = null;
            if (isset($_FILES['file'])) {
                $filename = $_FILES['file']['name'];
                $file_path = __DIR__ . '/uploads/';
                if (!file_exists($file_path)) {
                    mkdir($file_path);
                }
                move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $filename);
            }
            write_task($name_task, $id_project, $date, $filename, $con);
            header("Location: /index.php?id=$id_project&&s=2&&d=desc");
        }
    }
    $page_content = include_template('new_task.php', [
            'projects' => get_projects($user['id'], $con),
            'show_complete_tasks' => $show_complete_tasks,
            'con' => $con,
            'errors' => $errors
        ]
    );
    return include_template('layout.php', ['content' => $page_content, 'title' => 'Добавление задачи', 'user' => $user]);
}
/**
 * Перенаправление на страницу гостя
 * @return string Разметка страницы гостя
 */
function redirect() {
    $page_content = include_template('guest.php', []);
    return include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке', 'user' => []]);
}

/**
 * Вывод страницы добавления нового проекта
 * @param array $rules Правила валидации
 * @param object $con Идентификатор соединения с БД
 * @param integer $show_complete_tasks Значение флага показ завершенных задач
 * @return string разметка страницы
 */
function project_add($rules, $con, $show_complete_tasks) {
    $user = ['id' => $_SESSION['user_id'], 'name' => $_SESSION['user_name']];
    $errors = [];

    if (isset($_POST['add_project'])) {
        validation_form($rules);
        if (!isset($errors['name'])) {
            $errors['name'] = unique_project($_POST['name'], $con);
        }
        $errors = array_filter($errors);

        if (!count($errors)) {
            $name = htmlspecialchars($_POST['name']);
            $id_user = $user['id'];
            $id_project = write_project($name, $id_user, $con);
            header("Location: /index.php?id=$id_project");
        }
    }
    $page_content = include_template('new_project.php', [
            'projects' => get_projects($user['id'], $con),
            'show_complete_tasks' => $show_complete_tasks,
            'con' => $con,
            'errors' => $errors
        ]
    );
    return include_template('layout.php',['content' => $page_content, 'title' => 'Добавление проекта', 'user' => $user]);
}
