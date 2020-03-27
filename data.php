<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$tasks = [
    [
        'task' => 'Собеседование в IT компании',
        'date_of_completion' => '30.03.2020',
        'category' => 'Работа',
        'completed' => false
    ],
    [
        'task' => 'Выполнить тестовое задание',
        'date_of_completion' => '25.12.2019',
        'category' => 'Работа',
        'completed' => false
    ],
    [
        'task' => 'Сделать задание первого раздела',
        'date_of_completion' => '21.12.2019',
        'category' => 'Учеба',
        'completed' => true
    ],
    [
        'task' => 'Встреча с другом',
        'date_of_completion' => '22.12.2019',
        'category' => 'Входящие',
        'completed' => false
    ],
    [
        'task' => 'Купить корм для кота',
        'date_of_completion' => null,
        'category' => 'Домашние дела',
        'completed' => false
    ],
    [
        'task' => 'Заказать пиццу',
        'date_of_completion' => null,
        'category' => 'Домашние дела',
        'completed' => false
    ]
];
