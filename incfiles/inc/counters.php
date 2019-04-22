<?php

if(isset($user['id'])){	

// Уведомления
$raznoe_new = DB::$dbs->querySingle('select count(*) from `op` where `who` = '.$user['id'].' and `read` = 0 and `sort` = 1');
$forum_new = DB::$dbs->querySingle('select count(*) from `op` where `who` = '.$user['id'].' and `read` = 0 and `sort` = 2');
$komm_new = DB::$dbs->querySingle('select count(*) from `op` where `who` = '.$user['id'].' and `read` = 0 and `sort` = 3');
$repa_new = DB::$dbs->querySingle('select count(*) from `op` where `who` = '.$user['id'].' and `read` = 0 and `sort` = 4');
$bill_new = DB::$dbs->querySingle('select count(*) from `op` where `who` = '.$user['id'].' and `read` = 0 and `sort` = 5');

// Новые уведомления
    $c_new_not = DB::$dbs->querySingle("select count(*) from `op` where `read` = '0' and `who` = ".$user['id']."");
    //$new_not = $c_new_not > 0 ? '<i class="hi-count">'.($c_new_not < 100 ? $c_new_not : '99+').'</i>' : '';
    $new_not = $c_new_not > 0 ? ($c_new_not < 10 ? '<i class="hi-count">'.$c_new_not.'</i>' : '<i class="hi-count">+</i>') : '';
	
// Новые уведомления
    $c_new_alert = DB::$dbs->querySingle("select count(*) from `blocks` where `activ` = '0'");
    $new_alert = $c_new_alert > 0 ? ($c_new_alert < 10 ? '<i class="hi-count">'.$c_new_alert.'</i>' : '<i class="hi-count">+</i>') : '';
	
// Сообщения
    $c_new_mail = DB::$dbs->querySingle('select count(*) from `privat` where `ho` = '.$user['id'].' and `read` = "0"');
    //$c_new_mail = DB::$dbs->querySingle("select count(*) from `privat` where `read` = '0' and `ho` = ".$user['id']."");
    //$new_mail = $c_new_mail > 0 ? '<i class="hi-count">'.($c_new_mail < 100 ? $c_new_mail : '99+').'</i>' : '';
    $new_mail = $c_new_mail > 0 ? ($c_new_mail < 10 ? '<i class="hi-count">'.$c_new_mail.'</i>' : '<i class="hi-count">+</i>') : '';
	
// Активация акка
	$regok = DB::$dbs->queryFetch("SELECT * FROM `reg` WHERE `who` = ".$user['id']." LIMIT 1");
	
// Кол-во цепочек писем
    $stmt_mess = DB::$dbs->prepare("select count(*) from `privat_contact` where `who` = ? or `ho` = ?");
    $stmt_mess->execute(':uid', $user['id']);
    $count_mess = $stmt_mess->fetchColumn();


    $ignor = DB::$dbs->querySingle("SELECT count(id) from `privat_contact` where `who` = '".$user['id']."' and `ignor` = '1'");
}

$news = DB::$dbs->querySingle('select count(`id`) from `news`');
$newspaper = DB::$dbs->querySingle('select count(`id`) from `newspaper`');
$forum_tem = DB::$dbs->querySingle('select count(`id`) from `forum_t` where `type` = "0"');
$forum_post = DB::$dbs->querySingle('select count(`id`) from `forum_m` where `del2` = "0"');
$forumz = $forum_tem + $forum_post;
$users = DB::$dbs->querySingle('select count(`id`) from `users`');
$admins = DB::$dbs->querySingle('select count(`id`) from `users` where `lvl` > "0"');
$birthday = DB::$dbs->querySingle('select count(`id`) from `users` where `birthday` LIKE "%'.date('d.m').'%"');
$online = DB::$dbs->querySingle('select count(*) from `users` where `onl` > '.(time() - 3600).'');
$pos = DB::$dbs->querySingle('select count(*) from `users` where `onl` > '.(time() - 86400).'');
$zc = DB::$dbs->querySingle('select count(`id`) from `zc_file`');
$zc_vip = DB::$dbs->querySingle('select count(`id`) from `zc_vip_file`');
$lenta = DB::$dbs->querySingle('select count(`id`) from `lenta`');

// Админка
$del_themes = DB::$dbs->querySingle("SELECT count(id) FROM `forum_t` where `type` = '1'");
$obja = DB::$dbs->querySingle("SELECT count(id) from `obja`");
$nar = DB::$dbs->querySingle("SELECT count(id) from `nar`");
$ticket = DB::$dbs->querySingle("SELECT count(id) from `ticket`");
$ticket_new = DB::$dbs->querySingle("SELECT count(id) from `ticket` where `activ` = ?",array(0));
$ban = DB::$dbs->querySingle('select count(`id`) from `ban` where `end` > "'.time().'"');
$banf = DB::$dbs->querySingle('select count(`id`) from `ban_forum` where `end` > "'.time().'"');
$azc = DB::$dbs->querySingle("SELECT count(id) from `zc_file` where `mod` = ?",array(0));
$reg = DB::$dbs->querySingle("SELECT count(id) from `reg` where `ok` = ?",array(0));
$arb = DB::$dbs->querySingle("SELECT count(id) from `arbitr` where `mode` = '0'");
$anews = DB::$dbs->querySingle("SELECT count(id) from `news`");
$rek = DB::$dbs->querySingle("SELECT count(id) FROM `ads` WHERE `mode` = '0'");
$wmid = DB::$dbs->querySingle("SELECT COUNT(*) FROM `wmr`");
$jal = DB::$dbs->querySingle("SELECT count(id) from `jal` where `arhiv` = 0");
$jal2 = DB::$dbs->querySingle("SELECT count(id) from `jal` where `arhiv` = 1");
$sam = DB::$dbs->querySingle("SELECT count(id) from `block`");

// Кабинет
$black = DB::$dbs->querySingle("SELECT count(id) from `opt` where `chto` = 'mash'");
$garant = DB::$dbs->querySingle("SELECT COUNT(*) FROM `users` where `cedf` = '1'");

/* Чистка БД */

// Удаление старых сообщений чата
/*Comments::DelOldMess(0, 0, time() - 3600 * 24 * 25);
// Очистка лога о пополнених
$stmt = $connect->prepare("delete from `plus` where `status` = '0' and `time` < :date");
$stmt->bindValue(':date', time() - 3600 * 24, PDO::PARAM_INT);
$stmt->execute();
// Очистка уведомлений
$stmt = $connect->prepare("delete from `notifications` where `new` = '0' and `time` < :date");
$stmt->bindValue(':date', time() - 3600 * 24 * 25, PDO::PARAM_INT);
$stmt->execute();
// Очистка authlog
$stmt = $connect->prepare("delete from `authlog` where `status` = '0' and `time` < :date");
$stmt->bindValue(':date', time() - 3600 * 24 * 75, PDO::PARAM_INT);
$stmt->execute();
// Очистка Speedpass
$stmt = $connect->prepare("delete from `speedpass` where `time` < :date");
$stmt->bindValue(':date', time() - 3600 * $sys['system']['hsp'], PDO::PARAM_INT);
$stmt->execute();
// Очистка лога о бонусах 
$bonus_clear = $connect->prepare("delete from `bonus_rec` where `time` < :time");
$sql = $connect->query("select * from `bonus` order by `id` desc")->fetchAll();
foreach ($sql as $row) {

    // Однодневные не чистим
    if ($row['date'])
                continue;

    // Чистка логов о сборах
    $bonus_clear->bindValue(':time', getTimeByTimezone($sys['system']['timezone'], 0, 0, 0), PDO::PARAM_INT);
    $bonus_clear->execute();

}

/* Счетчики модулей */

// Speedpass
/*$count_sp = $connect->query("select count(*) from `speedpass`")->fetchColumn(); 

// Количество званий юзеров
$count_rank = $connect->query("select count(*) from `rank`")->fetchColumn();

// Количество бонусов
$count_bonus = $connect->query("select count(*) from `bonus`")->fetchColumn();

// Логи пополнений
$count_paylog = $connect->query("select count(*) from `plus`")->fetchColumn();
// Кол-во заявок на вывод
$stmt_payment_c = $connect->prepare("select count(*) from `payment` where `status` = ?");
$stmt_payment_c->execute(array(0));
$count_payment = $stmt_payment_c->fetchColumn();
$new_payment = $count_payment > 0 ? '<font color="#d8544f">+'.$count_payment.'</font>' : '';
$stmt_payment_c->execute(array(1));
$yes_payment = $stmt_payment_c->fetchColumn();
$stmt_payment_c->execute(array(2));
$no_payment = $stmt_payment_c->fetchColumn();
$all_payment = $count_payment + $yes_payment + $no_payment;
// Всего выплачено
$sum_payment = $connect->query("select sum(`money`) from `payment` where `status` = '1'")->fetchColumn() ?? 0;
// Рейтинг по выплатам
$rate_payment = $connect->query("select count(distinct `uid`) from `payment` where `status` = '1'")->fetchColumn();

// Кол-во новостей
$count_news = $connect->query("select count(*) from `news`")->fetchColumn();
// Последние новости
$stmt_newss = $connect->prepare("select count(*) from `news` where `time` > :time");
$stmt_newss->bindValue(':time', mktime(0, 0, 0), PDO::PARAM_INT);
$stmt_newss->execute();
$c_newss = $stmt_newss->fetchColumn();
$newss = $c_newss > 0 ? '+'.$c_newss : '';

// Кол-во пользователей
$count_users = $connect->query("select count(*) from `users`")->fetchColumn();
// Кол-во зарегистрированных пользователей сегодня
$stmt_users_new = $connect->prepare("select count(*) from `users` where `datereg` > :datereg");
$stmt_users_new->bindValue(':datereg', mktime(0, 0, 0), PDO::PARAM_INT);
$stmt_users_new->execute();
$count_users_new = $stmt_users_new->fetchColumn();
// Команда сайта
$count_team_user = $connect->query("select count(*) from `users` where `admin` != '0'")->fetchColumn();
// Кол-во заблокированных пользователей
$stmt_ban_user = $connect->prepare("select count(*) from `users` where `ban` > :time");
$stmt_ban_user->bindValue(':time', time(), PDO::PARAM_INT);
$stmt_ban_user->execute();
$count_ban_user = $stmt_ban_user->fetchColumn();
// Деньги у юзеров
$money_users = $connect->query("select sum(`money`) from `users` where `admin` != '1'")->fetchColumn() ?? 0;

// Кол-во пользователей онлайн
$stmt_online = $connect->prepare("select count(distinct `uid`) from `authlog` where `status` = '1' and `lasttime` > :time");
$stmt_online->bindValue(':time', time() - 300, PDO::PARAM_INT);
$stmt_online->execute();
$count_online_user = $stmt_online->fetchColumn();
// Заходило сегодня
$stmt_day = $connect->prepare("select count(distinct `uid`) from `authlog` where `lasttime` > :time");
$stmt_day->bindValue(':time', mktime(0, 0, 0), PDO::PARAM_INT);
$stmt_day->execute();
$count_day_user = $stmt_day->fetchColumn();

if ($sys['modules']['ads'] == 1) {

    // Реклама
    $rek = $connect->query("select count(*) from `rek`")->fetchColumn();
    // Активная реклама
    $stmt_rek = $connect->prepare("select count(*) from `rek` where `status` = '1' and `expire` > :time");
    $stmt_rek->bindValue(':time', time(), PDO::PARAM_INT);
    $stmt_rek->execute();
    $active_rek = $stmt_rek->fetchColumn();
    // на модерации
    $c_mod_rek = $connect->query("select count(*) from `rek` where `status` = '3'")->fetchColumn();
    $new_mod_rek = $c_mod_rek > 0 ? '<font color="#d8544f">+'.$c_mod_rek.'</font>' : '';

    if (isset($active)) {

        // последняя ссылка
        $stmt_lr = $connect->prepare("select * from `rek` where `status` = '1' and `expire` > :time order by `expire` asc");
        $stmt_lr->bindValue(':time', time(), PDO::PARAM_INT);
        $stmt_lr->execute();
        $last_rek = $stmt_lr->fetch();
        // реклама юзера
        $stmt_user_rek = $connect->prepare("select count(*) from `rek` where `uid` = ?");
        $stmt_user_rek->execute(array($user['id']));
        $user_rek = $stmt_user_rek->fetchColumn();

    }

}

if ($sys['modules']['shop'] == 1) {

    // prepared
    $stmt_bk = $connect->prepare("select count(*) from `basket` where `pid` = ? and `uid` = ?");
    $del_basket = $connect->prepare("delete from `basket` where `pid` = ? and `uid` = ?");
    $in_basket = $connect->prepare("insert into `basket` set `pid` = ?, `uid` = ?");
    $purchase = $connect->prepare("update `purchase` set `status` = '1' where `id` = ?");

    // Лидеры продаж
    $count_sellers = $connect->query("select count(distinct `seller`) from `purchase`")->fetchColumn();
    // Хиты продаж
    $count_shop_hits = $connect->query("select count(distinct `pid`) from `purchase`")->fetchColumn();
    // Продаж за сегодня
    $stmt_day_sell = $connect->prepare("select count(*) from `purchase` where `time` > :date");
    $stmt_day_sell->bindValue(':date', mktime(0, 0, 0), PDO::PARAM_INT);
    $stmt_day_sell->execute();
    $day_sell = $stmt_day_sell->fetchColumn();
    // на сумму
    $stmt_sum_day_sell = $connect->prepare("select sum(`sum`) from `purchase` where `time` > :date");
    $stmt_sum_day_sell->bindValue(':date', mktime(0, 0, 0), PDO::PARAM_INT);
    $stmt_sum_day_sell->execute();
    $sum_day_sell = $stmt_sum_day_sell->fetchColumn() ?? 0;
    // Продаж за все время
    $all_sell = $connect->query("select count(*) from `purchase`")->fetchColumn();
    // на сумму
    $sum_all_sell = $connect->query("select sum(`sum`) from `purchase`")->fetchColumn() ?? 0;
    // кол-во категорий
    $count_shop_kat = $connect->query("select count(*) from `kat` where `type` = '1'")->fetchColumn();
    // Кол-во товаров в магазине
    $count_shop = $connect->query("select count(*) from `shop` where `status` = '1'")->fetchColumn();
    // Бесплатное
    $stmt_shop_free = $connect->prepare("select count(*) from `shop` where `status` = '1' and `free` = '1' and `time` <= ?");
    $stmt_shop_free->execute(array(time()));
    $count_shop_free = $stmt_shop_free->fetchColumn();
    // Кол-во товаров на модерации
    $c_mod_shop = $connect->query("select count(*) from `shop` where `status` = '3'")->fetchColumn();
    $new_mod_shop = $c_mod_shop > 0 ? '<font color="#d8544f">+'.$c_mod_shop.'</font>' : '';
    // все товары
    $all_shop = $count_shop + $c_mod_shop;
    // Новые товары
    $stmt_new_shop = $connect->prepare("select count(*) from `shop` where `status` = '1' and `time` > :time and `time` <= :release");
    $stmt_new_shop->bindValue(':time', mktime(0, 0, 0), PDO::PARAM_INT);
    $stmt_new_shop->bindValue(':release', time(), PDO::PARAM_INT);
    $stmt_new_shop->execute();
    $c_new_shop = $stmt_new_shop->fetchColumn();
    $new_shop = $c_new_shop > 0 ? '+'.$c_new_shop : '';
    // Скоро в магазине
    $stmt_release = $connect->prepare("select count(*) from `shop` where `status` = '1' and `time` > :release");
    $stmt_release->bindValue(':release', time(), PDO::PARAM_INT);
    $stmt_release->execute();
    $count_release = $stmt_release->fetchColumn();
    // Последние обновления
    $last_update_shop = $connect->query("select count(*) from `shop` where `status` = '1' and `upd` != '0'")->fetchColumn(); 

    if (isset($active)) {

        // Кол-во товаров юзера
        $stmt_user_shop->execute(array($user['id']));
        $count_user_shop = $stmt_user_shop->fetchColumn();
        // покупки юзера
        $stmt_user_purch = $connect->prepare("select count(*) from `purchase` where `uid` = ?");
        $stmt_user_purch->execute(array($user['id']));
        $user_purch = $stmt_user_purch->fetchColumn();
        // на сумму
        $stmt_sup = $connect->prepare("select sum(`sum`) from `purchase` where `uid` = ?");
        $stmt_sup->execute(array($user['id']));
        $sum_user_purch = $stmt_sup->fetchColumn() ?? 0;
        // продажи юзера
        $stmt_user_kassa = $connect->prepare("select count(*) from `purchase` where `seller` = ?");
        $stmt_user_kassa->execute(array($user['id']));
        $user_kassa = $stmt_user_kassa->fetchColumn();
        // на сумму
        $stmt_suk = $connect->prepare("select sum(`sum`) from `purchase` where `seller` = ?");
        $stmt_suk->execute(array($user['id']));
        $sum_user_kassa = $stmt_suk->fetchColumn() ?? 0;
        // корзина
        $stmt_user_bk = $connect->prepare("select count(*) from `basket` where `uid` = ?");
        $stmt_user_bk->execute(array($user['id']));
        $user_bk = $stmt_user_bk->fetchColumn();

        /* Обработка платежей магазина */

        /*$shop_time = time() - 3600 * 24 * $sys['system']['sdays'];

        $data = $connect->prepare("select * from `purchase` where `status` = '0' and `time` < :time order by `id` limit 15");
        $data->bindValue(':time', $shop_time, PDO::PARAM_INT);
        $data->execute();
        $sql = $data->fetchAll();

        foreach ($sql as $row) {

            // Рейтинг
            ratingUser($sys['rating']['shop'], $row['seller']);
            // Выплата
            pay($row['sum'], $row['seller']);
            // Статус платежа
            $purchase->execute(array($row['id']));

        }

    }

}

if ($sys['modules']['serf'] == 1) {

    // prepared
    $stmt_click = $connect->prepare("select count(*) from `click` where `uid` = ? and `link` = ?");
    $stmt_fb = $connect->prepare("select count(*) from `forbid_browser` where `link` = ?");
    $stmt_cl = $connect->prepare("select count(*) from `click` where `link` = ?");

    // Очистка лога о переходах
    $stmt = $connect->prepare("delete from `click` where `time` < :time");
    $stmt->bindValue(':time', getTimeByTimezone($sys['system']['timezone'], 0, 0, 0), PDO::PARAM_INT);
    $stmt->execute();

    // Активные юзеры серфинга
    $active_users = $connect->query("select count(distinct `uid`) from `click`")->fetchColumn();
    // Общее кол-во площадок
    $all_links = $connect->query("select count(*) from `link`")->fetchColumn();
    $active_links = $connect->query("select count(*) from `link` where `click` > '0' and `status` = '1'")->fetchColumn();
    // На модерации
    $c_mod_link = $connect->query("select count(*) from `link` where `status` = '3'")->fetchColumn();
    $new_mod_link = $c_mod_link > 0 ? '<font color="#d8544f">+'.$c_mod_link.'</font>' : '';
    // Кол-во платных переходов
    $clicks = $connect->query("select count(*) from `click`")->fetchColumn();

    if (isset($active)) {

        // Кол-во площадок
        $stmt_link = $connect->prepare("select count(*) from `link` where `uid` = ?");
        $stmt_link->execute(array($user['id']));
        $links = $stmt_link->fetchColumn();

        /* Кол-во ссылок серфинга */

        /*$count_serf = 0;

        $data = $connect->prepare("select * from `link` where `click` > '0' and `uid` != :uid and `status` = '1'");
        $data->bindValue(':uid', $user['id'], PDO::PARAM_INT);
        $data->execute();
        $sql = $data->fetchAll();

        foreach ($sql as $row) {

            $stmt_click->execute(array($user['id'], $row['id']));

            if (!$stmt_click->fetchColumn() && !is_forbid_browser($row['id'])) {

                $count_serf++;

            }

        }

    }

}

if ($sys['modules']['task'] == 1) {

    // выполнено заданий
    $stmt_success_tasks = $connect->prepare("select count(*) from `task_ans` where `time` > :time");
    $stmt_success_tasks->bindValue(':time', mktime(0, 0, 0), PDO::PARAM_INT);
    $stmt_success_tasks->execute();
    $success_tasks = $stmt_success_tasks->fetchColumn();
    // активных пользователей в заданиях
    $stmt_at = $connect->prepare("select count(distinct `uid`) from `task_ans` where `time` > :time");
    $stmt_at->bindValue(':time', mktime(0, 0, 0), PDO::PARAM_INT);
    $stmt_at->execute();
    $active_task_users = $stmt_at->fetchColumn();
    // На модерации
    $c_mod_task = $connect->query("select count(*) from `task` where `status` = '3'")->fetchColumn();
    $new_mod_task = $c_mod_task > 0 ? '<font color="#d8544f">+'.$c_mod_task.'</font>' : '';
    // все задания
    $all_tasks = $connect->query("select count(*) from `task`")->fetchColumn();
    // активные задания
    $active_tasks = $connect->query("select count(*) from `task` where `status` = '1' and `col` > '0'")->fetchColumn();

    /* Отключаем задания давно не заходивших юзеров */

    /*$task_off = $connect->prepare("update `task` set `status` = '0' where `status` = '1' and `uid` = ?");

    $taskers = $connect->query("select * from `task` where `status` = '1' group by `uid` order by `uid` desc")->fetchAll();

    foreach ($taskers as $row) {

        $auth_t = authlog($row['uid']);

        if (!$auth_t || $auth_t['lasttime'] < time() - 3600 * 24 * $sys['system']['tlast']) {

            $task_off->execute(array($row['uid']));

        }

    }

    if (isset($active)) {

        // Кол-во заданий
        $stmt_tasks = $connect->prepare("select count(*) from `task` where `status` = '1' and `col` > '0' and `uid` != ?");
        $stmt_tasks->execute(array($user['id']));
        $count_tasks = $stmt_tasks->fetchColumn();
        // Кол-во заданий юзера
        $stmt_user_tasks = $connect->prepare("select count(*) from `task` where `uid` = ?");
        $stmt_user_tasks->execute(array($user['id']));
        $count_user_tasks = $stmt_user_tasks->fetchColumn();
        // статистика выполнений
        $stmt_user_task = $connect->prepare("select count(*) from `task_ans` where `uid` = ?");
        $stmt_user_task->execute(array($user['id']));
        $user_task_stat = $stmt_user_task->fetchColumn();

    }

}


if (isset($active)) {

    // авторизации юзера
    $stmt_auth->execute(array($user['id']));
    $count_auth = $stmt_auth->fetchColumn();

    // черный список
    $stmt_black->execute(array($user['id']));
    $count_black = $stmt_black->fetchColumn();

    // уведомления
    $stmt_not = $connect->prepare("select count(*) from `notifications` where `uid` = ?");
    $stmt_not->execute(array($user['id']));
    $not = $stmt_not->fetchColumn();
    // Новые уведомления
    $stmt_new_not = $connect->prepare("select count(*) from `notifications` where `new` = '1' and `uid` = ?");
    $stmt_new_not->execute(array($user['id']));
    $c_new_not = $stmt_new_not->fetchColumn();
    $new_not = $c_new_not > 0 ? ($c_new_not < 100 ? '+'.$c_new_not : '99+') : '';

    // друзья юзера
    $stmt_friends->bindValue(':user', $user['id'], PDO::PARAM_INT);
    $stmt_friends->execute();
    $count_friends = $stmt_friends->fetchColumn();
    // заявки в друзья
    $stmt_req = $connect->prepare("select count(*) from `friend` where `status` = '0' and `to` = ?");
    $stmt_req->execute(array($user['id']));
    $count_req = $stmt_req->fetchColumn();
    $new_req = $count_req > 0 ? ($count_req < 100 ? '+'.$count_req : '99+') : '';

    // Сообщения
    $count_mail = $connect->prepare("select count(*) from `mail` where `from` = :uid or `to` = :uid");
    $count_mail->bindValue(':uid', $user['id'], PDO::PARAM_INT);
    $count_mail->execute();
    $count_mail = $count_mail->fetchColumn();
    $c_new_mail = $connect->prepare("select count(*) from `mail` where `read` = '0' and `to` = ?");
    $c_new_mail->execute(array($user['id']));
    $c_new_mail = $c_new_mail->fetchColumn();
    $new_mail = $c_new_mail > 0 ? ($c_new_mail < 100 ? '+'.$c_new_mail : '99+') : '';

    // Кол-во рефералов
    $stmt_ref->execute(array($user['id']));
    $count_ref = $stmt_ref->fetchColumn();
    // Рейтинг по рефералам
    $ref_top = $connect->query("select count(distinct `ref`) from `users` where `ref` != '0'")->fetchColumn();

    // Кол-во сообщений чата
    $count_chat = Comments::CountMess(0, 0);
    // Новые сообщения чата
    $chatlog = $user['chatlog'] > mktime(0, 0, 0) ? $user['chatlog'] : mktime(0, 0, 0);
    $c_new_chat = Comments::NewMess(0, 0, $chatlog, $user['id']);
    $new_chat = $c_new_chat > 0 ? ($c_new_chat < 100 ? '+'.$c_new_chat : '99+') : '';

    // Выплачено юзеру
    $stmt_user_payment->execute(array($user['id']));
    $user_payment = $stmt_user_payment->fetchColumn() ?? 0;
    // заявок
    $stmt_count_up->execute(array($user['id']));
    $c_user_payment = $stmt_count_up->fetchColumn();

    // Пополнено юзером
    $stmt_user_plus->execute(array(0, $user['id']));
    $user_plus = $stmt_user_plus->fetchColumn() ?? 0;
    // заявок
    $stmt_count_upl->execute(array(0, $user['id']));
    $c_user_plus = $stmt_count_upl->fetchColumn();

    // донаты
    $stmt_hud->execute(array(':user' => $user['id']));
    $history_user_donats = $stmt_hud->fetchColumn();
    // ему задонатили
    $stmt_user_plus->execute(array(1, $user['id']));
    $sum_user_donats = $stmt_user_plus->fetchColumn() ?? 0;
    // он задонатил
    $stmt_user_donats->execute(array($user['id']));
    $sum_user_donater = $stmt_user_donats->fetchColumn() ?? 0;

    if ($sys['modules']['forum'] == 1) {

        // Закрепленные темы
        $stmt_pt = $connect->prepare("select count(*) from `topic` where `top` > ?");
        $stmt_pt->execute(array(time()));
        $count_pt = $stmt_pt->fetchColumn();
        // последняя
        $stptrow = $connect->prepare("select * from `topic` where `top` > ? order by `top` asc");
        $stptrow->execute(array(time()));
        $ptrow = $stptrow->fetch();
        // Форум
        $count_forum = $connect->query("select count(*) from `topic`")->fetchColumn();
        // кол-во категорий
        $count_forum_kat = $connect->query("select count(*) from `kat` where `type` = '2'")->fetchColumn();
        // темы юзера
        $stmt_user_f = $connect->prepare("select count(*) from `topic` where `uid` = ?");
        $stmt_user_f->execute(array($user['id']));
        $user_forum = $stmt_user_f->fetchColumn();
        // Кол-во постов
        $count_fp = Comments::AllMess(3);
        // Новые посты
        $c_new_fp = Comments::AllNewMess(3);
        $new_fp = $c_new_fp > 0 ? '+'.$c_new_fp : '';

    }

    /* Игры */

    /*if ($sys['modules']['game_num'] == 1) {

        // Кол-во ставок в num
        $count_num = $connect->query("select count(*) from `num`")->fetchColumn();

    }

    if ($sys['modules']['game_loto'] == 1) {

        // Кол-во играющих в лотерею
        $loto_count = $connect->query("select count(*) from `loto`")->fetchColumn();
        // Кол-во победителей в лотерее
        $count_win_loto = $connect->query("select count(*) from `win_loto`")->fetchColumn();
        // Выигрыш
        $loto_cash = $sys['system']['loto'] * $sys['system']['loto_cena'];

        /* Определение победителя */
        /*if ($loto_count >= $sys['system']['loto']) {

            $loto = $connect->query("select * from `loto` order by rand()")->fetch();

            $log = $connect->prepare("insert into `win_loto` set `time` = ?, `uid` = ?, `sum` = ?");

            if (pay($loto_cash, $loto['uid']) && $log->execute(array(time(), $loto['uid'], $loto_cash))) {

                notification('Вы победили в лотерее! Выигрыш - '.quantDec($loto_cash, ['рубль', 'рубля', 'рублей']), $loto['uid']);

                $connect->exec("delete from `loto`");

            }

        }

    }

    if ($sys['modules']['game_prmd'] == 1) {

        // Кол-во ставок в пирамиде
        $count_prmd = $connect->query("select count(*) from `prmd`")->fetchColumn();
        // выигрыш
        $prmd_cash = $connect->query("select sum(`sum`) from `prmd`")->fetchColumn() ?? 0;
        // Кол-во победителей в пирамиде
        $count_win_prmd = $connect->query("select count(*) from `win_prmd`")->fetchColumn();
        // Последняя ставка
        $row_prmd = $connect->query("select * from `prmd` order by `id` desc")->fetch();
        // Последний победитель
        $last_prmd = $connect->query("select * from `win_prmd` order by `id` desc")->fetch();

        // Определение победителя
        if ($row_prmd && $row_prmd['time'] < time() - 3600 * $sys['system']['ptime']) {

            $log = $connect->prepare("insert into `win_prmd` set `time` = ?, `uid` = ?, `sum` = ?");

            if (pay($prmd_cash, $row_prmd['uid'])) {

                if ($count_prmd > 1) {

                    $log->execute(array(time(), $row_prmd['uid'], $prmd_cash));

                    $notification = 'Вы победили в пирамиде! Выигрыш - '.quantDec($prmd_cash, ['рубль', 'рубля', 'рублей']);

                } else {

                    $notification = 'Средства с вашей ставки в пирамиде ('.quantDec($prmd_cash, ['рубль', 'рубля', 'рублей']).') были возвращены на баланс, потому что никто не продолжил игру.';

                }

                notification($notification, $row_prmd['uid']);

                $connect->exec("delete from `prmd`");

            }

        }

    }

    /* Счетчик для админа */

    /*$counters_adm = ($adm_id == 1 ? $count_payment : 0) + ($c_mod_shop ?? 0) + ($c_mod_link ?? 0) + ($c_mod_task ?? 0) + ($c_mod_rek ?? 0);

    $new_adm = $counters_adm > 0 ? ($counters_adm < 100 ? '<font color="#d8544f">+'.$counters_adm.'</font>' : '<font color="#d8544f">99+</font>') : '';*/

//}