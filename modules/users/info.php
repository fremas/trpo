<?php

$usid=$_GET['id'];
$usid = htmlspecialchars(stripslashes($usid));

$req = DB::$dbs->query("SELECT * FROM `users` WHERE `id` = '$usid'");
$avto = $req->RowCount();

if($avto=='0'){
header('Location: /');
exit;
}

$us = $req -> Fetch();

$system['page_title'] = 'Профиль';

require_once(HOME .'/incfiles/aut_check.php');
require_once(HOME .'/incfiles/header.php');

error($err);


if($us['status']=='moder'){
$status='Модератор';	
}elseif($us['status']=='admin'){
$status='Администратор';
}else{
$status='Игрок';
}

if($us['avatar']!=''){
$avatar=''.$us['avatar'].'';
}else{
$avatar='standart/'.$us['sex'].'';
}

//Основная информация
echo '<center><b>'.$status.' '.$us['login'].'</b><br/>
<img src="/images/avatars/'.$avatar.'.png"></center>';

if($us['onoff']=='on'){
echo '<img src="/images/icons/online.png"> Сейчас играет<br/>';
}

echo '<img src="/images/icons/lvl.png"> Уровень: '.$us['lvl'].'<br/>';

if($us['clan']!='not'){
echo '<img src="/images/icons/clan.png"> Клан: <a href="/clan/info.php?id='.$usclan['id'].'"><b>'.$usclan['name'].'</b></a><br/>';
}else{
echo '<img src="/images/icons/clan.png"> Не состоит в клане<br/>';
}

echo '<img src="/images/icons/fame.png"> Слава: '.$us['fame'].'<br/>';

echo '<img src="/images/icons/valor.png"> Карма: '.$us['karma'].'<br/><br/>';


//Параметры
echo '<div class="title">Параметры</div>';

echo '<img src="/images/icons/power.png"> Сила: '.$us['power'].'<br/>';

echo '<img src="/images/icons/defense.png"> Защита: '.$us['defense'].'<br/>';

echo '<img src="/images/icons/speed.png"> Ловкость: '.$us['speed'].'<br/>';

echo '<img src="/images/icons/skill.png"> Мастерство: '.$us['skill'].'<br/>';

echo '<img src="/images/icons/heart.png"> Живучесть: '.$us['health'].'<br/><br/>';


//Статистика
echo '<div class="title">Статистика</div>';

echo '<img src="/images/icons/victory_sword.png"> Побед: '.$us['wins'].'<br/>';

echo '<img src="/images/icons/skull.png"> Поражений: '.$us['loses'].'<br/>';

echo '<img src="/images/icons/silver.png"> Награбил: '.n_f($us['silverstole']).'<br/>';

echo '<img src="/images/icons/silver.png"> Украли: '.n_f($us['silverlost']).'<br/>';

echo '<img src="/images/icons/crystal.png"> Награбил: '.n_f($us['crystalstole']).'<br/>';

echo '<img src="/images/icons/crystal.png"> Украли: '.n_f($us['crystallost']).'<br/>';

echo '<img src="/images/icons/castle.png"> Минут в походе: '.$us['walk_minutes'].'<br/>';


//Меню

if($us['id']!=$user['id']){
echo '</div><div class="main_list"><div class="menuList">
<li><a href="/duel/attack.php?id='.$us['id'].'"><img src="/images/icons/sword.png">Напасть ('.$user['battle_cost'].' серебра)</a></li>
<li><a href="/users/karma.php?id='.$us['id'].'"><img src="/images/icons/valor.png">Повысить карму</a></li>
<li><a href="/mail/send.php?id='.$us['id'].'"><img src="/images/icons/mail.png">Отправить письмо</a></li>
</div></div>';
}

require_once(HOME .'/incfiles/footer.php');

?>