<?php if (!count($projects)) {
    header("Location: /add_project.php");
};
print(include_template('nav_menu.php', [
    'projects' => get_projects($_SESSION['user_id'], $con),
    'id_project' => $_GET['id'] ?? '',
    'con' => $con
]));
?>
<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>
    <?php
    if (empty(getPostVal('project'))) {
        $id = $_GET['id'] ?? '';
    } else {
        $id = getPostVal('project');
    }
    ?>

    <form class="form" action="add.php?id=<?= $id ?>" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? "form__input--error" : ""; ?>
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?= $classname; ?>" type="text" name="name" id="name"
                   value="<?= getPostVal('name'); ?>" placeholder="Введите название">
            <p class="form__message"><?= $errors['name'] ?? ""; ?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <select class="form__input form__input--select" name="project" id="project">
                <?php foreach ($projects as $value): ?>
                    <option value="<?= htmlspecialchars($value['id_project']); ?>"
                        <?php if ($value['id_project'] === intval($id)): ?> selected <?php endif; ?>>
                        <?= htmlspecialchars($value['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form__row">
            <?php $classname = isset($errors['date']) ? "form__input--error" : ""; ?>
            <label class="form__label" for="date">Дата выполнения</label>
            <input class="form__input form__input--date <?= $classname; ?>" type="text" name="date" id="date"
                   value="<?= getPostVal('date'); ?>"
                   placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <p class="form__message"><?= $errors['date'] ?? ""; ?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file" id="file" value="<?= getPostVal('file'); ?>">
                <label class="button button--transparent" for="file">
                    <span>Выберите файл</span>
                </label>
            </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="add_task" value="Добавить">
        </div>
    </form>
</main>
