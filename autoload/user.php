<?php

if (isset($_GET['login']) && isset($_GET['password']))
{
    # Проверяем существование аккавунта с этими данными
    if (DB::$dbs->querySingle("SELECT COUNT(*) FROM `users` WHERE `login` = '". input($_GET['login']) ."' AND `password` = '". encrypt(input($_GET['password'])) ."' LIMIT 1") == 1)
    {
        # Массив с данными пользователя
        $user = DB::$dbs->queryFetch("SELECT * FROM `users` WHERE `login` = '". input($_GET['login']) ."' AND `password` = '". encrypt(input($_GET['password'])) ."' LIMIT 1");
        
        # Создаем ID в сессии
        $_SESSION['user_id'] = $user['id'];
        
        # Записываем дату последнего посещения
        DB::$dbs->query("UPDATE `users` SET `date_last_entry` = '". time() ."', `onoff`='on' WHERE `id` = '$user[id]' LIMIT 1");
    }
    else $err .= 'Неверный логин или пароль<br />';
}
else if (isset($_POST['login']) && isset($_POST['password']))
{
    # Проверяем существование пользователя с такими данными
    if (DB::$dbs->querySingle("SELECT COUNT(*) FROM `users` WHERE `login` = '". input($_POST['login']) ."' AND `password` = '". encrypt(input($_POST['password'])) ."' LIMIT 1") == 1)
    {
        # Создаем массив с пользовательскими данными
        $user = DB::$dbs->queryFetch("SELECT * FROM `users` WHERE `login` = '". input($_POST['login']) ."' AND `password` = '". encrypt(input($_POST['password'])) ."' LIMIT 1");
        
        # Создаем ID в сессии
        $_SESSION['user_id'] = $user['id'];
        
        # Записываем дату последнего посещения
        DB::$dbs->query("UPDATE `users` SET `date_last_entry` = '". time() ."', `onoff`='on' WHERE `id` = '$user[id]' LIMIT 1");
        
        # Если передан параметр то записываем данные в куки
        if (isset($_POST['save_entry']))
        {
            setcookie('user_id', $user['id'], time() + 60 * 60 * 24 * 365);
            setcookie('password', encrypt(input($_POST['password'])), time() + 60 * 60 * 24 * 365);
        }               
    }
    else $err .= 'Неверный логин или пароль<br />';    
}                 
else if (isset($_SESSION['user_id']) && DB::$dbs->querySingle("SELECT COUNT(*) FROM `users` WHERE `id` = '". num($_SESSION['user_id']) ."' LIMIT 1") == 1)
{

    # Создаем массив с данными пользователя
    $user = DB::$dbs->queryFetch("SELECT * FROM `users` WHERE `id` = '". num($_SESSION['user_id']) ."' LIMIT 1");
    
    # Записываем дату последнего посещения
    DB::$dbs->query("UPDATE `users` SET `date_last_entry` = '". time() ."', `onoff`='on' WHERE `id` = '$user[id]' LIMIT 1");    
}
else if (isset($_COOKIE['user_id']) && isset($_COOKIE['password']) && $_COOKIE['user_id'] != NULL && $_COOKIE['password'] != NULL)
{
    # Проверяем наличие пользователя с указанными данными
    if (DB::$dbs->querySingle("SELECT COUNT(*) FROM `users` WHERE `id` = '". num($_COOKIE['user_id']) ."' AND `password` = '$_COOKIE[password]' LIMIT 1") == 1)
    {
        # Создаем массив с данными пользователя
        $user = DB::$dbs->queryFetch("SELECT * FROM `users` WHERE `id` = '". $_COOKIE['user_id'] ."' LIMIT 1");
        
        # Создаем ID в сессии
        $_SESSION['user_id'] = $user['id'];
        
        # Записываем дату последнего посещения
        DB::$dbs->query("UPDATE `users` SET `date_last_entry` = '". time() ."', `onoff`='on' WHERE `id` = '$user[id]' LIMIT 1");            
    }
    else
    {
        setcookie('user_id');
        setcookie('password');
    }
}

?>
