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
echo '<div class="title">Основные функции</div>
<div class="menu">
<b>function num($var)</b> - Возвращает чистое числовое значение.<br />
<b>function txt($var)</b> - Возвращает чистое текстовое значение.<br />
<b>function input($var)</b> - Фильтрует текст перед записью в базу данных.<br />
<b>function output($var)</b> - Безопасно выводит текст из базы данных.<br />
<b>function encrypt($var)</b> - Возвращает зашифрованный пароль.<br />
<b>function strlen_rus($var)</b> - Возвращает длину текста с кириллицой.<br />
<b>function vtime($var)</b> - Возвращает отформатированную дату со временем.<br />
<b>function require_lib(\'lib_name.php\')</b> - Подключает библиотеку.
</div>';

echo '<div class="block">
&raquo; <a href="/docs/">К содержанию</a><br />
&raquo; <a href="/">На главную</a>
</div>';

require_once(HOME .'/incfiles/footer.php');

?>