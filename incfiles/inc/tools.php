<?php
// HTTPS
function isHttps() {

    return (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off');

}
// короткий текст
function shortText($str, $max) {

    return (mb_strlen($str) > $max ? mb_substr($str, 0, $max) . '...' : $str);

}
// Рандомайзер float чисел
function f_rand($min, $max) {

    // Проверяем
    if ($min > $max)
            return false;

    // Числа ли это?
    if (!is_numeric($min) ||
        !is_numeric($max))
            return false;

    // Оптимизация :)
    if ($min == $max)
            return $min;

    // Ищем цифры после запятой
    $com_min = explode('.', $min)[1];
    $com_max = explode('.', $max)[1];

    // Считаем количество цифр после запятой
    $ch_min = iconv_strlen($com_min);
    $ch_max = iconv_strlen($com_max);

    // Находит общее число для преобразование в int и обратно
    $mul = $ch_min > $ch_max ? pow(10, $ch_min) : pow(10, $ch_max);

    // Преобразуем в int, рандомим и преобразуем в float
    $random = mt_rand($min * $mul, $max * $mul) / $mul;

    return $random;

}
// Склонение количеств
function quantDec($num, $word) {

    $col = intval($num);
    $rest = substr($col, -1);

    if ($col > 10 && $col < 20) {

        $res = trim($word[2]);

    } elseif ($rest > 1 && $rest < 5) {

        $res = trim($word[1]);

    } elseif ($rest == 1) {

        $res = trim($word[0]);

    } else {

        $res = trim($word[2]);

    }

    return $num . ' ' . $res;

}
// Поиск тегов
function tagSearch($str) {

    $tags = preg_split('/[\s,]+/', $str);

    return $tags;

}
// Вывод тегов
function taglink($str, $href) {

    $res = NULL;

    $explode = tagSearch($str);

    foreach ($explode as $tag) {

        $res .= '<a href="' . $href . urlencode($tag) . '">' . $tag . '</a>, ';

    }

    $res = trim($res, ', ');

    return $res;

}
// Проверяем существование домена
function isSiteAvailable($url) {

    if (filter_var($url, FILTER_VALIDATE_URL)) {

        $init = curl_init($url);
        curl_setopt($init, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($init, CURLOPT_HEADER, true);
        curl_setopt($init, CURLOPT_NOBODY, true);
        curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($init);
        curl_close($init);

        return $response;

    } else
        return false;

}
// Функция отправки почты на email
function mailto($mail, $theme, $text, $str) {

    $adt = 'From: ' . $str . PHP_EOL;
    $adt .= 'X-sender: < ' . $str . ' >' . PHP_EOL;
    $adt .= 'Content-Type: text/html; charset=utf-8' . PHP_EOL;

    return mail($mail, $theme, $text, $adt);

}
// Транслит
function rus2translit($str) {

    $rus = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К',
                 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц',
                 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в',
                 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н',
                 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ',
                 'ъ', 'ы', 'ь', 'э', 'ю', 'я'];

    $lat = ['A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K',
                'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C',
                'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v',
                'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o',
                'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch',
                'y', 'y', 'y', 'e', 'yu', 'ya'];

    $str = str_replace($rus, $lat, $str);

    return $str;

}
// Валидация url
function str2url($str) {

    // переводим в транслит
    $str = rus2translit($str);

    // заменям все ненужное нам на тире
    $str = preg_replace('~[^-a-zA-Z0-9_]+~u', '-', $str);

    // удаляем начальные и конечные тире
    $str = trim($str, '-');

    return $str;

}
// Генератор пароля
function gen_pass($col = 6) {

    $mask = "0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz";

    $password = NULL;

    for ($i = 0; $i < $col; $i++) {

        $password.= $mask[random_int(0, 61)];

    }

    return $password;

}
// Иконка девайса
function deviceIcon($ua) {

    $detect = new Mobile_Detect;
    $detect->setUserAgent($ua);

    if ($detect->isTablet()) {
        // планшет
        $device = '<i class="zmdi zmdi-tablet"></i>';
    } elseif ($detect->isMobile()) {
        // телефон
        $device = '<i class="zmdi zmdi-smartphone"></i>';
    } else {
        // пк
        $device = '<i class="zmdi zmdi-desktop-windows"></i>';
    }

    return $device;

}