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
echo '<div class="title">Принципы работы</div>
<div class="menu">
При переходе на сайт, если не определен модуль пользователь автоматически попадает на главную (<i>/modules/index.php/</i>). Основную работу проделывает файл <i>index.php</i>, расположеный в корне сайта. Он подключает все системные файлы, принимает запрос, обрабатывает, подключает нужный модуль в зависимости от запроса.
</div>';

echo '<div class="block">
&raquo; <a href="/docs/">К содержанию</a><br />
&raquo; <a href="/">На главную</a>
</div>';

require_once(HOME .'/incfiles/footer.php');

?>