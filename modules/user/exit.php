<?php

// проверка наличия авторизации
if (!isset($user)) {
	# Перенаправляем на главную
	header('Location: /');
}

/**
 * Удаление личных данных
 */

mysql_query("UPDATE `users` SET `onoff` ='off' WHERE `id`='".$user['id']."'");
 
setcookie("user_id", "", time() - 3600, '/');
setcookie("password", "", time() - 3600, '/');
session_destroy();
unset($user);

# Заголовок модуля
$system['page_title'] = 'Выход из игры';

# Шапка модуля
require_once(HOME .'/incfiles/header.php');

echo '<center><img src="/images/arts/main.png"><br/>
<b>Выход из игры</b></center>
Вы вышли из игры...<br/>
Возвращайтесь поскорее!';

echo '</div><div class="foot_list"><div class="menuList">
<li><a href="/"><img src="/images/icons/home.png">На главную</a></li>
</div></div>';

# Ноги модуля
require_once(HOME .'/incfiles/footer.php');

?>