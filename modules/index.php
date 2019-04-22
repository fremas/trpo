<?php

# Заголовок модуля
$system['page_title'] = 'Герои';

require_once(HOME .'/incfiles/header.php');

if($user==0){
# Основное меню для не авторизованных
echo '<center><img src="/images/arts/main.png"></center><br/>
<center>Это новая онлайн игра для мобильных телефонов, в которой ты можешь с головой окунуться в атмосферу средневекового фэнтези!<br/><br/>
<a href="/user/registration.php"><img src="/images/start.png"></a>';

error($err);

echo '<center><form method="post" action="/">
Логин:<br />
<input type="text" size="15" name="login" /><br />
Пароль:<br />
<input type="password" size="15" name="password" /><br />
<input type="checkbox" name="save_entry" value="1" checked="checked" />Запомнить меня<br />
<input type="submit" value="Войти"/></center>
</form>';

}else{
	
# Основное меню для авторизованных
echo '<center><img src="/images/arts/main.png"><br/>
<b>Добро пожаловать!</b></center>';

$jourcount= DB::$dbs->querySingle("SELECT * FROM `journal` WHERE `user_id`='".$user['id']."' AND `read`='0'");

if($jourcount>=1){
$blink=' <img src="/images/icons/blink_attention.gif">';
}else{
$blink='';
}

echo '</div><div class="main_list"><div class="menuList">
<li><a href="/user/journal.php?"><img src="/images/icons/journal.png">Дневник'.$blink.'</a></li>
<li><a href="/duel/"><img src="/images/icons/swords.png">Дуэль</a></li>
<li><a href="/town/"><img src="/images/icons/home.png">Посёлок</a></li>
<li><a href="/walk/"><img src="/images/icons/castle.png">Поход</a></li>
<li><a href="/clan/"><img src="/images/icons/clan.png">Клан</a></li>
<li><a href="/pet/"><img src="/images/icons/pet.png">Питомник</a></li>
<li><a href="/best/"><img src="/images/icons/cup.png">Лучшие</a></li>
</div></div>';

}

require_once(HOME .'/incfiles/footer.php');

?>