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
echo '<img src="/images/icons/clan.png"> Орден: <a href="/clan/info.php?id='.$usclan['id'].'"><b>'.$usclan['name'].'</b></a><br/>';
}else{
echo '<img src="/images/icons/clan.png"> Не состоит в ордене<br/>';
}

if($us['community']!='not'){
echo '<img src="/images/icons/clan.png"> Дружина: <a href="/clan/info.php?id='.$usclan['id'].'"><b>'.$usclan['name'].'</b></a><br/>';
}else{
echo '<img src="/images/icons/clan.png"> Не состоит в дружине<br/>';
}

echo '<img src="/images/icons/fame.png"> Слава: '.$us['fame'].'<br/>';

echo '<img src="/images/icons/valor.png"> Карма: '.$us['karma'].'<br/><br/>';
?>

</div>

<div class="main_list"><div class="menuList">
	<li><a href="/users/info.php?id=<?=$us['id']?>"><img src="/images/icons/sword.png">Характеристики</a></li>
	<li><a href="#"><img src="/images/icons/sword.png">Достижения</a></li>
	<li><a href="#"><img src="/images/icons/sword.png">Награды</a></li>
	<li><a href="#"><img src="/images/icons/sword.png">Подарки (0)</a></li>
	<li><a href="#"><img src="/images/icons/sword.png">Проклятия (0)</a></li>
	<li><a href="#"><img src="/images/icons/sword.png">Наклейки</a></li>
	<li><a href="#"><img src="/images/icons/sword.png">Анкета</a></li>
	<li><a href="#"><img src="/images/icons/sword.png">Фотостена (0)</a></li>
	<?
	if($us['id']!=$user['id']){?>
		<li><a href="/duel/attack.php?id='.$us['id'].'"><img src="/images/icons/sword.png">Напасть ('.$user['battle_cost'].' серебра)</a></li>
		<li><a href="/mail/send.php?id='.$us['id'].'"><img src="/images/icons/mail.png">Послать письмо</a></li>
		<li><a href="/users/karma.php?id='.$us['id'].'"><img src="/images/icons/valor.png">Повысить карму</a></li>
	<?}
	?>
	<li><a href="#"><img src="/images/icons/sword.png">Фолианты</a></li>
</div></div>


<?

require_once(HOME .'/incfiles/footer.php');

?>