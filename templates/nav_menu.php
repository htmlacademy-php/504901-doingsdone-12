<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>
    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $value): ?>
                <li class="main-navigation__list-item">
                    <a class="main-navigation__list-item-link
                    <?php if ($id_project === strval($value['id_project'])): ?>main-navigation__list-item--active <?php endif; ?>"
                       href="/?id=<?= $value['id_project']; ?>">
                        <?= htmlspecialchars($value['name']); ?></a>
                    <span class="main-navigation__list-item-count"><?= count_tasks($value['id_project'],
                            $con); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <a class="button button--transparent button--plus content__side-button"
       href="add_project.php" target="project_add">Добавить проект</a>
</section>
