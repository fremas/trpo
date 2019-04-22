<?php

$system['page_title'] = 'Параметры';

require_once(HOME .'/incfiles/aut_check.php');
require_once(HOME .'/incfiles/header.php');

error($err);

if($user['avatar']!=''){
$avatar=''.$user['avatar'].'';
}else{
$avatar='standart/'.$user['sex'].'';
}

//Основная информация
echo '<center><b>Твой персонаж</b><br/>
<img src="/images/avatars/'.$avatar.'.png"></center><br/>';


//Параметры
echo '<div class="title">Параметры</div>';

echo '<img src="/images/icons/power.png"> <b>Сила</b>: '.$user['power'].' + '.$user['power_bonus'].'<br/>';

echo '<img src="/images/icons/defense.png"> <b>Защита</b>: '.$user['defense'].' + '.$user['defense_bonus'].'<br/>';

echo '<img src="/images/icons/speed.png"> <b>Ловкость</b>: '.$user['speed'].' + '.$user['speed_bonus'].'<br/>';

echo '<img src="/images/icons/skill.png"> <b>Мастерство</b>: '.$user['skill'].' + '.$user['skill_bonus'].'<br/>';

echo '<img src="/images/icons/heart.png"> <b>Живучесть</b>: '.$user['health'].' + '.$user['health_bonus'].'<br/>';

echo '<img src="/images/icons/heart.png"> Здоровье: '.$user['hp'].'<br/>';

echo '<img src="/images/icons/heart.png"> Здор. Макс.: '.$user['allhp'].'<br/>';

echo '<img src="/images/icons/heart.png"> Восст.: '.$user['hpregen'].' в час<br/><br/>';


//Статистика
echo '<div class="title">Статистика</div>';

echo '<img src="/images/icons/lvl.png"> Уровень: '.$user['lvl'].'<br/>';

echo '<img src="/images/icons/star_gold.png"> Опыт: '.$user['exp'].'<br/>';

echo '<img src="/images/icons/star_gold.png"> След. Ур.: '.$user['needexp'].'<br/>';

echo '<img src="/images/icons/fame.png"> Слава: '.$user['fame'].'<br/>';

echo '<img src="/images/icons/valor.png"> Карма: '.$user['karma'].'<br/>';

if($user['clan']!='not'){
echo '<img src="/images/icons/clan.png"> Клан: <a href="/clan/info.php?id='.$userclan['id'].'"><b>'.$userclan['name'].'</b></a><br/>';
}else{
echo '<img src="/images/icons/clan.png"> Не состоит в клане<br/>';
}

echo '<img src="/images/icons/victory_sword.png"> Побед: '.$user['wins'].'<br/>';

echo '<img src="/images/icons/skull.png"> Поражений: '.$user['loses'].'<br/>';

echo '<img src="/images/icons/silver.png"> Награбил: '.n_f($user['silverstole']).'<br/>';

echo '<img src="/images/icons/silver.png"> Украли: '.n_f($user['silverlost']).'<br/>';

echo '<img src="/images/icons/crystal.png"> Награбил: '.n_f($user['crystalstole']).'<br/>';

echo '<img src="/images/icons/crystal.png"> Украли: '.n_f($user['crystallost']).'<br/>';

echo '<img src="/images/icons/castle.png"> Минут в походе: '.$user['walk_minutes'].'<br/>';


//Меню
echo '</div><div class="main_list"><div class="menuList">
<li><a href="/user/training.php?"><img src="/images/icons/power.png">Тренировка</a></li>
<li><a href="/user/equipment.php?"><img src="/images/icons/armor.png">Экипировка</a></li>
</div></div>';

require_once(HOME .'/incfiles/footer.php');

?>