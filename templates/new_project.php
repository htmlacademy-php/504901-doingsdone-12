<?php
print(include_template('nav_menu.php', [
    'projects' => get_projects($_SESSION['user_id'], $con),
    'id_project' => $_GET['id'] ?? '',
    'con' => $con
]));
?>
<main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form" action="add_project.php" method="post" autocomplete="off">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? "form__input--error" : ""; ?>
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input <?= $classname; ?>" type="text" name="name" id="project_name" value=""
                   placeholder="Введите название проекта">
            <p class="form__message"><?= $errors['name'] ?? ""; ?></p>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="add_project" value="Добавить">
        </div>
    </form>
</main>
