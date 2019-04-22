<?php

/**
 * Автор Steam Core, Steam CMS: Платонов Кирилл (Plato)
 * ICQ: 258549
 * E-Mail: platonov-kd@ya.ru
 * Оф. сайт: http://scms.su
 * Сайт: http://promob.net
 */ 

# Заголовок модуля
$system['page_title'] = 'Документация';

require_once(HOME .'/incfiles/header.php');

error($err);

# Основное меню
echo '<div class="title">Содержание</div>
<div class="menu">
<a href="/docs/doc_opis.php">Описание</a><br />
<a href="/docs/doc_start.php">Начало работы</a><br />
<a href="/docs/doc_ini.php">Настройка системы</a><br />
<a href="/docs/doc_folders.php">Структура ядра</a><br />
<a href="/docs/doc_module.php">Работа модулей</a><br />
<a href="/docs/doc_fnc.php">Основные функции</a><br />
<a href="/docs/doc_work.php">Принципы работы</a><br />
</div>';

require_once(HOME .'/incfiles/footer.php');

?>