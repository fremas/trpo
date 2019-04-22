<?php

$system['page_title'] = 'Тренировка';

require_once(HOME .'/incfiles/aut_check.php');

$powercost = round(pow($user['power']-4,2.6),0);
$defensecost = round(pow($user['defense']-4,2.35),0);
$speedcost = round(pow($user['speed']-4,2.3),0);
$skillcost = round(pow($user['skill']-4,2.5),0);
$healthcost = round(pow($user['health']-4,2.45),0);
$healthcost=$gameset['training_cost']*($user['health']-4);

switch($_GET['parameter']){

case 'power':
if($user['silver']<$powercost){
	header('Location: /user/training.php?err');
	exit;
}else{
	$newpower=$user['power']+1;
	$newsilver=$user['silver']-$powercost;
	DB::$dbs->query("UPDATE `users` SET
	 `power` = '$newpower',
	 `silver` = '$newsilver'
	 WHERE `id` = '".$user['id']."'");
	header('Location: /user/training.php?');
	exit;
}
break;

case 'defense':
if($user['silver']<$defensecost){
header('Location: /user/training.php?err');
exit;
}else{
$newdefense=$user['defense']+1;
$newsilver=$user['silver']-$defensecost;
DB::$dbs->query("UPDATE `users` SET
 `defense` = '$newdefense',
 `silver` = '$newsilver'
 WHERE `id` = '".$user['id']."'");
header('Location: /user/training.php?');
exit;
}
break;

case 'speed':
if($user['silver']<$speedcost){
header('Location: /user/training.php?err');
exit;
}else{
$newspeed=$user['speed']+1;
$newsilver=$user['silver']-$speedcost;
DB::$dbs->query("UPDATE `users` SET
 `speed` = '$newspeed',
 `silver` = '$newsilver'
 WHERE `id` = '".$user['id']."'");
header('Location: /user/training.php?');
exit;
}
break;

case 'skill':
if($user['silver']<$skillcost){
header('Location: /user/training.php?err');
exit;
}else{
$newskill=$user['skill']+1;
$newsilver=$user['silver']-$skillcost;
DB::$dbs->query("UPDATE `users` SET
 `skill` = '$newskill',
 `silver` = '$newsilver'
 WHERE `id` = '".$user['id']."'");
header('Location: /user/training.php?');
exit;
}
break;

case 'health':
if($user['silver']<$healthcost){
header('Location: /user/training.php?err');
exit;
}else{
$newhealth=$user['health']+1;
$newallhp=$user['allhp']+10;
$newhpregen=$user['hpregen']+3;
$newsilver=$user['silver']-$healthcost;
DB::$dbs->query("UPDATE `users` SET
 `health` = '$newhealth',
 `allhp` = '$newallhp',
 `hpregen` = '$newhpregen',
 `silver` = '$newsilver'
 WHERE `id` = '".$user['id']."'");
header('Location: /user/training.php?');
exit;
}
break;

}

if(isset($_GET['err'])){
$err='Недостаточно серебра.';
}

require_once(HOME .'/incfiles/header.php');



echo '<center><b>Тренировка</b></center><br/>
Тут ты можешь улучшить характеристики своего персонажа.<br/><br/><hr>';

echo '<img class="float-left" src="/images/icons/big/power.jpg" width="48px""><b>Сила</b><br/>
Уровень: <b>'.$user['power'].'</b><br/>
Цена улучшения: <b>'.$powercost.' серебра</b>
<center><a href="?parameter=power"><div class="button">Улучшить</div></a></center><hr>';

echo '<img class="float-left" src="/images/icons/big/defense.jpg" width="48px""><b>Защита</b><br/>
Уровень: <b>'.$user['defense'].'</b><br/>
Цена улучшения: <b>'.$defensecost.' серебра</b>
<center><a href="?parameter=defense"><div class="button">Улучшить</div></a></center><hr>';

echo '<img class="float-left" src="/images/icons/big/speed.jpg" width="48px""><b>Ловкость</b><br/>
Уровень: <b>'.$user['speed'].'</b><br/>
Цена улучшения: <b>'.$speedcost.' серебра</b>
<center><a href="?parameter=speed"><div class="button">Улучшить</div></a></center><hr>';

echo '<img class="float-left" src="/images/icons/big/skill.jpg" width="48px""><b>Мастерство</b><br/>
Уровень: <b>'.$user['skill'].'</b><br/>
Цена улучшения: <b>'.$skillcost.' серебра</b>
<center><a href="?parameter=skill"><div class="button">Улучшить</div></a></center><hr>';

echo '<img class="float-left" src="/images/icons/big/health.jpg" width="48px""><b>Живучесть</b><br/>
Уровень: <b>'.$user['health'].'</b><br/>
Цена улучшения: <b>'.$healthcost.' серебра</b>
<center><a href="?parameter=health"><div class="button">Улучшить</div></a></center><hr>';


echo '</div><div class="main_list"><div class="menuList">
<li><a href="/users/info.php?id='.$user['id'].'"><img src="/images/icons/user_'.$user['sex'].'.png">Профиль</a></li>
<li><a href="/user/equipment.php?"><img src="/images/icons/armor.png">Экипировка</a></li>
</div></div>';

require_once(HOME .'/incfiles/footer.php');

?>