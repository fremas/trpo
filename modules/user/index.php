<?php

$system['page_title'] = 'Персонаж';

require_once(HOME .'/incfiles/aut_check.php');
require_once(HOME .'/incfiles/header.php');

error($err);

if($user['avatar']!=''){
$avatar=''.$user['avatar'].'';
}else{
$avatar='standart/'.$user['sex'].'';
}

echo '<center>
<b>Персонаж</b><br/>
<img src="/images/avatars/'.$avatar.'.png">
</center>';

echo '</div><div class="main_list"><div class="menuList">
<li><a href="/users/info.php?id='.$user['id'].'"><img src="/images/icons/user_'.$user['sex'].'.png">Профиль</a></li>
<li><a href="/user/parameters.php?"><img src="/images/icons/question_blue.png">Параметры</a></li>
<li><a href="/user/training.php?"><img src="/images/icons/power.png">Тренировка</a></li>
<li><a href="/user/equipment.php?"><img src="/images/icons/armor.png">Экипировка</a></li>
<li><a href="/user/bag.php?"><img src="/images/icons/bag.png">Инвентарь</a></li>
<li><a href="/user/exit.php?"><img src="/images/icons/no.png"><font color="#e83839">Выход</font></a></li>
</div></div>';

require_once(HOME .'/incfiles/footer.php');

?>