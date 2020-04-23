<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $value): ?>
                <li class="main-navigation__list-item">
                    <a class="main-navigation__list-item-link"
                       href="/?id=<?=$value['id_project']; ?>">
                        <?=htmlspecialchars($value['name']);?></a>
                    <span class="main-navigation__list-item-count"><?=count_tasks($value['id_project'], $con); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button" href="add_project.php">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form"  action="add_project.php" method="post" autocomplete="off">
      <div class="form__row">
        <label class="form__label" for="project_name">Название <sup>*</sup></label>

        <input class="form__input" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
      </div>

      <div class="form__row form__row--controls">
        <input class="button" type="submit" name="add_project" value="Добавить">
      </div>
    </form>
</main>
