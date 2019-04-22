<?php

$system['page_title'] = 'Дуэль';

require_once(HOME .'/incfiles/aut_check.php');

if($user['lvl']<5){
header('Location: /duel/index.php?error=1&bot=crystal');
exit;
}

if($user['battles']==0){
header('Location: /duel/index.php?error=1');
exit;
}

$needhp=$user['allhp']/10;
if($user['hp']<$needhp){
header('Location: /duel/index.php?error=1');
exit;
}

if($user['silver']<$user['battle_cost']){
header('Location: /duel/index.php?error=1');
exit;
}


$req = mysql_query("SELECT * FROM `bots_crystal` WHERE `user_id` = '".$user['id']."'");
$bot = mysql_fetch_array($req);
if($bot['attacked']==1){
header('Location: /duel/bot_crystal.php?');
end;
}

require_once(HOME .'/incfiles/header.php');


switch($_GET['act']){

default:

//Плата серебра за поиск
if($bot['attacked']!='1'){
$newsilver=$user['silver']-$user['battle_cost'];

mysql_query("UPDATE `users` SET
 `silver` = '$newsilver'
 WHERE `id` = '".$user['id']."' LIMIT 1");
}

$powermin=$user['power']+5;
$powermax=$user['power']+10;
$botpower=rand($powermin, $powermax);
$defensemin=$user['defense']+5;
$defensemax=$user['defense']+10;
$botdefense=rand($defensemin, $defensemax);
$speedmin=$user['speed']+5;
$speedmax=$user['speed']+10;
$botspeed=rand($speedmin, $speedmax);
$skillmin=$user['skill']+5;
$skillmax=$user['skill']+10;
$botskill=rand($skillmin, $skillmax);
$healthmin=$user['health']+5;
$healthmax=$user['health']+10;
$bothealth=rand($healthmin, $healthmax);

//Если не создана таблица ботов для игрока
if(empty($bot)){
mysql_query("INSERT INTO `bots_crystal` SET 
		`user_id` = '".$user['id']."'");
}

//Обновляем бота в таблице
mysql_query("UPDATE `bots_crystal` SET
 `power` = '$botpower',
 `defense` = '$botdefense',
 `speed` = '$botspeed',
 `skill` = '$botskill',
 `health` = '$bothealth',
 `attacked` = '0'
 WHERE `user_id` = '".$user['id']."' LIMIT 1");
 
echo '<center><b>Дуэль</b><br/><br/>
<b>'.$user['login'].'</b> против <b>Кристальный Наёмник</b></center>';

if($user['avatar']!=''){
$avatar=''.$user['avatar'].'';
}else{
$avatar='standart/'.$user['sex'].'';
}

echo'
<table align="center" width="75%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="center" width="50%" class="spacing">
<img src="/images/avatars/'.$avatar.'.png"><br></a></td>
<td align="center" width="50%" class="spacing">
<img src="/images/faces/bots/bot_crystal.png"><br></a></td>
</tr></table>';

echo'
<table align="center" width="55%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="center" width="20%" class="spacing">
'.$user['power'].'<br>
'.$user['defense'].'<br>
'.$user['speed'].'<br>
'.$user['skill'].'<br>
'.$user['health'].'<br></td>
<td align="center" width="20%" class="spacing">
<img src="/images/icons/power.png"><br>
<img src="/images/icons/defense.png"><br>
<img src="/images/icons/speed.png"><br>
<img src="/images/icons/skill.png"><br>
<img src="/images/icons/health.png"><br></td>
<td align="center" width="20%" class="spacing">
'.$botpower.'<br>
'.$botdefense.'<br>
'.$botspeed.'<br>
'.$botskill.'<br>
'.$bothealth.'<br></td>
</tr></table>';

echo '<center><a href="?act=attack"><div class="button">Атаковать</div></a></center>';

echo '</div><div class="main_list"><div class="menuList">
<li><a href="/duel/bot_crystal.php?"><img src="/images/icons/sword.png">Следующий</a></li>
<li><a href="/duel/bot.php?"><img src="/images/icons/bot.png">Обычные</a></li>
<li><a href="/duel/bot_gold.php?"><img src="/images/icons/bot.png">Золотые</a></li>
<li><a href="/duel/"><img src="/images/icons/swords.png">Дуэль</a></li>
</div></div>';


break;

case 'attack':

$newbattles=$user['battles']-1;

mysql_query("UPDATE `users` SET
 `battles` = '".$newbattles."'
 WHERE `id` = '".$user['id']."'");

mysql_query("UPDATE `bots_crystal` SET
 `attacked` = '1'
 WHERE `user_id` = '".$user['id']."'");

$userpower=$user['power']+$user['power_bonus'];
$userdefense=$user['defense']+$user['defense_bonus'];
$userspeed=$user['speed']+$user['speed_bonus'];
$userskill=$user['skill']+$user['skill_bonus'];

//Считаем удар юзера

$botdef=rand(0,$bot['defense']);
if($botdef>$bot['defense']){
$botdef=$bot['defense'];
}

$userhit=$userpower-$botdef;

if($userhit<0){
$userhit=0;
}

//Считаем удар бота

$userdef=rand(0,$userdefense);
if($userdef>$userdefense){
$userdef=$userdefense;
}

$bothit=$bot['power']-$userdef;

if($bothit<0){
$bothit=0;
}

//Считаем шанс уворота игрока
$userspeedchance=$userspeed/10;
$userspeedrand=rand(0,100);

if($userspeedrand<=$userspeedchance){
$bothit=0;
$botspeedwhy=' (Вы увернулись)';
$win='user';
}

//Считаем шанс уворота бота
$botspeedchance=$bot['speed']/10;
$botspeedrand=rand(0,100);

if($botspeedrand<=$botspeedchance && $win!='user'){
$userhit=0;
$userspeedwhy=' (Кристальный Наёмник увернулся)';
}

//Считаем критический удар игрока
$userskillchance=$userskill/10;
$userskillrand=rand(0,100);

if($userskillrand<=$userskillchance){
if($userhit>0){
$userhit=$userhit*2;
$userskillwhy=' (Критический удар)';
}
}

//Считаем критический удар бота
$botskillchance=$bot['skill']/10;
$botskillrand=rand(0,100);

if($botskillrand<=$botskillchance){
if($bothit>0){
$bothit=$bothit*2;
$botskillwhy=' (Критический удар)';
}
}

//Если нанесён равный урон, то победа идёт в пользу игрока
if($userhit==$bothit){
$userhit=$userhit+1;
}

//Отнимаем от здоровья игрока нанесенный урон
$newhp=$user['hp']-$bothit;
if($newhp<0){$newhp=0;}
mysql_query("UPDATE `users` SET
 `hp` = '$newhp'
 WHERE `id` = '".$user['id']."'");

//Победа
if($userhit>$bothit){

$newwins=$user['wins']+1;
mysql_query("UPDATE `users` SET
 `wins` = '$newwins'
 WHERE `id` = '".$user['id']."'");

//Награда опыта
$exprand=rand(3,5);
$newexp=$user['exp']+$exprand;
//Награда серебра
$maxsilver=$gameset['bot_crystal_silver']*$user['lvl'];
$minsilver=$maxsilver/2;
$silverrand=rand($minsilver,$maxsilver)+$userhit;
$newsilver=$user['silver']+$silverrand;
$newsilverstole=$user['silverstole']+$silverrand;
//Награда кристаллов
$maxcrystal=$gameset['bot_crystal_crystal']*$user['lvl'];
$mincrystal=$maxcrystal/4;
$crystalrand=rand($mincrystal, $maxcrystal);
$newcrystal=$user['crystal']+$crystalrand;
$newcrystalstole=$user['crystalstole']+$crystalrand;
mysql_query("UPDATE `users` SET
 `exp` = '$newexp',
 `silver` = '$newsilver',
 `crystal` = '$newcrystal',
 `silverstole` = '$newsilverstole',
 `crystalstole` = '$newcrystalstole'
 WHERE `id` = '".$user['id']."'");  


echo '<center><img src="/images/arts/win.jpg"><br/>
<b>Итог боя</b></center><hr>
<font color="#33cc33"><b>Ты победил</b></font><br/>
Причина - Победитель нанёс больше суммарного урона<br/>
Опыт: <img src="/images/icons/star_gold.png">'.$exprand.'<br/>
Награда: <img src="/images/icons/silver.png">'.n_f($silverrand).' серебра<br/>
Награда: <img src="/images/icons/crystal.png">'.n_f($crystalrand).' кристаллов<hr>
<b>Нанесённый урон:</b><br/>
'.$user['login'].': '.$userhit.''.$userskillwhy.'<br/>
Кристальный Наёмник: '.$bothit.''.$botspeedwhy.'<hr>';

echo '</div><div class="main_list"><div class="menuList">
<li><a href="/duel/bot_crystal.php?"><img src="/images/icons/sword.png">Следующий</a></li>
<li><a href="/duel/"><img src="/images/icons/swords.png">Дуэль</a></li>
</div></div>';

require_once(HOME .'/incfiles/footer.php');
exit;

//Поражение
}elseif($userhit<=$bothit){

$newloses=$user['loses']+1;
mysql_query("UPDATE `users` SET
 `loses` = '$newloses'
 WHERE `id` = '".$user['id']."'");

//Потери серебра
$gamesetsilver=$gameset['bot_crystal_silver']*$user['lvl'];
$maxsilver=$gamesetsilver/2;
$minsilver=$maxsilver/4;
$silverrand=rand($minsilver,$maxsilver)+$bothit;
$newsilver=$user['silver']-$silverrand;
$newsilverlost=$user['silverlost']+$silverrand;
if($newsilver<0){
$newsilver=0;
}
//Потери кристаллов
$gamesetcrystal=$gameset['bot_crystal_crystal']*$user['lvl'];
$maxcrystal=$gamesetcrystal/2;
$mincrystal=$maxcrystal/4;
$crystalrand=rand($mincrystal,$maxcrystal);
$newcrystal=$user['crystal']-$crystalrand;
$newcrystallost=$user['crystallost']+$crystalrand;
if($newcrystal<0){
$newcrystal=0;
}
mysql_query("UPDATE `users` SET
 `silver` = '$newsilver',
 `crystal` = '$newcrystal',
 `silverlost` = '$newsilverlost',
 `crystallost` = '$newcrystallost'
 WHERE `id` = '".$user['id']."'");  

echo '<center><img src="/images/arts/lose.jpg"><br/>
<b>Итог боя</b></center><hr>
<font color="#e83839"><b>Ты проиграл</b></font><br/>
Причина - Победитель нанёс больше суммарного урона<br>
Потери: <img src="/images/icons/silver.png">'.n_f($silverrand).' серебра<br/>
Потери: <img src="/images/icons/crystal.png">'.n_f($crystalrand).' кристаллов<hr>
<b>Нанесённый урон:</b><br/>
'.$user['login'].': '.$userhit.''.$userspeedwhy.'<br/>
Кристальный Наёмник: '.$bothit.''.$botskillwhy.'<hr>';

echo '</div><div class="main_list"><div class="menuList">
<li><a href="/duel/bot_crystal.php?"><img src="/images/icons/sword.png">Следующий</a></li>
<li><a href="/duel/"><img src="/images/icons/swords.png">Дуэль</a></li>
</div></div>';

require_once(HOME .'/incfiles/footer.php');
exit;

}



break;

}

require_once(HOME .'/incfiles/footer.php');

?>