<?

function DB($type, $table)
{
	if($type = 'add') DB::$dbs->query("INSERT INTO `op` SET $table");
}

?>