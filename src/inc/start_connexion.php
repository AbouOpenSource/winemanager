<?
$f_host = 'db547984887.db.1and1.com';
$f_user = 'dbo547984887';
$f_pass = 'aH!W1mVq_Cm';
$f_bd = 'db547984887';


$f_host = 'localhost';
$f_user = 'winemanager';
$f_pass = 'Password12!';
$f_bd = 'winemanager';




try{
	echo 'salut tout le mon';
	$connect_string = 'mysql:host=' . $f_host . ';dbname=' . $f_bd;
	$database = new PDO($connect_string, $f_user, $f_pass, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	echo $database;
}
catch(PDOException $exception) {
    throw new MyDatabaseException($exception->getMessage(), $exception->getCode());
}

?>