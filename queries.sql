/* Добавление двух пользователей */
INSERT INTO users (email, password, name)
VALUES ('tyshenkoev@gmail.com', '12345', 'Елена'),
 ('maxim@gmail.com', '54321', 'Максим');
/* Добавление проектов */
INSERT INTO projects (name, id_user)
VALUES ('Входящие', 1),
 ('Учеба', 1),
 ('Работа', 1),
 ('Домашние дела', 1),
 ('Авто', 2);
 /* Добавление задач */
INSERT INTO tasks (status, name_task, date_of_completion, id_project)
VALUES (0, 'Собеседование в IT компании', '2020-03-30', 3),
 (0, 'Выполнить тестовое задание', '2019-12-25', 3),
 (1, 'Сделать задание первого раздела', '2019-12-21', 2),
 (0, 'Встреча с другом', '2019-12-22', 1),
 (0, 'Купить корм для кота', null, 4),
 (0, 'Заказать пиццу', null, 4);
/* получить список из всех проектов для одного пользователя */
SELECT name FROM projects WHERE id_user = 1;
SELECT name FROM projects WHERE id_user = 2;
/* получить список из всех задач для одного проекта */
SELECT name_task FROM tasks WHERE id_project = 1;
SELECT name_task FROM tasks WHERE id_project = 2;
SELECT name_task FROM tasks WHERE id_project = 3;
SELECT name_task FROM tasks WHERE id_project = 4;
SELECT name_task FROM tasks WHERE id_project = 5;
/* пометить задачу как выполненную; */
UPDATE tasks SET status = 1 WHERE id_task = 5;
/* обновить название задачи по её идентификатору */
UPDATE tasks SET name_task = 'Сделать задание первого и второго раздела' WHERE id_task = 3;
