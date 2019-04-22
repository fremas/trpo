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
echo '<div class="title">Работа модулей</div>
<div class="menu">
Создание модулей происходит на чистом php без MVC и шаблонизаторов. Для каждого модуля нужно создавать отдельную папку. Например модуль пользователей, он располагается в папке <i>/user/</i>. Состоит он из трех файлов: <i>entry.php</i>, <i>registration.php</i> и <i>exit.php</i>. Чтобы например из браузера получить доступ к файлу <i>entry.php</i>, необходимо перейти по адресу http://ваш_сайт.ру/<b>user/entry.php</b> и мы попадем в папку <i>/modules/user/entry.php</i>. Главная страница системы расположена в файле <i>/modules/index.php</i>. Вы можете редактировать ее также, как и обычный модуль.<br />
Подробно прокомметированная структура модулей, рекомендуемая для использования в системе, представленна в файле <i>/modules/demo/code.php</i>.
</div>';

echo '<div class="block">
&raquo; <a href="/docs/">К содержанию</a><br />
&raquo; <a href="/">На главную</a>
</div>';

require_once(HOME .'/incfiles/footer.php');

?>