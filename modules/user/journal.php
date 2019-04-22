<?php

$system['page_title'] = 'Дневник';

require_once(HOME .'/incfiles/aut_check.php');
require_once(HOME .'/incfiles/header.php');

error($err);

DB::$dbs->query("UPDATE `journal` SET
 `read` = '1'
 WHERE `user_id` = '".$user['id']."' AND `read` = '0'");

echo '<center><b>Дневник</b></center><br/>
Тут хранятся события за последнее время.<br/><br/>
<hr>';

$max = 10;
$k_post = DB::$dbs->querySingle("SELECT COUNT(*) FROM `journal` WHERE `user_id` = '".$user['id']."'");
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$req = DB::$dbs->query("SELECT * FROM `journal` WHERE `user_id` = '".$user['id']."' ORDER BY `id` DESC LIMIT $start, $max");
foreach ($req as $jour) {
	echo ''.vtime($jour['date']).'<br><b>'.$jour['title'].'</b><br>'.$jour['message'].'<hr>';;
}

if($k_post < 1) echo 'Событий ещё не было...';
if($k_page>1) echo str(''.$HOME.'/user/journal.php?',$k_page,$page); // Вывод страниц

require_once(HOME .'/incfiles/footer.php');

?>