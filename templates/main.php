<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $value): ?>
                <li class="main-navigation__list-item">
                    <a class="main-navigation__list-item-link
                    <?php if ($id_project === $value['id_project']):?>main-navigation__list-item--active <?php endif; ?>"
                       href="/?id=<?=$value['id_project']; ?>">
                        <?=htmlspecialchars($value['name']);?></a>
                    <span class="main-navigation__list-item-count"><?=count_tasks($value['id_project'], $con); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button"
       href="pages/form-project.html" target="project_add">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="get" autocomplete="off">
        <input class="search-form__input" type="text" name="text" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="search" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox"
                   <?php if ($show_complete_tasks === 1): ?>checked<?php endif; ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>
    <?php if ($search and !count($tasks)): ?>
            <p>Ничего не найдено по вашему запросу</p>
    <?php else: ?>
       <table class="tasks">
            <?php foreach ($tasks as $key => $value): ?>
                <?php if ($show_complete_tasks === 1 or !$value['status']): ?>
                    <tr class="tasks__item task <?php if ($value['status']): ?>task--completed<?php endif; ?>
                    <?php if (count_hours($value['date_of_completion'])<=24 && !$value['status']): ?>task--important<?php endif; ?>">
                        <td class="task__select">
                            <label class="checkbox task__checkbox">
                                <input class="checkbox__input visually-hidden" type="checkbox">
                                <span class="checkbox__text"><?=htmlspecialchars($value['name_task']); ?></span>
                            </label>
                        </td>
                        <td class="task__file">
                            <?php if ($value['file']): ?>
                                 <a class="download-link" href="<?='/uploads/'.$value['file']; ?>"><?=$value['file']; ?></a>
                            <?php endif; ?>
                        </td>
                        <td class="task__date"><?=$value['date_of_completion']; ?></td>
                        <td class="task__controls"><?=$value['name']; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</main>
