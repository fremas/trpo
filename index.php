<?php

/**
 * Автор Steam Core, Steam CMS: Платонов Кирилл (Plato)
 * ICQ: 258549
 * E-Mail: platonov-kd@ya.ru
 * Оф. сайт: http://scms.su
 * Сайт: http://promob.net
 */ 

# Время генерации
$time_gen = microtime();

# Серверный путь к сайту
define('HOME', $_SERVER['DOCUMENT_ROOT']);

# Полный HTTP путь к сайту
define('URL', 'http://'. $_SERVER['HTTP_HOST']);

# Получение настроек сервера
require_once(HOME .'/incfiles/ini_set.php');

# Получения настроек MySQL
require_once(HOME .'/incfiles/db_ini.php');

# Кодировка соединения
DB::$dbs->query("SET NAMES utf8");

# Старт сессий
session_name('sid');
session_start();

# Подключение основного системного файла
require_once(HOME .'/incfiles/system.php');

# Очистка запроса модуля
$module = txt($_GET['url']);

// Проверка наличия файла в запросе
if (preg_match('/\.php$/i', $module)) $module_file = true;
else $module_file = false;

// Если запрашивается какой-либо модуль
if (!empty($module))
{
    // Проверяем существование
    if (file_exists(HOME .'/modules/'. $module) && $module_file == true)
    {
        # Подключаем модуль
        require_once(HOME .'/modules/'. $module);
    }
    else if (file_exists(HOME .'/modules/'. $module) && $module_file == false)
    {
        // Проверяем наличие главной страницы модуля
        if (file_exists(HOME .'/modules/'. $module .'/index.php'))
        {
            # Подключаем главную страницу модуля
            require_once(HOME .'/modules/'. $module .'/index.php');
        }
        else
        {
            # Подключаем главную страницу сайта
            require_once(HOME .'/modules/index.php');
        }
    }
    else
    {
        # Подключаем главную страницу сайта
        require_once(HOME .'/modules/index.php');
    }
}
else
{
    # Подключаем главную страницу сайта
    require_once(HOME .'/modules/index.php');
}

?>