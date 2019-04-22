<?php

// проверка наличия авторизации
if (isset($user))
{
    # Перенаправляем на главную
    header('Location: /');
}

# Заголовок модуля
$system['page_title'] = 'Регистрация';

# Шапка модуля
require_once(HOME .'/incfiles/header.php');

// Обрабатываем запрос на регистрацию
if (isset($_POST['reg_submit'])) {
	# Логин
    $reg_login = txt($_POST['reg_login']);

    # Проверка ввода логина
    if (empty($reg_login)) $err .= 'Не введен логин<br />';

    # Проверка длины логина
    if (!empty($reg_login) && (strlen($reg_login) < 3 || strlen($reg_login) > 15)) $err .= 'Неверная длина логина. Допустимо от 3 до 15 символов<br />';

    # Проверка занятости логина
    if (DB::$dbs->querySingle("SELECT * FROM `users` WHERE `login` = '". input($reg_login) ."'") != 0) $err .= 'Логин ' . $reg_login . ' занят. Выберите другой<br />';

    # Пароль
    $reg_password = txt($_POST['reg_password']);

    # Проверка ввода пароля
    if (empty($reg_password)) $err .= 'Не введен пароль<br />';

    # Проверка длины пароля
    if (!empty($reg_password) && (strlen($reg_password) < 6 || strlen($reg_password) > 18)) $err .= 'Неверная длина пароля. Допустимо от 6 до 18 символов<br />';

	# Пол
    $reg_sex = txt($_POST['sex']);
	
    // Проводим регистрацию
    if (!isset($err)) {
        # Кодируем пароль
        $reg_password1 = encrypt($reg_password);

        # Запрос на регистрацию
        DB::$dbs->query("INSERT INTO `users` SET 
		`login` = '". input($reg_login) ."',
		`password` = '". input($reg_password1) ."',
		`date_reg` = '". time() ."',
		`date_last_entry` = '". time() ."',
		`sex` = '". input($reg_sex) ."',
		`status` = 'user',
		`avatar` = '',
		`lvl` = '1',
		`exp` = '0',
		`needexp` = '5',
		`silver` = '1000',
		`silverplus` = '0',
		`allsilver` = '10000',
		`gold` = '100',
		`crystal` = '10',
		`hp` = '100',
		`hpregen` = '10',
		`allhp` = '100',
		`battles` = '3',
		`allbattles` = '5',
		`battle_cost` = '0',
		`power` = '5',
		`defense` = '5',
		`speed` = '5',
		`skill` = '5',
		`health` = '5',
		`power_bonus` = '0',
		`defense_bonus` = '0',
		`speed_bonus` = '0',
		`skill_bonus` = '0',
		`health_bonus` = '0',
		`fame` = '0',
		`wins` = '0',
		`loses` = '0',
		`silverstole` = '0',
		`silverlost` = '0',
		`crystalstole` = '0',
		`crystallost` = '0',
		`clan` = 'not',
		`walk_minutes` = '0',
		`onoff` = 'on'");

        # Выводим уведомление
        echo '<center><img src="/images/arts/main.png"><br/>
		<b>Регистрация</b></center>
        Регистрация завершена.<br/>
		Желаем вам приятной игры!<br/>
        </div><div class="foot_list"><div class="menuList"><li><a href="/?login='. input($reg_login) .'&amp;password='. input($reg_password) .'"><img src="/images/icons/next.png">Продолжить</a></li></div></div>';

        # Ноги модуля
        require_once(HOME .'/incfiles/footer.php');
    }
}

error($err);

echo '<center><img src="/images/arts/main.png"><br/>
<b>Регистрация</b></center>
<form method="post" action="/user/registration.php">
Логин:<br />
<input type="text" size="15" name="reg_login" value="'. output($_POST['reg_login']) .'" /><br />
Пароль:<br />
<input type="password" size="15" name="reg_password" /><br />
Пол:<br />
<select name="sex"><option value="m">Мужской</option><option value="w">Женский</option></select><br/>
<center><input type="submit" name="reg_submit" value="Регистрация" /></center>
</form>';

echo '</div><div class="foot_list"><div class="menuList">
<li><a href="/"><img src="/images/icons/home.png">На главную</a></li>
</div></div>';


# Ноги модуля
require_once(HOME .'/incfiles/footer.php');

?>
