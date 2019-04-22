<?php

echo '<?xml version="1.0" encoding="utf-8"?>

<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">

<head>
<meta http-equiv="Content-Type" content="application/vnd.wap.xhtml+xml; charset=UTF-8" />
<meta name="description" content="Тест Игра - Новая мобильная онлайн игра" />
<meta name="keywords" content="testgame.ru, testgame, мобильная онлайн игра" />
<link rel="shortcut icon" href="'. URL .'/design/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="'. URL .'/design/style.css" type="text/css" />
<title>'. $system['page_title'] .'</title>
</head>

<body>';



if($user==0){

echo '<div class="head">';

echo '<center><b>Герои</b></center>';


}else{

//Восстановление боёв
$time=time();
$timeregenbattle=360;
$battlepoint=intval(($time-$user['battle_regen_time'])/$timeregenbattle);
if($battlepoint>=1){
	$newbattles=$user['battles']+(1*$battlepoint);
	if($newbattles>$user['allbattles']){$newbattles=$user['allbattles'];}
	DB::$dbs->query("UPDATE users SET battles = '$newbattles',battle_regen_time='$time' WHERE id = '$user[id]'");
}
if($user['battles']>=$user['allbattles']){
	DB::$dbs->query("UPDATE users SET battle_regen_time='$time' WHERE id = '$user[id]'");
}

//Если серебра больше чем позволяет уровень
if($user['silver']>$user['allsilver']){
DB::$dbs->query("UPDATE users SET
 silver = '$user[allsilver]'
 WHERE id = '$user[id]' LIMIT 1");
$info='Вы накопили максимальное количество серебра для вашего уровня. Потратьте его, чтобы можно было снова получать начисления.';
}

//Система уровней
if($user[exp]>=$user[needexp]){
if($user[lvl]==50){
DB::$dbs->query("UPDATE `users` SET `exp` = '$user[needexp]' WHERE `id` = '$user[id]' LIMIT 1");
}else{
$lvlup=1;
$newlvl=$user[lvl]+1;
$newexp=$user[exp]-$user[needexp];
$newneedexp=$user[needexp]*2;
$silver=1250*$newlvl;
$plussilver=$user[silver]+$silver;
$gold=5*$newlvl;
$plusgold=$user[gold]+$gold;
$allsilver=2500*$newlvl;
$newallsilver=$user[allsilver]+$allsilver;
if($newlvl>=5){
$battlecost=3*($newlvl-4);
}else{$battlecost=0;}
$info='Достигнут '.$newlvl.' уровень.<br/>';
DB::$dbs->query("UPDATE users SET
 lvl = '$newlvl',
 exp = '$newexp',
 needexp = '$newneedexp',
 battles = '$user[allbattles]',
 battle_cost = '$battlecost',
 silver = '$plussilver',
 allsilver = '$newallsilver',
 gold = '$plusgold',
 hp = '$user[allhp]'
 WHERE id = '$user[id]' LIMIT 1");
DB::$dbs->query("INSERT INTO `journal` SET 
`user_id` = '".$user['id']."',
`title` = 'Поздравляем!',
`message` = 'Вы достигли ".$newlvl." уровня. Начислено ".$silver." серебра и ".$gold." золота. Приятной игры!',
`date` = '". time() ."',
`read` = '0'");
}
}

//Счетчик минут до восстановления боя
$battleregentime=$user['battle_regen_time']+180;
$count=$battleregentime-$time;
if($user['battles']>=$user['allbattles']){$count=0;}
if($count>180){$count=0;}
if($count<0){$count=0;}
$timetobattle=date('i:s', $count);

error($err);
info($info);

echo '<div class="head">';

echo '<center>
'.nick($user['id']).'  <img src="/images/icons/heart.png">'.$user['hp'].'<br/>
<img src="/images/icons/silver.png">'.n_f($user['silver']).' <img src="/images/icons/gold.png">'.n_f($user['gold']).' <img src="/images/icons/crystal.png">'.n_f($user['crystal']).'<br/>
<img src="/images/icons/swords.png">'.$user['battles'].'/'.$user['allbattles'].' <img src="/images/icons/clock.png">'.$timetobattle.'
</center>';

}

echo '</div><div class="menu">';


?>