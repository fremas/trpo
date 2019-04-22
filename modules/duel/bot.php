<?php

$system['page_title'] = 'Дуэль';

require_once(HOME .'/incfiles/aut_check.php');

if($user['battles']==0){
header('Location: /duel/index.php?error=1');
exit;
}


if($user['hp']<80){
header('Location: /duel/index.php?error=1');
exit;
}

if($user['silver']<$user['battle_cost']){
header('Location: /duel/index.php?error=1');
exit;
}


$bot = DB::$dbs->queryFetch("SELECT * FROM `bots` WHERE `user_id` = '".$user['id']."'");
if($bot['attacked']==1){
header('Location: /duel/bot.php?');
end;
}

require_once(HOME .'/incfiles/header.php');


switch($_GET['act']){

default:

//Плата серебра за поиск
if($bot['attacked']!='1'){
$newsilver=$user['silver']-$user['battle_cost'];

DB::$dbs->query("UPDATE `users` SET
 `silver` = '$newsilver'
 WHERE `id` = '".$user['id']."' LIMIT 1");
}

$powermin=$user['power']-3;
$botpower=rand($powermin, $user['power']);
$defensemin=$user['defense']-3;
$botdefense=rand($defensemin, $user['defense']);
$speedmin=$user['speed']-3;
$botspeed=rand($speedmin, $user['speed']);
$skillmin=$user['skill']-3;
$botskill=rand($skillmin, $user['skill']);
$healthmin=$user['health']-3;
$bothealth=rand($healthmin, $user['health']);

//Если не создана таблица ботов для игрока
if(empty($bot)){
DB::$dbs->query("INSERT INTO `bots` SET 
		`user_id` = '".$user['id']."'");
}

//Обновляем бота в таблице
DB::$dbs->query("UPDATE `bots` SET
 `power` = '$botpower',
 `defense` = '$botdefense',
 `speed` = '$botspeed',
 `skill` = '$botskill',
 `health` = '$bothealth',
 `attacked` = '0'
 WHERE `user_id` = '".$user['id']."' LIMIT 1");
 
echo '<center><b>Дуэль</b><br/><br/>
<b>'.$user['login'].'</b> против <b>Наёмник</b></center>';

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
<img src="/images/faces/bots/bot.png"><br></a></td>
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
<li><a href="/duel/bot.php?"><img src="/images/icons/sword.png">Следующий</a></li>
<li><a href="/duel/bot_crystal.php?"><img src="/images/icons/bot.png">Кристальные</a></li>
<li><a href="/duel/bot_gold.php?"><img src="/images/icons/bot.png">Золотые</a></li>
<li><a href="/duel/"><img src="/images/icons/swords.png">Дуэль</a></li>
</div></div>';


break;

case 'attack':

$newbattles=$user['battles']-1;

DB::$dbs->query("UPDATE `users` SET
 `battles` = '".$newbattles."'
 WHERE `id` = '".$user['id']."'");

DB::$dbs->query("UPDATE `bots` SET
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
$userspeedwhy=' (Наёмник увернулся)';
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
DB::$dbs->query("UPDATE `users` SET
 `hp` = '$newhp'
 WHERE `id` = '".$user['id']."'");

//Победа
if($userhit>$bothit){

$newwins=$user['wins']+1;
DB::$dbs->query("UPDATE `users` SET
 `wins` = '$newwins'
 WHERE `id` = '".$user['id']."'");

$exprand=rand(1,3);
$newexp=$user['exp']+$exprand;
$maxsilver=$gameset['bot_silver']*$user['lvl'];
$minsilver=$maxsilver/2;
$silverrand=rand($minsilver,$maxsilver)+$userhit;
$newsilver=$user['silver']+$silverrand;
$newsilverstole=$user['silverstole']+$silverrand;
DB::$dbs->query("UPDATE `users` SET
 `exp` = '$newexp',
 `silver` = '$newsilver',
 `silverstole` = '$newsilverstole'
 WHERE `id` = '".$user['id']."'");  

/*
if($exprand!=0){
$exp='Опыт: <img src="/images/icons/star_gold.png">'.$exprand.'<br/>';
}else{
$exp='';
}
*/

echo '<center><img src="/images/arts/win.jpg"><br/>
<b>Итог боя</b></center><hr>
<font color="#33cc33"><b>Ты победил</b></font><br/>
Причина - Победитель нанёс больше суммарного урона<br/>
Опыт: <img src="/images/icons/star_gold.png">'.$exprand.'<br/>
Награда: <img src="/images/icons/silver.png">'.n_f($silverrand).' серебра<hr>
<b>Нанесённый урон:</b><br/>
'.$user['login'].': '.$userhit.''.$userskillwhy.'<br/>
Наёмник: '.$bothit.''.$botspeedwhy.'<hr>';

echo '</div><div class="main_list"><div class="menuList">
<li><a href="/duel/bot.php?"><img src="/images/icons/sword.png">Следующий</a></li>
<li><a href="/duel/"><img src="/images/icons/swords.png">Дуэль</a></li>
</div></div>';

require_once(HOME .'/incfiles/footer.php');
exit;

//Поражение
}elseif($userhit<=$bothit){

$newloses=$user['loses']+1;
DB::$dbs->query("UPDATE `users` SET
 `loses` = '$newloses'
 WHERE `id` = '".$user['id']."'");

$gamesetsilver=$gameset['bot_silver']*$user['lvl'];
$maxsilver=$gamesetsilver/2;
$minsilver=$maxsilver/4;
$silverrand=rand($minsilver,$maxsilver)+$bothit;
$newsilver=$user['silver']-$silverrand;
$newsilverlost=$user['silverlost']+$silverrand;
if($newsilver<0){
$newsilver=0;
}
DB::$dbs->query("UPDATE `users` SET
 `silver` = '$newsilver',
 `silverlost` = '$newsilverlost'
 WHERE `id` = '".$user['id']."'");  

echo '<center><img src="/images/arts/lose.jpg"><br/>
<b>Итог боя</b></center><hr>
<font color="#e83839"><b>Ты проиграл</b></font><br/>
Причина - Победитель нанёс больше суммарного урона<br>
Потери: <img src="/images/icons/silver.png">'.n_f($silverrand).' серебра<hr>
<b>Нанесённый урон:</b><br/>
'.$user['login'].': '.$userhit.''.$userspeedwhy.'<br/>
Наёмник: '.$bothit.''.$botskillwhy.'<hr>';

echo '</div><div class="main_list"><div class="menuList">
<li><a href="/duel/bot.php?"><img src="/images/icons/sword.png">Следующий</a></li>
<li><a href="/duel/"><img src="/images/icons/swords.png">Дуэль</a></li>
</div></div>';

require_once(HOME .'/incfiles/footer.php');
exit;

}



break;

}

require_once(HOME .'/incfiles/footer.php');

?>