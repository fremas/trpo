<?

if (!class_exists('PDO'))
die('Fatal Error: Для работы нужна поддержка PDO.');

// --------------------------- Класс для работы с базами данных -------------------------------//
class PDO_ extends PDO {

function __construct($dsn, $Ylogin, $Ypassword) {
parent::__construct($dsn, $Ylogin, $Ypassword);
$this -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$this -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$this -> setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
}
function prepare($sql, $params = array()) {
$stmt = parent::prepare($sql, array(
PDO::ATTR_STATEMENT_CLASS => array('PDOStatement_')
));
return $stmt;
}

function query($sql, $params = array()) {
$stmt = $this -> prepare($sql);
$stmt -> execute($params);
return $stmt;
}

function querySingle($sql, $params = array()) {
$stmt = $this -> query($sql, $params);
return $stmt -> fetchColumn(0);
}

function queryFetch($sql, $params = array()) {
$stmt = $this -> query($sql, $params);
return $stmt -> fetch();
}

function queryCounter() {
return self::$counter;
}
}

// ----------------------------------------------------//
class PDOStatement_ extends PDOStatement {
function execute($params = array()) {
if (func_num_args() == 1) {
$params = func_get_arg(0);
} else {
$params = func_get_args();
}
if (!is_array($params)) {
$params = array($params);
}
parent::execute($params);
return $this;
}

function fetchSingle() {
return $this -> fetchColumn(0);
}

function fetchAssoc() {
$this -> setFetchMode(PDO::FETCH_NUM);
$data = array();
while ($row = $this -> fetch()) {
$data[$row[0]] = $row[1];
}
return $data;
}
}
class DB {
static $dbs;
public function __construct() {
try {
self :: $dbs = new PDO_('mysql:host=' . DBHOST . ';port=' . DBPORT . ';dbname=' . DBNAME, DBUSER, DBPASS);
self :: $dbs -> exec('SET CHARACTER SET utf8');
self :: $dbs -> exec('SET NAMES utf8');
}
catch (PDOException $e) {
die('Ошибка подключения к БД: ' . $e -> getMessage());
}
}
}
$db = new DB();

?>