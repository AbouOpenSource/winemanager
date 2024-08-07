<?
session_start();

include('inc/variables_site.php');

// Entree dans le site;
if (isset($_POST['connecter']) && (!empty($_POST['login'])) && (!empty($_POST['passwd'])) ) {
	f_test_connexion($_POST['login'],$_POST['passwd']);
	
	if ($_SESSION['sessionOK'] == 'sessionOK') {
		f_demarrage ($_SESSION['login']);
	}
}

if(isset($_GET['menu_'])) { $menu_=$_GET['menu_']; } else { $menu_='depart'; }
if(isset($_GET['tiers_'])) { $tiers_=$_GET['tiers_']; } else { $tiers_='n_a'; }
if(isset($_GET['action_'])) { $action_=$_GET['action_']; } else { $action_='n_a'; }
if(isset($_GET['stats_'])) { $stats_=$_GET['stats_']; } else { $stats_='n_a'; }
if(isset($_GET['info_'])) { $info_=$_GET['info_']; } else { $info_='n_a'; }
if(isset($_GET['calendrier_'])) { $calendrier_=$_GET['calendrier_']; } else { $calendrier_=''; }
if(isset($_GET['pdf_'])) { $pdf_=$_GET['pdf_']; } else { $pdf_=''; }

// GESTION DE LA DECONNEXION
if ($menu_ == 'disconnect' ) {
session_destroy();
unset($_SESSION);
unset($_COOKIE);
}

$page_php = 'wm_accueil.php';
insert_tb_log($page_php);
$test_maintenance = f_test_maintenance ();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?
echo '<head>';
echo '<meta name=author content=' . $author . '>';
echo '<title>Wine Manager</title>';
echo '<link rel=stylesheet href=wm_style_site.css>';
echo '</head>';
echo '<body>';


// ENTREE DANS LE SITE
if ($_SESSION['sessionOK'] == 'sessionOK' and $test_maintenance == 0) {

f_epurer_client($login);

echo '<table width=100% align=center border=0> ';

// PARTIE LOGO WINE MANAGER EN HAUT A GAUCHE
//echo '<tr bgcolor=#FFF6FD>';
echo '<tr>';
echo '<td align=center width=20%>';
f_affiche_logo();
echo '</td>';

// PARTIE MENU HAUT
echo '<td width=80% align=right valign=top>'; 
echo '<table width=100% border=0 >';
echo '<tr ><td valign=top align=right>';

f_affiche_connexion($_SESSION['civilite'],$_SESSION['prenom'],$_SESSION['nom'],$login,$_SESSION['last_connect_date']);

echo '</td></tr>';
echo '<tr><td valign=top>';
include('inc/wm_menu_haut.php'); 
echo '</td></tr>';
echo '</table>';
echo '</td>';
echo '</tr>';

// PARTIE AFFICHAGE PAGE
echo '<tr>';

if ($menu_ == 'debut') {
	echo '<td colspan=2 valign=top align=right>';
	echo '<br> <br> '; include('inc/wm_logo_01.php');
	echo '</td>';
}

// PARTIE AFFICHAGE PAGE
else if ($tiers_ == 'client') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_client.php'); 
	echo '</td>';
}

else if ( $tiers_ ==  'fournisseurs') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_fournisseur.php'); 
	echo '</td>';
}

else if ($action_ == 'commande') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_commande.php'); 
	echo '</td>';
}

else if ($action_ == 'devis') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_devis.php'); 
	echo '</td>';
}
else if ($stats_ ==  'stats') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_stats.php'); 
	echo '</td>';
}
else if ($calendrier_ == 'calendrier') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_calendrier.php');
	echo '</td>';
}
else if ($pdf_ == 'pdf') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_compte_display_file.php'); 
	echo '</td>';
}
else if ($info_ == 'compte' or $info_ ==  'contact') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_compte.php');
	echo '</td>';
}
else if ($menu_ == 'compte_liste' and $_SESSION['flag_admin']=='O') {
	echo '<td colspan=2 valign=top>';
	include('inc/wm_compte_liste.php');
	echo '</td>';
}


else {
	echo '<td colspan=2 valign=top>';
	echo ' LOGO '; 
	echo '</td>';
}

echo '</tr>';
echo '</table>';

}


else if ($_SESSION['sessionOK'] == 'sessionOK' and $test_maintenance == 1) {
	echo '<table width=25% cellpadding=3 align=center border=0>';
	echo '<tr><td colspan=2 align=center class=style18> <hr> ';
	echo "<span onClick=document.location='http://tocut.bi.free.fr'; style=cursor:pointer> $copyr </span>";
	echo '</td></tr>';
	echo '</table>';
	
	echo '<table width=50% cellpadding=0 align=center border=0>';
	echo '<tr>';
	echo '<td valign=center align=center class=style7>';
	echo '<br><br> Le site est en maintenance. Merci de vous reconnecter ult&eacute;rieurement <br><br><br>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	
	echo '<table width=25% cellpadding=3 align=center border=0>';
	echo '<tr><td colspan=2 align=center class=style18> <hr> ';
	echo "<span onClick=document.location='http://tocut.bi.free.fr'; style=cursor:pointer> $copyr </span>";
	echo '</td></tr>';
	echo '</table>';
}

// CHANGEMENT DU MOT DE PASSE
else if($_POST['mdp_oublie']) { 
	
	if (empty($_POST['login'])) { 
		$msg_ = 'Veuillez renseigner votre compte ou adresse mail.'; 
	}
	else { 
		$login_form = $_POST['login']; 
		$msg_=f_mot_de_passe_oublie($login_form);
	}
	
	include('inc/wm_form_index.php'); 
}

// CONNEXION A ECHOUE
else {
	include('inc/wm_form_index.php'); 
}

echo '</body>';
echo '</html>';

?>
