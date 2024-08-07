<?
$f_host = 'db547984887.db.1and1.com';
$f_user = 'dbo547984887';
$f_pass = 'aH!W1mVq_Cm';
$f_bd = 'db547984887';

$link=@mysql_connect($f_host,$f_user,$f_pass);

if (!$link) { // Traitement de l'erreur
    echo '<br> Probleme de connexion à la base - 1';
	exit;
}
else {
	$select_db=@mysql_select_db($f_bd, $link);

	if (!$select_db) { // Traitement de l'erreur
		echo '<br> Probleme de connexion à la base - 2';
		exit;
	}
}

?>