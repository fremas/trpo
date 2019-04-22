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
echo '<div class="title">Начало работы</div>
<div class="menu">
Установка:<br />
1) Распакуйте архив с ядром в корень вашего сайта.<br />
2) Создайте базу данных MySQL и пользователя к ней.<br />
3) Установите соединение скрипта с базой данных в файле <i>/incfiles/db_ini.php</i>.<br />
4) Залейте в базу данных таблицы из файла <i>/install/db_tables.sql</i>.<br />
5) Настройте ядро под ваш сайт.
</div>';

echo '<div class="block">
&raquo; <a href="/docs/">К содержанию</a><br />
&raquo; <a href="/">На главную</a>
</div>';

require_once(HOME .'/incfiles/footer.php');

?>