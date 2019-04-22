<?php

echo '</div>';

if($user!=0){
echo '</div><div class="foot_list"><div class="menuList">
<li><a href="/"><img src="/images/icons/home.png">Главная</a></li>
<li><a href="/user/"><img src="/images/icons/user_'.$user['sex'].'.png">Персонаж</a></li>
<li><a href="/chat/"><img src="/images/icons/feather.png">Чат</a></li>
<li><a href="/mail/"><img src="/images/icons/mail.png">Почта</a></li>
<li><a href="/gold/"><img src="/images/icons/gold.png"><font color="gold">Золото</font></a></li>
</div></div>';
}

# Вывод копирайта
echo '<div class="foot">AlexHated &copy; 2018</div>';

exit;

?>
