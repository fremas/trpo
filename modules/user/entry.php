<?php 

// проверка наличия авторизации
if (isset($user))
{
    # Перенаправляем на главную
    header('Location: /');   
}

# Заголовок модуля
$system['page_title'] = 'Авторизация';

# Шапка модуля
require_once(HOME .'/incfiles/header.php');

error($err);

echo '<center><img src="/images/arts/main.png"><br/>
<b>Авторизация</b></center>
<form method="post" action="/">
Логин:<br />
<input type="text" size="15" name="login" /><br />
Пароль:<br />
<input type="password" size="15" name="password" /><br />
<input type="checkbox" name="save_entry" value="1" checked="checked" />Запомнить меня<br />
<center><input type="submit" value="Войти"/></center>
</form>';

echo '</div><div class="foot_list"><div class="menuList">
<li><a href="/user/registration.php"><img src="/images/icons/feather.png">Регистрация</a></li>
<li><a href="/"><img src="/images/icons/home.png">На главную</a></li>
</div></div>';

# Ноги модуля
require_once(HOME .'/incfiles/footer.php');

?>
