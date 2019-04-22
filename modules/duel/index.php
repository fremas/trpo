<?php

$system['page_title'] = 'Дуэль';

require_once(HOME .'/incfiles/aut_check.php');

if($_GET['error']==1){

if($user['battles']==0){
$err .='Подождите пока восстановятся бои.<br/>';
}
$needhp=$user['allhp']/10;
if($user['hp']<$needhp){
$err .='Слишком мало здоровья. (минимум 10%)<br/>';
}
if($user['silver']<$user['battle_cost']){
$err .='Недостаточно серебра для поиска.<br/>';
}

if($_GET['bot']=='crystal'){
if($user['lvl']<5){
$err .='Кристальные Наёмники доступны с 5 уровня.<br/>';
}
}

if($_GET['bot']=='gold'){
if($user['lvl']<10){
$err .='Золотые Наёмники доступны с 10 уровня.<br/>';
}
}

}

require_once(HOME .'/incfiles/header.php');

echo '<center><img src="/images/arts/duel.png"><br/>
<b>Дуэль</b></center><br/>
Покажи, на что ты способен!<br/><br/>';

echo '<div class="title">Поиск <img src="/images/icons/silver.png"> '.$user['battle_cost'].'</div>';

echo '</div><div class="main_list"><div class="menuList">
<li><a href="/duel/user.php?mod=normal"><img src="/images/icons/user.png">Равные</a></li>
<li><a href="/duel/user.php?mod=lower"><img src="/images/icons/user.png">Младшие</a></li>
<li><a href="/duel/user.php?mod=higher"><img src="/images/icons/user.png">Старшие</a></li>
<li><a href="/duel/bot.php?"><img src="/images/icons/bot.png">Наёмники</a></li>
<li><a href="/duel/boss.php?"><img src="/images/icons/boss.png">Владыка</a></li>
</div></div>';

require_once(HOME .'/incfiles/footer.php');

?>