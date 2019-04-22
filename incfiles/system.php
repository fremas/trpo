<?php

// Фильтрация цисловых данных
function num($var)
{
    return abs(intval($var));
}

// Фильтрация текстовых данных
function txt($var)
{
    return htmlspecialchars(trim($var, ENT_QUOTES));
}

// Фильтрация перед записью в базу данных
function input($var)
{
    return trim($var);
}

// Фильтрация для правильного вывода из базы данных
function output($var)
{
    return nl2br($var, ENT_QUOTES);
}

// Шифрование пароля
function encrypt($var)
{
    return md5(base64_encode($var) .'SteamCore');
}

// Проверка длины русских символов
function strlen_rus($var)
{
    $rus_symbols = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я');

    return strlen(str_replace($rus_symbols, '0', $var));
}

//Фильтрация
function war($msg){
$msg = trim($msg);
$msg = htmlspecialchars($msg);
return $msg;
}

//Переменная настроек игры
$gameset = DB::$dbs->queryFetch("SELECT * FROM `gameset` WHERE `id` = '1' LIMIT 1");

//Листинг страниц (взят с warcms)
function page($k_page=1) {
$page = 1;
$page = war($page);
$k_page = war($k_page);
if(isset($_GET['selection'])) {
if ($_GET['selection']=='top')
$page = war(intval($k_page));
elseif(is_numeric($_GET['selection'])) 
$page = war(intval($_GET['selection']));
}
if ($page<1)$page=1;
if ($page>$k_page)$page=$k_page;
return $page;
}

// Определяем кол-во страниц
function k_page($k_post = 0,$k_p_str = 10) {
if ($k_post != 0) {
$v_pages = ceil($k_post/$k_p_str);
return $v_pages;
}
else return 1;
}

function str($link='?',$k_page=1,$page=1){
if ($page<1)$page=1;
$page = war($page);
$k_page = war($k_page);
echo '<center>';
if ($page>1)echo '<a href="'.$link.'selection='.($page-1).'"><div class="pages">&lt;&lt; Назад</div></a> ';
else echo "<div class='pages'>&lt;&lt; Назад</div>";
//echo " | ";
if ($page<$k_page)echo ' <a href="'.$link.'selection='.($page+1).'" ><div class="pages">Вперед &gt;&gt;</div></a>';
else echo "<div class='pages'>Вперед &gt;&gt;</div>";
echo '<br />';
if ($page != 1)
echo '<a href="'.$link.'selection=1" ><div class="pages">1</div></a>';
else echo '<div class="pages"><b>1</b></div>';
for ($ot=-3; $ot<=3; $ot++){
if ($page+$ot>1 && $page+$ot<$k_page){
if ($ot==-3 && $page+$ot>2)echo " ..";
if ($ot!=0)echo '<a href="'.$link.'selection='.($page+$ot).'" ><div class="pages">'.($page+$ot).'</div></a>';
else echo '<div class="pages"><b>'.($page+$ot).'</b></div>';
if ($ot==3 && $page+$ot<$k_page-1)echo "|..";}}
if ($page!=$k_page)echo '<a href="'.$link.'selection=top" ><div class="pages">'.$k_page.'</div></a>';
elseif ($k_page>1)echo '<div class="pages"><b>'.$k_page.'</b></div>';
echo '</center>';
}

// Обработка времени
function vtime($var)
{
    # Если время не задано берем текущее
    if ($var == NULL) $var = time();

    # Время + Дата
    $full_time = date('d.m.Y в H:i', $var);

    # Дата
    $date = date('d.m.Y', $var);

    # Время
    $time = date('H:i', $var);

    # Если текущаяя дата совпадает с заданной
    if ($date == date('d.m.Y')) $full_time = date('Сегодня в H:i', $var);

    # Вчерашняя дата
    if ($date == date('d.m.Y', time()-60*60*24)) $full_time = date('Вчера в H:i', $var);

    return $full_time;
}

# Получения настроек из базы данных
$sql_system = DB::$dbs->query("SELECT * FROM `system`");

foreach ($sql_system as $var_system) {
    $system[$var_system[0]] = $var_system[1];
}

# IP адрес
$system['ip'] = input($_SERVER['REMOTE_ADDR']);

# Браузер
$system['browser'] = input($_SERVER['HTTP_USER_AGENT']);

# Подключение файлов из папки /autoload/
$dir = opendir(HOME .'/autoload/');

while ($file = readdir($dir))
{
    if (preg_match('/\.php$/i', $file)) require_once(HOME .'/autoload/'. $file);
}

// Подключение библиотек
function require_lib($var)
{
    if (file_exists(HOME .'/libs/'. $var)) require_once(HOME .'/libs/'. $var);
    else exit('Невозможно подключить библиотеку '. $var);
}

// Вывод ошибок
function error($var)
{
    if (!empty($var)) echo '<div class="error">'. $var .'</div>';
}

//Вывод всплывающих сообщений
function info($var)
{
    if (!empty($var)) echo '<div class="info">'. $var .'</div>';
}

//Сбиваем онлайн, если долго нет в сети
$on=DB::$dbs->query("SELECT * FROM `users`");
foreach ($on as $onl) {
$time=time()-300;
if($onl['date_last_entry']<=$time){
mysql_query("UPDATE `users` SET `onoff` = 'off' WHERE `id` = '".$onl['id']."'");
}
}

//Функция вывода ника
function nick($id){
$users = DB::$dbs->queryFetch("SELECT * FROM `users` WHERE `id` = '".$id."' LIMIT 1");

if($users['onoff']=='on')
{
$on = '<img src="/images/icons/online.png">';
} else {
$on = '';
}

return (empty($users)?'[Удален]':'<img src="/images/icons/user_'.$users['sex'].'.png"><a href="/users/info.php?id='.$users['id'].'"><b>'.$users['login'].'</b></a> <img src="/images/icons/lvl.png"><font color=""><b>'.$users['lvl'].'</b></font> '.$on.'');
}

//Функция для разделения крупных чисел, с целью удобства чтения
function n_f($i) {
$i = number_format($i, 0, '', '\'');
return $i;
}

//Регенерация здоровья
$req=DB::$dbs->query("SELECT * FROM users");
foreach ($req as $hr) {
    $time=time();
    $timeregen=60*60;
    $point=intval(($time-$hr['hpregen_time'])/$timeregen);
    if($point>=1){
        $newhp=$hr['hp']+($hr['hpregen']*$point);
        if($newhp>$hr['allhp']){$newhp=$hr['allhp'];}
        DB::$dbs->query("UPDATE users SET hp = '$newhp',hpregen_time='$time' WHERE id = '$hr[id]'");
    }
}
if($user['hp']>$user['allhp']){
    DB::$dbs->query("UPDATE users SET hp = '".$user['allhp']."' WHERE id = '$user[id]'");
}


?>