<?php
//require_once('html2pdf/html2pdf.class.php');
require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once 'data_access_class.php';

$color1 = "#B3B3B3";  // gris
$color2 = "#000000";  // noir
$color3 = "#FEFEFE";  // blanc
$color_5 = $color2;
$color6 = "#FF00CC";  // rose
$color7 = "#666666";  // gris fonce
$color8 = "#CCCCCC";  // gris clair
$color9 = "#009900";  // vert fonce

// VARIABLES DU SITE ________________________________________________________________________________________

//$_POST['flag_maintenance']			= 'OUI';
$_POST['flag_maintenance']			= 'NON';
$_POST['mail_']						= 'tocutx@yahoo.fr';
$login								= $_SESSION['login'];
$__NB_LIGNES_FORMULAIRES_COMMANDE	= $_SESSION['nb_lignes_commande'];
$author								= 'Xavier TOCUT';
$mel								= 'tocutx@yahoo.fr';
$mobile								= '06.81.94.86.02';
$site_web							= 'http://www.winemanager.fr';
$consultant_nom						= 'TOCUT';
$consultant_prenom					= 'Xavier';
$today								= date('d/m/Y');
$mel_archive						= 'contact@winemanager.fr';

$couleur_fond_entete				= '#FFF6FD';
$couleur_bordure					= '#B3B3B3';
//$_SERVER['REMOTE_ADDR']             = 'localhost';

// fonction qui se lance au demarrage de la session ----------------------------------------------------------
function f_demarrage ($login) {

	//////include('inc/start_connexion.php');
	
	// SUPPRESSION DES COMMANDES A PB
	$req_del_sql ="
	delete from wm_commande
	where		login_site	= '$login'
	and			flag_ok		= 'N'";

	
	$tab = SPDO::getInstance()->query($req_del_sql) or die('<br> Erreur sql f_demarrage - 1');

	////include('inc/end_connexion.php');
}

// fonction qui teste si le site est en maintenance si oui renvoi 1 sinon 0 ----------------------------------
function f_test_maintenance () {
	if ($_POST['flag_maintenance'] == 'OUI' and $_SESSION['login'] != 'wm_testsite') {
		return 1;
	}
	else {
		return 0;
	}	
}

// fonction qui affiche un bouton de formulaire --------------------------------------------------------------
function f_affiche_bouton_submit ($nom_, $valeur_, $pos, $url_) {
	
	if ($pos == 0) {
	$espace_ = '';
	}	
	else if ($pos == 1) {
	$espace_ = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	else {
	$espace_ = '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
	}
	
	if ($url_ == '') {
	return $espace_ . "<input type=submit value='$valeur_' name=$nom_ class=menu2 style='background:#FFF6FD; border: 1px solid #B3B3B3; cursor: pointer; width:100px' >";
	}
	else {
	return $espace_ . "<input type=button onclick=self.location.href='$url_' value='$valeur_' name=$nom_ class=menu2 style='background:#FFF6FD; border: 1px solid #B3B3B3; cursor: pointer; width:100px' >";
	}
	
}

// fonction qui affiche 1 texte pendant x sec --------------------------------------------------------------
function f_affiche_texte_n_sec ($time_ms, $text_a_afficher, $flag_ok) {

if ($flag_ok=='ok') { $aff_='text_display_n_sec_ok'; }
if ($flag_ok=='nok') { $aff_='text_display_n_sec_nok'; }

$time_sec = $time_ms/1000;
echo "<div id='message' class=$aff_> " . $text_a_afficher . " </div>";
echo "<script type='text/javascript'>";
echo "setTimeout( function(){ var oMsg = document.getElementById('message'); oMsg.style.display = 'none'; }, " . $time_ms . ");";
echo "</script>";

}

// Fonction qui verifie si le mail est ok --------------------------------------------------------------
// retourne 0 si ok 1 si pas ok
function f_verifie_mail($mail) {
	$mail2 = trim($mail); 
	$lg=strlen($mail2); 
	$pos1=strrpos($mail2, "."); 
	$pos2=strrpos($mail2, "@"); 
	//if(mb_eregi("@", $mail2) and $pos1>$pos2 and $lg>5 and $pos2>=1) 
	if(ereg("@", $mail2) and $pos1>$pos2 and $lg>5 and $pos2>=1) 
	{ 
		//if (mb_eregi(" ", $mail2))
		if (ereg(" ", $mail2))
		{ 
			// @dresse email fausse
			return(1); 
		}
		else { 
			// @dresse email correcte
			return(0); 
		} 
	}
	else { 
		// @dresse email fausse
		return(1); 
	} 
}

// Fonction d'affichage des infos de connexion -----------------------------------------------------------------------------
function f_affiche_connexion ($civilite,$prenom,$nom,$login,$date_connexion) {
//echo '<span class=style2> Bonjour ' .  . '</span>';
echo "<span class=style2 onClick=document.location='wm_accueil.php?info_=compte'; style=cursor:pointer> Bonjour $civilite $prenom $nom </span>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo  "<span class=style2 onClick=document.location='wm_accueil.php?menu_=disconnect'; style=cursor:pointer> D&eacute;connexion </span>";
echo '<br>';
echo '<span class=style18> Derni&egravere connexion ' . $login . ' : ' . $date_connexion . '</span>' ;

}

// Fonction d'affichage du logo -----------------------------------------------------------------------------
function f_affiche_sigle ($sigle,$libelle,$url_) {
echo '<a href=' . $url_ . '>';
echo '<span class=style6 onClick=document.location=' . $url_ . '; style=cursor:pointer>' . $sigle . '</span>  <span class=style18>' . $libelle . '</span>';
echo '</a>';

}

// Fonction d'affichage du logo -----------------------------------------------------------------------------
function f_affiche_logo () {
$url_='wm_accueil.php?menu_=debut';
echo "<span class=style1 onClick=document.location='$url_'; style=cursor:pointer> WINE MANAGER </span>";
echo '<span class=style0><br></span>';
$year_deb=2014;
$Actual_year=date('Y');
$url_='http://tocut.bi.free.fr';
if ( $year_deb == $Actual_year ) { echo "<span class=style18 onClick=document.location='$url_'; style=cursor:pointer> TBI &copy Copyright $year_deb </span>"; }
else { echo "<span class=style18 onClick=document.location='$url_'; style=cursor:pointer> TBI &copy Copyright $year_deb - $Actual_year </span>"; }
}

// Fonction prend en param�tre une date de type MySql yyyy-mm-dd hh:mm:ss et la retourne de la mani�re suivante dd/mm/yyyy hh:mm
function NormalDate_heure_min ($date_) {
  // yyyy-mm-dd hh:mm:ss --> dd/mm/yyyy a hh:mm
  $date_= substr($date_, 8, 2) . '/' . substr($date_, 5, 2) . '/' . substr($date_, 0, 4) . ' ' . substr($date_, 11, 5);
  return $date_;
}

// Fonction prend en param�tre une date de type MySql yyyy-mm-dd hh:mm:ss et la retourne de la mani�re suivante dd/mm/yyyy hh:mm:ss
function NormalDate_heure ($date_) {
  // yyyy-mm-dd hh:mm:ss --> dd/mm/yyyy a hh:mm:ss
  $date_= substr($date_, 8, 2) . '/' . substr($date_, 5, 2) . '/' . substr($date_, 0, 4) . ' &agrave ' . substr($date_, 11, 8);
  return $date_;
}

// Fonction prend en parametre une date de type MySql yyyy-mm-dd et la retourne de la mani�re suivante dd/mm/yyyy
function NormalDate ($date_) {
  //mb_eregi ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $date_, $regs);
  //preg_match("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $date_, $regs);
  //$date_="$regs[3]/$regs[2]/$regs[1]";
  
  $date_new_format =  date("d-m-Y", strtotime($date_));
 
  return $date_new_format;
}

// Fonction prend en param�tre une date de type dd/mm/yyyy et la retourne de la mani�re suivante yyyy-mm-dd
function mysqlDate ($date_) {
  //mb_eregi ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $date_, $regs);
  //ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $date_, $regs);
  //$date_="$regs[3]-$regs[2]-$regs[1]";

    $date_new_format = date("Y-m-d", strtotime($date_));  
  return $date_new_format;
}

// Fonction prend en param�tre une chaine et teste si c'est un entier
function f_test_int ($str_) {
  if(ctype_digit($str_)){
   // C'est un entier
   return 1;
} else{
// Ce n'est pas un entier
   return 0;
}
}

// Fonction prend en param�tre une chaine et teste si c'est un float
function f_test_float ($str_) {
  if (is_numeric($str_)) {
   // C'est un float
   return 1;
} else{
// Ce n'est pas un float
   return 0;
}
}

// Fonction permettant d'avoir / jour les differentes ip de connexion --------------------------------------------
function insert_tb_log () {
  ////include('inc/start_connexion.php');
  $request_count = "select 1 res from tb_log where date(stamp_date)=CURRENT_DATE and visitor='".$_SERVER['REMOTE_ADDR']."'";
 
  try {
  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($request_count) or die('<br> Erreur de test');
  $statement->execute(); // Récupérer les résultats 
  $tab_form = $statement->fetch(PDO::FETCH_ASSOC);
  if ($tab_form['res'] != 1) { 
	// Insertion dans tb_log si la condition est remplie 
	$ins = "INSERT INTO tb_log (stamp_date, visitor) VALUES (CURRENT_TIMESTAMP, :visitor)"; 
	$stmt_ins = $pdo_instance->prepare($ins); 
	$stmt_ins->execute(['visitor' => $_SERVER['REMOTE_ADDR']]); 
	}  
	}
	catch(PDOException $e) 
	{ die('<br> Erreur : ' . $e->getMessage()); }
  
  
  ////include('inc/end_connexion.php');
}

// Retourne l'age en fonction de la date envoyee -----------------------------------------------------------------
function age($naiss)  {
  list($annee, $mois, $jour) = split('[-.]', $naiss);
  $today['mois'] = date('n');
  $today['jour'] = date('j');
  $today['annee'] = date('Y');
  $annees = $today['annee'] - $annee;
  if ($today['mois'] <= $mois) {
    if ($mois == $today['mois']) {
      if ($jour > $today['jour'])
        $annees--;
      }
    else
      $annees--;
    }
  return $annees;
  }

// Fonction de test de connexion ---------------------------------------------------------------------------------
function f_test_connexion($login,$passwd) {

  ////include('inc/start_connexion.php');
  $login=addslashes($login);
  $passwd=addslashes($passwd);
  
  $req_connect = "
  select	login,
			civilite, 
			nom,
			prenom, 
			case when end_date >= CURRENT_DATE then 'ok' else 'nok' end flag_date,
			flag_admin,
			nb_lignes_commande,
			e_mail
  from		ref_comptes 
  where		login	= :login 
  and		mdp		= md5(:passwd)";
  
  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_connect);
  $statement->execute(['login' => $login, 'passwd'=> $passwd]);



  $tab_login = $statement->fetch(PDO::FETCH_ASSOC);

  
  $login_		= $tab_login['login'];
  $flag_date_	= $tab_login['flag_date'];
  
  // Connexion OK
  if ($login_ == $login and $flag_date_ == 'ok') {
    $req_connect = "select date_format( max( stamp_date ) , '%d/%m/%Y %H:%i' ) stamp_date from tb_connection where login = :login";
    $statement = $pdo_instance->prepare($req_connect);
	$statement->execute(['login' => $login]);

    $tab_connect = $statement->fetch(PDO::FETCH_ASSOC);
    
    $_SESSION['login']				= $tab_login['login'];
    $_SESSION['civilite']			= $tab_login['civilite'];
    $_SESSION['nom']				= $tab_login['nom'];
    $_SESSION['prenom']				= $tab_login['prenom'];
	$_SESSION['nb_lignes_commande']	= $tab_login['nb_lignes_commande'];
    $_SESSION['sessionOK']			= 'sessionOK';
    $_SESSION['last_connect_date']	= $tab_connect['stamp_date'];
	$last_connection_date			= ($_SESSION['last_connect_date']);
	$_SESSION['flag_admin']			= $tab_login['flag_admin'];
	$_SESSION['e_mail']			    = $tab_login['e_mail'];
    
    $ins = "insert into tb_connection select :login, CURRENT_TIMESTAMP, :remote_addr";
	$statement = $pdo_instance->prepare($ins);
	$tab = $statement->execute(['login' => $login, 'remote_addr' => $_SERVER['REMOTE_ADDR'] ]) or die('<br> Erreur de insert');
  }
  
  ////include('inc/end_connexion.php');
}

// fonction qui affiche un tableau en parametre ----------------------------------------------
function f_affiche_tableau ($statement, $tab_size) {
$col_count = $statement->columnCount();

$url_title = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;
$url_title_rdv = $url_title;

echo '<table width=100%>';
echo '<tr>';

for ($i = 0; $i < $col_count; $i++) {
	
	$size=$tab_size[$i];
	$nom_colonne = $statement->getColumnMeta($i)['name'];
	
	if ($nom_colonne != 'num_reporting' and $nom_colonne != 'num_client' and $nom_colonne != 'num_produit' and $nom_colonne != 'num_commande' and $nom_colonne != 'num_fournisseur' and $nom_colonne != 'num_plv' and $nom_colonne != 'num_rdv') {
		echo '<th bgcolor=#B3B3B3 class=style2 width='.$size.'%>';
		
		if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
		if ($sens_req=='ASC') { 
			$sens_req='DESC'; 
			$chaine_1='&sens_req=ASC';
			$chaine_2='&sens_req=DESC';
		} 
		else { 
			$sens_req='ASC';
			$chaine_1='&sens_req=DESC';
			$chaine_2='&sens_req=ASC';
		}
		
		if(strpos($url_title,'&sens_req=') > 0) { 
			$url_title = str_replace($chaine_1, $chaine_2, $url_title);
		}
		else {
			$url_title = $url_title . '&sens_req='.$sens_req;
		}
		
		if(strpos($url_title,'&id_col=') > 0) { 
			$url_title = substr($url_title, 0, strpos($url_title,'&id_col=')) . '&id_col='.$i; 
		}
		else {
			$url_title = $url_title . '&id_col='.$i;
		}
		
		echo "<span onClick=document.location='$url_title'; style=cursor:pointer> $nom_colonne </span"; 
		echo '</th>';
	}
}
echo '</tr>';
 
while ($ligne = $statement->fetch(PDO::FETCH_ASSOC)) {
	//print_r($ligne);	
 echo '<tr class=passage>';	
 foreach ($ligne as $nom_colonne => $value)
  {

		
		$position='left';
		
		// DEFINITION DES URLS
		if ($nom_colonne == 'num_client') {
			$url_client='wm_accueil.php?menu_=n_a&tiers_=client&id_client='.$value;
			$position='center';
		}
		
		if ($nom_colonne == 'num_commande') {
			$url_commande='wm_accueil.php?menu_=n_a&action_=commande&num_commande='.$value;
			$position='center';
		}
		
		if ($nom_colonne == 'num_fournisseur') {
			$url_fournisseur='wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client='.$value;
			$position='center';
		}
		
		if ($nom_colonne == 'num_plv') {
			$url_envoyer='wm_accueil.php?menu_=n_a&action_=commande&num_plv_='.$value;
			$position='center';
		}
		
		if ($nom_colonne == 'num_reporting') {
			$url_reporting='wm_accueil.php?menu_=n_a&stats_=stats&act_=reporting&num_reporting_='.$value;
			//echo $url_reporting;
			$position='center';
		}
		
		if ($nom_colonne == 'num_rdv') {
			if (strpos($url_title_rdv,'&num_rdv=') > 0) {
				$pos=strripos($url_title_rdv, '='); 
				$url_rdv=substr($url_title_rdv, 0,$pos+1).$value;
			}
			else if (strpos($url_title,'&calendrier_=') > 0) {
				$id_client=f_retourne_client_id_num_rdv($ligne[$nom_colonne]);
				$url_rdv='wm_accueil.php?menu_=n_a&tiers_=client&id_client='.$id_client.'&tab_rdv_tier=Y&num_rdv='.$value;
			}
			else {
				$url_rdv=$url_title_rdv.'&num_rdv='.$value;
			}
			$position='center';
		}
		
		if ($nom_colonne == 'Compte') {
			$url_compte_mod='wm_accueil.php?menu_=compte_liste&compte_mod='.$value;
		}
		
		if ($nom_colonne == 'num_produit') {
			$url_produit='wm_accueil.php?menu_=n_a&produit_=produit&id_produit='.$value;
		}
		
		$tab_valeur_center = array('Derni&egrave;re connexion', 'Date', 'N� Client', 'N� Version', 'Date de Production', 'N� Fournisseur', 'Date cr�ation', 'Date modification', 'N� PLV', 'Date commande', 'Statut', 'Date de commande', 'Date de modification', 'Ann�e', 'num_client', 'num_commande', 'num_fournisseur', 'num_plv', 'Date RDV', 'Ann�e - Mois', 'Derniere commande');
		if (in_array($nom_colonne, $tab_valeur_center, true) ) {
			$position='center';
		}
		
		$tab_valeur_right = array('Global','Nb Connexion','Nb prospects','Nb clients', 'Nb fournisseurs', 'Nb commande annul�e', 'Nb commande en cours', 'Nb commande termin�e', 'Nb devis en cours','Montant HT', 'Nb jours', 'Total HT', 'CA', 'Comm.', 'Quantit�', 'Nb Commandes', 'Moy CA', 'Moy Comm.', 'Commission');
		if (in_array($nom_colonne, $tab_valeur_right, true) ) {
			$position='right';
		}
		
		if ( strpos($nom_colonne, '-01') > 0 or strpos($nom_colonne, '-02') > 0 or strpos($nom_colonne, '-03') > 0 or strpos($nom_colonne, '-04') > 0 or strpos($nom_colonne, '-05') > 0 or strpos($nom_colonne, '-06') > 0 or strpos($nom_colonne, '-07') > 0 or strpos($nom_colonne, '-08') > 0 or strpos($nom_colonne, '-09') > 0 or strpos($nom_colonne, '-10') > 0 or strpos($nom_colonne, '-11') > 0 or strpos($nom_colonne, '-12') > 0 ) {
			$position='right';
		}


		if ($nom_colonne != 'num_reporting' and $nom_colonne != 'num_client' and $nom_colonne != 'num_produit' and $nom_colonne != 'num_commande' and $nom_colonne != 'num_fournisseur' and $nom_colonne != 'num_plv' and $nom_colonne != 'num_rdv') { 

			if ($value == 'Envoyer') {
				echo '<td align=left>';
				echo "<span onClick=document.location='" . $url_envoyer . "'; style=cursor:pointer> $value </span>";
				echo '</td>';
			}
			
			else if ($nom_colonne == 'N� Commande' or $nom_colonne == 'N� Devis' or $nom_colonne == 'Commande') {
				echo '<td align=center>';
				echo "<span onClick=document.location='" . $url_commande . "'; style=cursor:pointer> $value </span>";
				echo '</td>';
			}
			
			else if ($nom_colonne == 'N&deg; RDV') {
				echo '<td align=center>';
				echo "<span onClick=document.location='" . $url_rdv . "'; style=cursor:pointer> $value </span>";
				echo '</td>';
			}
			
			else if ($nom_colonne == 'Client' or $nom_colonne == 'Prospect') {
				echo '<td align=left>';
				echo "<span onClick=document.location='" . $url_client . "'; style=cursor:pointer> $value </span>";
				echo '</td>';
			}
			
			else if ($nom_colonne == 'Fournisseur') {
				echo '<td align=left>';
				echo "<span onClick=document.location='" . $url_fournisseur . "'; style=cursor:pointer> $value </span>";
				echo '</td>';
			}
			
			else if ($nom_colonne == 'Produit') {
				echo '<td align=left>';
				echo "<span onClick=document.location='" . $url_produit . "'; style=cursor:pointer> $value </span>";
				echo '</td>';
			}
			
			else if ($nom_colonne == 'Compte') {
				echo '<td align=left>';
				echo "<span onClick=document.location='" . $url_compte_mod . "'; style=cursor:pointer> $value </span>";
				echo '</td>';
			}
			
			else if ($nom_colonne == 'Exporter') {
				echo '<td align=left>';
				echo "<span onClick=document.location='" . $url_reporting . "'; style=cursor:pointer> $value </span>";
				echo '</td>';
			}
			
			else {
				echo '<td class=style2 align='.$position.'>';
				echo ($value == NULL) ? '<i>NULL</i>' : $value;
				echo '</td>';
			}
		
		}
	}
echo '</tr>';
}
echo '</table>';

}

// fonction qui affiche une ligne en gris fourni en parametre ----------------------------------------------
function f_affiche_tableau_global ($tab_a_afficher, $tab_size) {

echo '<table width=100%>';

while ($ligne = $tab_a_afficher->fetch(PDO::FETCH_NUM)) {
echo '<tr>';
 
	for ($j = 0; $j < $tab_a_afficher->columnCount(); $j++) {
		
		$nom_colonne = $tab_a_afficher->getColumnMeta($j)['name'];;
		$size=$tab_size[$j];
		$position='left';
		
		$tab_valeur_center = array('Date', 'N� Client', 'N� Fournisseur', 'Date cr�ation', 'Date modification', 'N� PLV', 'Date de commande', 'Date de modification', 'Ann�e', 'num_client', 'num_commande', 'num_fournisseur', 'num_plv');
		if (in_array($nom_colonne, $tab_valeur_center, true) ) {
			$position='center';
		}
		
		$tab_valeur_right = array('Global','Total HT', 'CA', 'Comm.', 'Quantit�', 'Nb Commandes', 'Moy CA', 'Moy Comm.', 'Commission');
		if (in_array($nom_colonne, $tab_valeur_right, true) ) {
			$position='right';
		}
		
		if ( strpos($nom_colonne, '-01') > 0 or strpos($nom_colonne, '-02') > 0 or strpos($nom_colonne, '-03') > 0 or strpos($nom_colonne, '-04') > 0 or strpos($nom_colonne, '-05') > 0 or strpos($nom_colonne, '-06') > 0 or strpos($nom_colonne, '-07') > 0 or strpos($nom_colonne, '-08') > 0 or strpos($nom_colonne, '-09') > 0 or strpos($nom_colonne, '-10') > 0 or strpos($nom_colonne, '-11') > 0 or strpos($nom_colonne, '-12') > 0 ) {
			$position='right';
		}

		echo '<td bgcolor=#B3B3B3 class=style2 width='.$size.'% align='.$position.'>';
		echo ($ligne[$j] == NULL) ? '<i>NULL</i>' : $ligne[$j];
		echo '</td>';
		
	}
echo '</tr>';
}
echo '</table>';
}

// fonction qui retourne la liste a afficher des clients ou fournisseurs ----------------------------------------------
function f_affiche_liste_client_fournisseurs ($login, $flag_clt_fou, $flag_clt_ppt) {

//include('inc/start_connexion.php');

if      ($flag_clt_fou == 'C') 
{ $nom_champ1 = 'num_client';		$nom_champ2 = 'N� Client'; if($flag_clt_ppt == 'C') {$nom_champ3 = 'Client';} if($flag_clt_ppt == 'P') {$nom_champ3 = 'Prospect';}  $condition = "and flag_client_prospect = '$flag_clt_ppt' ";}
else if ($flag_clt_fou == 'F') { $nom_champ1 = 'num_fournisseur';	$nom_champ2 = 'N� Fournisseur'; $nom_champ3 = 'Fournisseur'; $condition = '';}
else    { $nom_champ1 == 'num'; $nom_champ2 = 'N�'; $nom_champ3 = 'Entite';}

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }

$order_query='order by ' . $id_col . ' ' . $sens_req;

if ($flag_clt_fou == 'C' and $flag_clt_ppt == 'C') {

$req_sql = " 
select	num_tiers :nom_champ1,
		num_tiers :nom_champ2, 
 		nom_tiers :nom_champ3, 
		concat(adr_livraison_cp , ' - ', adr_livraison_ville ) 'CP - Ville',
		date_format( date_insertion  , '%Y-%m-%d %H:%i' ) 'Date cr�ation',
		date_format( date_modification  , '%Y-%m-%d %H:%i' ) 'Date modification',
		(	select	date_format(max(cc.commande_date), '%Y-%m-%d') 
			from	wm_client_commande cc 
			where	cc.login_site	= c.login_site 
			and		cc.num_tiers	= c.num_tiers
		)  'Derniere commande',
		(	select	datediff (current_date, max(cc.commande_date)) 
			from	wm_client_commande cc 
			where	cc.login_site	= c.login_site 
			and		cc.num_tiers	= c.num_tiers
		)  'Nb jours'
from	wm_ref_tiers c
where	c.login_site				= :login 
and		c.tiers_visible				= 'O' 
and		c.flag_fournisseur_client	= :flag_clt_fou 
:condition 
:order_query" ;

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='10';
$tab_size[2]='40';
$tab_size[3]='15';
$tab_size[4]='10';
$tab_size[5]='10';
$tab_size[6]= '10';
$tab_size[7]= '5';
}

if ($flag_clt_fou == 'C' and $flag_clt_ppt == 'P') {

$req_sql = " 
select	num_tiers :nom_champ1,
		num_tiers :nom_champ2, 
 		nom_tiers :nom_champ3, 
		concat(adr_livraison_cp , ' - ',adr_livraison_ville) 'CP - Ville',
		date_format( date_insertion  , '%Y-%m-%d %H:%i' ) 'Date cr�ation',
		date_format( date_modification  , '%Y-%m-%d %H:%i' ) 'Date modification'
from	wm_ref_tiers c
where	c.login_site				= :login 
and		c.tiers_visible				= 'O' 
and		c.flag_fournisseur_client	= :flag_clt_fou 
:condition 
:order_query" ;

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='10';
$tab_size[2]='40';
$tab_size[3]='30';
$tab_size[4]='10';
$tab_size[5]='10';
$tab_size[6]= '0';
}

if ($flag_clt_fou == 'F') {

$req_sql = " 
select	num_tiers :nom_champ1',
		num_tiers :nom_champ2', 
 		nom_tiers :nom_champ3', 
		concat(adr_livraison_cp , ' - ', adr_livraison_ville ) 'CP - Ville',
		date_format( date_insertion  , '%Y-%m-%d %H:%i' ) 'Date cr�ation',
		date_format( date_modification  , '%Y-%m-%d %H:%i' ) 'Date modification',
		(	select	date_format(max(cc.commande_date), '%Y-%m-%d') 
			from	wm_client_commande	cc, 
					wm_commande			co 
			where	cc.login_site		= c.login_site 
			and		cc.login_site		= co.login_site
			and		cc.num_commande		= co.num_commande
			and		co.id_fournisseur	= c.num_tiers
		)  'Derniere commande',
		(	select	datediff (current_date, max(cc.commande_date)) 
			from	wm_client_commande	cc, 
					wm_commande			co 
			where	cc.login_site		= c.login_site 
			and		cc.login_site		= co.login_site
			and		cc.num_commande		= co.num_commande
			and		co.id_fournisseur	= c.num_tiers
		)  'Nb jours'
from	wm_ref_tiers c
where	c.login_site				= :login 
and		c.tiers_visible				= 'O' 
and		c.flag_fournisseur_client	= :flag_clt_fou 
:condition 
:order_query" ;

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='10';
$tab_size[2]='35';
$tab_size[3]='20';
$tab_size[4]='10';
$tab_size[5]='10';
$tab_size[6]= '10';
$tab_size[7]= '5';
}



$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login, 
							 'flag_clt_fou'=> $flag_clt_fou,
							 'condition'  => $condition,
							 'order_query' => $order_query,
							 'nom_champ1' => $nom_champ1,
							 'nom_champ2' => $nom_champ2,
							 'nom_champ3' => $nom_champ3]) or die('<br> Erreur sql f_affiche_liste_client_fournisseurs');;



f_affiche_tableau($statement, $tab_size);


}

// fonction qui calcule le nb de tiers ----------------------------------------------
function f_calcul_nb_tiers ($login, $flag_clt_fou, $flag_clt_ppt) {

//include('inc/start_connexion.php');

if ($flag_clt_fou == 'C') { $condition = "and flag_client_prospect = '$flag_clt_ppt' "; } else { $condition = ''; }

$req_sql ="
select	count(*) nb_tiers
from	wm_ref_tiers
where	login_site				= :login
and		tiers_visible			= 'O'
and 	flag_fournisseur_client = :flag_clt_fou
:condition";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login, 'flag_clt_fou'=> $flag_clt_fou,'condition' => $condition ]) or die('<br> Erreur sql f_calcul_nb_tiers ');;

$ligne = $statement->fetch(PDO::FETCH_NUM);

return $ligne [0];

//include('inc/end_connexion.php');

}

// fonction qui affiche toutes les infos comptes ----------------------------------------------
function f_affiche_compte($login) {

//include('inc/start_connexion.php');

$req_sql ="
select	login,
		mdp,
		nom_tiers,
		nom,
		prenom,
		adresse1,
		adresse2,
		cp,
		ville,
		num_siret,
		num_tva,
		e_mail,
		tel_fixe,
		tel_mobile,
		dat_cre,
		dat_upd,
		flag_admin,
		begin_date,
		end_date,
		nb_lignes_commande,
		pied_de_mail
from    ref_comptes
where   login = :login";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
  

$res_sql = $statement->execute(['login' => $login]) or die('<br> Erreur sql f_affiche_compte ');
$ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne;

//include('inc/end_connexion.php');

}

// fonction qui recupere toutes les infos clientes ----------------------------------------------
function f_affiche_client($login, $id_client) {

//include('inc/start_connexion.php');

$req_sql ="
select	num_tiers,
		num_siret,
		num_tva,
		nom_tiers,
		adr_livraison_1,
		adr_livraison_2,
		adr_livraison_cp,
		adr_livraison_ville,
		adr_facturation_1,
		adr_facturation_2,
		adr_facturation_cp,
		adr_facturation_ville,
		paiement_mode,
		paiement_delai_j,
		nom_contact_1,
		nom_contact_2,
		nom_contact_3,
		nom_contact_4,
		nom_contact_5,
		mail_contact_1,
		mail_contact_2,
		mail_contact_3,
		mail_contact_4,
		mail_contact_5,
		telephone_livraison,
		telephone_portable,
		telephone_fixe,
		date_anniversaire,
		date_insertion,
		date_modification,
		categorie,
		commentaire,
		flag_client_prospect
from    wm_ref_tiers
where   login_site              = :login
and     num_tiers               = :id_client
and     flag_fournisseur_client = 'C'";


$pdo_instance = SPDO::getInstance();

$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login, 'id_client'=> $id_client]) or die('<br> Erreur sql f_affiche_client ');




$ligne  = $statement->fetch(PDO::FETCH_NUM);
return $ligne;

//include('inc/end_connexion.php');

}

// fonction qui recupere toutes les infos clientes ----------------------------------------------
function f_affiche_fournisseur($login, $id_client) {

//include('inc/start_connexion.php');

$req_sql ="
select	num_tiers,
		num_siret,
		num_tva,
		nom_tiers,
		adr_livraison_1,
		adr_livraison_2,
		adr_livraison_cp,
		adr_livraison_ville,
		nom_contact_1,
		nom_contact_2,
		mail_contact_1,
		mail_contact_2,
		telephone_fixe,
		date_insertion,
		date_modification,
		categorie,
		flag_envoi_pdf,
		flag_gestion_produit,
		commentaire
from    wm_ref_tiers
where   login_site              = :login
and     num_tiers               = :id_client
and     flag_fournisseur_client = 'F'";

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute(['login' => $login, 'id_client'=> $id_client]) or die('<br> Erreur sql f_affiche_fournisseur ');



$ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne;


}

// fonction qui modifie les infos d'un compte ----------------------------------------------
function f_modification_compte_mdp($login, $tab_mod) {

//include('inc/start_connexion.php');

$mdp1	= trim($tab_mod['mdp1']);
$mdp2	= trim($tab_mod['mdp2']);
$mdp3	= trim($tab_mod['mdp3']);

if ($mdp1 == '') { return 'pb'; }
if ($mdp2 == '') { return 'pb'; }
if ($mdp3 == '') { return 'pb'; }

//include('inc/start_connexion.php');

$req_sql ="
select	mdp
from    ref_comptes
where   login = :login";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login]);

$ligne = $statement->fetch(PDO::FETCH_NUM);

$mdp_actuel = $ligne[0];

if ( md5($mdp1) == $mdp_actuel and $mdp2 == $mdp3 ) {
	
	$mdp_new = md5($mdp2);
	
	$req_sql ="
	update	ref_comptes
	set		mdp			= :mdp_new,
			dat_upd		= CURRENT_TIMESTAMP
	where	login		= :login";


	$statement = $pdo_instance->prepare($req_sql);
	$statement->execute(["login"=> $login, 'mdp_new'=> $mdp_new]) or die('<br> Erreur sql f_modification_compte_mdp - 2');
		
	return 'ok';
}
else { return 'pb'; }


}

// fonction qui modifie les infos d'un compte ----------------------------------------------
function f_modification_compte($login, $tab_mod) {

//include('inc/start_connexion.php');

$nom_tiers			= trim($tab_mod['nom_tiers']);
$nom				= trim($tab_mod['nom']);
$prenom				= trim($tab_mod['prenom']);
$adresse1			= trim($tab_mod['adresse1']);
$adresse2			= trim($tab_mod['adresse2']);
$cp					= trim($tab_mod['cp']);
$ville				= trim($tab_mod['ville']);
$num_siret			= trim($tab_mod['num_siret']);
$num_tva			= trim($tab_mod['num_tva']);
$e_mail				= trim($tab_mod['e_mail']);
$tel_fixe			= trim($tab_mod['tel_fixe']);
$tel_mobile			= trim($tab_mod['tel_mobile']);
$nb_lignes_commande = trim($tab_mod['nb_lignes_commande']);
$pied_de_mail 		= trim($tab_mod['pied_de_mail']);

$req_sql ="
update	ref_comptes
set		nom_tiers			= '$nom_tiers',
		nom					= '$nom',
		prenom				= '$prenom',
		adresse1			= '$adresse1',
		adresse2			= '$adresse2',
		cp					= '$cp',
		ville				= '$ville',
		num_siret			= '$num_siret',
		num_tva				= '$num_tva',
		e_mail				= '$e_mail',
		tel_fixe			= '$tel_fixe',
		tel_mobile			= '$tel_mobile',
		dat_upd				= CURRENT_TIMESTAMP,
		nb_lignes_commande	= $nb_lignes_commande,
		pied_de_mail		= '$pied_de_mail'
where	login				= '$login'";

  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute() or die('<br> Erreur sql f_modification_compte');
		

}

// fonction qui modifie les infos clientes ----------------------------------------------
function f_modification_client($login, $id_client, $tab_mod) {


$num_siret				= $tab_mod['num_siret'];
$num_tva				= $tab_mod['num_tva'];
$nom_tiers				= $tab_mod['nom_tiers'];
$nom_tiers_code			= $tab_mod['nom_tiers_code'];
$adr_livraison_1		= $tab_mod['adr_livraison_1'];
$adr_livraison_2		= $tab_mod['adr_livraison_2'];
$adr_livraison_cp		= $tab_mod['adr_livraison_cp'];
$adr_livraison_ville	= $tab_mod['adr_livraison_ville'];
$adr_facturation_1		= $tab_mod['adr_facturation_1'];
$adr_facturation_2		= $tab_mod['adr_facturation_2'];
$adr_facturation_cp		= $tab_mod['adr_facturation_cp'];
$adr_facturation_ville	= $tab_mod['adr_facturation_ville'];
$paiement_mode			= $tab_mod['paiement_mode'];
$paiement_delai_j		= $tab_mod['paiement_delai_j'];
$nom_contact_1			= $tab_mod['nom_contact_1'];
$nom_contact_2			= $tab_mod['nom_contact_2'];
$nom_contact_3			= $tab_mod['nom_contact_3'];
$nom_contact_4			= $tab_mod['nom_contact_4'];
$nom_contact_5			= $tab_mod['nom_contact_5'];
$mail_contact_1			= $tab_mod['mail_contact_1'];
$mail_contact_2			= $tab_mod['mail_contact_2'];
$mail_contact_3			= $tab_mod['mail_contact_3'];
$mail_contact_4			= $tab_mod['mail_contact_4'];
$mail_contact_5			= $tab_mod['mail_contact_5'];
$telephone_livraison	= $tab_mod['telephone_livraison'];
$telephone_portable		= $tab_mod['telephone_portable'];
$telephone_fixe			= $tab_mod['telephone_fixe'];
$date_anniversaire		= $tab_mod['date_anniversaire'];
$categorie				= $tab_mod['categorie'];
$commentaire			= $tab_mod['commentaire'];

$req_sql ="
select count(*) 
from   wm_ref_tiers 
where  login_site = :login
and    nom_tiers  = trim(:nom_tiers)
and    flag_fournisseur_client = 'F'";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login, 'nom_tiers'=> $nom_tiers]);
$ligne   = $statement->fetch(PDO::FETCH_NUM);

if ($ligne[0] > 0) {
	$nom_tiers      = $nom_tiers . ' CLIENT';
	$nom_tiers_code = $nom_tiers_code . ' CLIENT';
}

$req_sql ="
update	wm_ref_tiers
set		num_siret				= trim('$num_siret'),
		num_tva					= trim('$num_tva'),
		nom_tiers				= trim('$nom_tiers'),
		nom_tiers_code			= replace(trim('$nom_tiers_code'), '&quot;', ''), 
		adr_livraison_1			= trim('$adr_livraison_1'),
		adr_livraison_2			= trim('$adr_livraison_2'),
		adr_livraison_cp		= trim('$adr_livraison_cp'),
		adr_livraison_ville		= trim('$adr_livraison_ville'),
		adr_facturation_1		= trim('$adr_facturation_1'),
		adr_facturation_2		= trim('$adr_facturation_2'),
		adr_facturation_cp		= trim('$adr_facturation_cp'),
		adr_facturation_ville	= trim('$adr_facturation_ville'),
		paiement_mode			= '$paiement_mode',
		paiement_delai_j		= '$paiement_delai_j',
		nom_contact_1			= trim('$nom_contact_1'),
		nom_contact_2			= trim('$nom_contact_2'),
		nom_contact_3			= trim('$nom_contact_3'),
		nom_contact_4			= trim('$nom_contact_4'),
		nom_contact_5			= trim('$nom_contact_5'),
		mail_contact_1			= trim('$mail_contact_1'),
		mail_contact_2			= trim('$mail_contact_2'),
		mail_contact_3			= trim('$mail_contact_3'),
		mail_contact_4			= trim('$mail_contact_4'),
		mail_contact_5			= trim('$mail_contact_5'),
		telephone_livraison		= trim('$telephone_livraison'),
		telephone_portable		= trim('$telephone_portable'),
		telephone_fixe			= trim('$telephone_fixe'),
		date_anniversaire       = '$date_anniversaire',
		categorie				= '$categorie',
		commentaire				= '$commentaire',
		date_modification		= CURRENT_TIMESTAMP
where	num_tiers				= $id_client
and		login_site				= '$login'
and     flag_fournisseur_client = 'C'";

$statement = $pdo_instance->prepare($req_sql);
$statement->execute() or die('<br> Erreur sql f_modification_client - 2');

		

}

// fonction qui modifie les infos fournisseur ----------------------------------------------
function f_modification_fournisseur ($login, $id_client, $tab_mod) {

//include('inc/start_connexion.php');

$num_siret				= $tab_mod['num_siret'];
$num_tva				= $tab_mod['num_tva'];
$nom_tiers				= $tab_mod['nom_tiers'];
$nom_tiers_code			= $tab_mod['nom_tiers_code'];
$adr_livraison_1		= $tab_mod['adr_livraison_1'];
$adr_livraison_2		= $tab_mod['adr_livraison_2'];
$adr_livraison_cp		= $tab_mod['adr_livraison_cp'];
$adr_livraison_ville	= $tab_mod['adr_livraison_ville'];
$nom_contact_1			= $tab_mod['nom_contact_1'];
$nom_contact_2			= $tab_mod['nom_contact_2'];
$mail_contact_1			= $tab_mod['mail_contact_1'];
$mail_contact_2			= $tab_mod['mail_contact_2'];
$telephone_fixe			= $tab_mod['telephone_fixe'];
$categorie				= $tab_mod['categorie'];
$flag_envoi_pdf			= $tab_mod['flag_envoi_pdf'];
$flag_gestion_produit	= $tab_mod['flag_gestion_produit'];
$commentaire			= $tab_mod['commentaire'];

$req_sql ="
select count(*) 
from   wm_ref_tiers 
where  login_site = :login
and    nom_tiers  = trim(:nom_tiers)
and    flag_fournisseur_client = 'C'";


$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute(['login' => $login, 'nom_tiers'=> $nom_tiers]) or die('<br> Erreur sql f_modification_fournisseur - 1 ');

$ligne   = $statement->fetch(PDO::FETCH_NUM);

if ($ligne[0] > 0) {
	$nom_tiers      = $nom_tiers . ' FOURNISSEUR';
	$nom_tiers_code = $nom_tiers_code . ' FOURNISSEUR';
}

$req_sql ="
update	wm_ref_tiers
set		num_siret				= trim('$num_siret'),
		num_tva					= trim('$num_tva'),
		nom_tiers				= trim('$nom_tiers'),
		nom_tiers_code			= replace(trim('$nom_tiers_code'), '&quot;', ''),
		adr_livraison_1			= trim('$adr_livraison_1'),
		adr_livraison_2			= trim('$adr_livraison_2'),
		adr_livraison_cp		= trim('$adr_livraison_cp'),
		adr_livraison_ville		= trim('$adr_livraison_ville'),
		nom_contact_1			= trim('$nom_contact_1'),
		nom_contact_2			= trim('$nom_contact_2'),
		mail_contact_1			= trim('$mail_contact_1'),
		mail_contact_2			= trim('$mail_contact_2'),
		telephone_fixe			= trim('$telephone_fixe'),
		categorie				= trim('$categorie'),
		flag_envoi_pdf			= trim('$flag_envoi_pdf'),
		flag_gestion_produit    = trim('$flag_gestion_produit'),
		commentaire				= trim('$commentaire'),
		date_modification		= CURRENT_TIMESTAMP
where	num_tiers				= '$id_client'
and		login_site				= '$login'
and     flag_fournisseur_client = 'F'";


$statement = $pdo_instance->prepare($req_sql);
$statement->execute() or die('<br> Erreur sql f_modification_fournisseur - 2');
		
//include('inc/end_connexion.php');

}

// fonction qui supprime 1 client ----------------------------------------------
function f_supprimer_client($login, $id_client) {

//include('inc/start_connexion.php');

$req_upd_sql ="
update	wm_ref_tiers
set		tiers_visible = 'N'
where	login_site = :login
and		num_tiers = :id_client";

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_upd_sql);	
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('id_client', $id_client, PDO::PARAM_INT) or die('<br> Erreur sql f_supprimer_client');


}

// fonction qui ajoute les infos clientes ----------------------------------------------
function f_ajoute_tiers($login, $flag_fournisseur_client) {

f_supprime_tiers_invalide($login);

//include('inc/start_connexion.php');

$req_ins_sql ="
insert into wm_ref_tiers (date_insertion, date_modification, login_site, flag_fournisseur_client, tiers_visible) 
values (CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :login, :flag_fournisseur_client, 'O')";
$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_ins_sql);
$statement->execute(['login' => $login, 'flag_fournisseur_client'=> $flag_fournisseur_client]) or die('<br> Erreur sql f_ajoute_tiers - 1');

$req_sql ="
select	max(num_tiers) id_client
from	wm_ref_tiers
where	login_site	= :login
and		nom_tiers	is null";

$statement = $pdo_instance->prepare($req_sql);

$statement->execute(['login' => $login]) or die('<br> Erreur sql f_ajoute_tiers - 2');


$ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne[0];


}

// fonction qui supprime les clients invalides ----------------------------------------------
function f_supprime_tiers_invalide($login) {

//include('inc/start_connexion.php');

$req_del_sql ="
delete from wm_ref_tiers 
where login_site = :login
and   (nom_tiers  = '' or nom_tiers is null)";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_del_sql);
$statement->execute(['login' => $login]);


}

// fonction qui supprime les commandes invalides ----------------------------------------------
function f_supprime_commande_invalide($login) {

//include('inc/start_connexion.php');

$req_del_sql ="
delete from wm_client_commande 
where login_site = :login
and   num_tiers  = 0";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_del_sql);
$statement->execute(['login' => $login]) or die('<br> Erreur sql f_supprime_commande_invalide - 1');

}

// fonction qui ajoute les infos clientes ----------------------------------------------
function f_ajoute_commande_devis($login, $type_commande) {

f_supprime_commande_invalide($login);

//include('inc/start_connexion.php');

$req_ins_sql ="
insert into wm_client_commande (date_insertion, date_modification, login_site, type_commande, commande_visible, etat_commande, num_tiers, commande_date, flag_ok) 
values (CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :login, :type_commande, 'O', 'E', 0, CURRENT_DATE, 'N')";
$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_ins_sql);
$statement->execute(['login' => $login, 'type_commande' => $type_commande ]) or die('<br> Erreur sql f_ajoute_commande_devis - 1');
	

$req_sql ="
select	max(num_commande) num_commande
from	wm_client_commande
where	login_site	     = :login
and     commande_visible = 'O'";

$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login]) or die('<br> Erreur sql f_ajoute_commande_devis - 2');

$ligne = $statement->fetch(PDO::FETCH_NUM);

return $ligne[0];


}

// fonction qui calcule le nb de commande/devis en fonction du statut -----------------------
// $flag_devis_commande : C Commande D Devis
// $flag_etat : E En cours
// $login : login de connexion
function f_calcul_nb_commande_devis ($flag_devis_commande, $flag_etat, $login) {

if ($flag_etat == 'E') {

$req_sql = "
select	ifnull(count(*), 0) nb_lignes
from	wm_client_commande c,
        wm_ref_tiers       t
where	c.login_site    = :login
and		c.login_site    = t.login_site
and     c.num_tiers     = t.num_tiers
and		c.type_commande = :flag_devis_commande
and		c.etat_commande = :flag_etat";

}

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute([
	'login' => $login, 
	'flag_devis_commande'=> $flag_devis_commande,
	'flag_etat' => $flag_etat

]) or die('<br> Erreur sql f_calcul_nb_commande_devis');
result: $ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne[0];


}

// fonction qui retourne la liste a afficher des commandes / devis en fonction de l'etat ----------------------------
function f_affiche_liste_commande_devis ($flag_commande_devis, $flag_etat, $login) {

//include('inc/start_connexion.php');

if ($flag_commande_devis == 'C') {$nom_champ = 'N� Commande';}
else if ($flag_commande_devis == 'D') {$nom_champ = 'N� Devis';}
else {$nom_champ = 'N�';}

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }

if ($flag_etat == 'T') {	// --> Toutes les commandes

if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }
if ($id_col>7) {$id_col=3;}

$order_query='order by ' . $id_col . ' ' . $sens_req;

$req_sql = "
select	c.num_tiers		num_client,
		c.num_commande	num_commande,
		c.num_commande	:nom_champ,
        t.nom_tiers		'Client',
		case c.etat_commande when 'A' then 'Annul�e' when 'V' then 'Valid�e' when 'T' then 'Termin�e' when 'E' then 'En cours' else '' end Statut,	
		(select round(ifnull(sum(quantite*prix_ht),0),2) from wm_commande wc where login_site = :login and wc.num_commande = c.num_commande) 'Total HT',
		date_format(c.commande_date,'%Y-%m-%d')	'Date commande',
		date_format(c.date_modification,'%Y-%m-%d')	'Date modification',
		date_format(c.date_insertion,'%Y-%m-%d')	'Date cr�ation'
from	wm_client_commande c,
        wm_ref_tiers       t
where	c.login_site    = :login
and		c.login_site    = t.login_site
and     c.num_tiers     = t.num_tiers
and		c.type_commande = :flag_commande_devis
$order_query";

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='0';
$tab_size[2]='10';
$tab_size[3]='35';
$tab_size[4]='10';
$tab_size[5]='10';
$tab_size[6]='15';
$tab_size[7]='10';
$tab_size[8]='10';
$tab_size[9]='0';
$tab_size[10]='0';

}

if ($flag_etat == 'E') {

if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }
if ($id_col>7) {$id_col=3;}

$order_query='order by ' . $id_col . ' ' . $sens_req;

$req_sql = "
select	c.num_tiers		num_client,
		c.num_commande	num_commande,
		c.num_commande	:nom_champ,
        t.nom_tiers		'Client',
		(select round(ifnull(sum(quantite*prix_ht),0),2) from wm_commande wc where login_site = :login and wc.num_commande = c.num_commande) 'Total HT',
		date_format(c.commande_date,'%Y-%m-%d')	'Date de commande',
		date_format(c.date_modification,'%Y-%m-%d')	'Date de modification'
from	wm_client_commande c,
        wm_ref_tiers       t
where	c.login_site    = :login
and		c.login_site    = t.login_site
and     c.num_tiers     = t.num_tiers
and		c.type_commande = :flag_commande_devis
and		c.etat_commande = :flag_etat
$order_query";

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='0';
$tab_size[2]='10';
$tab_size[3]='55';
$tab_size[4]='15';
$tab_size[5]='10';
$tab_size[6]='10';
$tab_size[7]='0';

}

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute(['login' => $login, 
  								'nom_champ'=> $nom_champ,
								'flag_commande_devis' => $flag_commande_devis, 'flag_etat' => $flag_etat
							
							]) or die('<br> Erreur sql f_affiche_liste_commande_devis ');




f_affiche_tableau($statement, $tab_size);


}

function f_affiche_liste_commande_devis_client ($num_client, $login, $flag_commande_devis) {

//include('inc/start_connexion.php');

if ($flag_commande_devis == 'C') {$nom_champ = 'N� Commande';}
else if ($flag_commande_devis == 'D') {$nom_champ = 'N� Devis';}
else {$nom_champ = 'N�';}

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='DESC'; }

if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=2; }
if ($id_col>7) {$id_col=3;}

$order_query='order by ' . $id_col . ' ' . $sens_req;

// Gestion du titre -----------
$req_sql = "
select	nom_tiers, flag_fournisseur_client
from	wm_ref_tiers       t
where	login_site    = :login
and		num_tiers     = :num_client";

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
 
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('num_client', $num_client, PDO::PARAM_INT);
  
  $statement->execute() or die('<br> Erreur sql f_affiche_liste_commande_devis_client - 1');
$ligne = $statement->fetch(PDO::FETCH_NUM);


$nom_client = $ligne[0];
$flag_fournisseur_client = $ligne[1];

if ($flag_fournisseur_client == 'C') { $flag_fournisseur_client = 'client'; } else { $flag_fournisseur_client = 'fournisseur'; }
if ($flag_commande_devis == 'C') { $flag_cd = 'Commandes'; } else { $flag_cd = 'Devis'; }
$url_='wm_accueil.php?menu_=n_a&tiers_=client&id_client='.$num_client;
$lien = "<span onClick=document.location='" . $url_ . "'; style=cursor:pointer> $nom_client </span>";
$titre = $flag_cd . ' du ' . $flag_fournisseur_client . ' : ' . $lien;

// Gestion du tableau -----------
$req_sql = "
select	c.num_tiers		num_client,
		c.num_commande	num_commande,
		c.num_commande	:nom_champ,
		case c.etat_commande when 'A' then 'Annul�e' when 'T' then 'Termin�e' when 'E' then 'En cours' else '' end Statut,	
		(select group_concat(f.nom_tiers) from wm_ref_tiers f, wm_commande_plv p where f.num_tiers = p.id_fournisseur and f.login_site = p.login_site and p.num_commande = c.num_commande and p.login_site = :login) 'Fournisseurs',
		(select round(ifnull(sum(quantite*prix_ht),0),2) from wm_commande wc where login_site = :login and wc.num_commande = c.num_commande) 'Total HT',
		date_format(c.commande_date,'%Y-%m-%d')	'Date de commande',
		date_format(c.date_modification,'%Y-%m-%d')	'Date modification',
		date_format(c.date_insertion,'%Y-%m-%d')	'Date cr�ation'
from	wm_client_commande c,
        wm_ref_tiers       t
where	c.login_site    = :login
and		c.login_site    = t.login_site
and     c.num_tiers     = t.num_tiers
and		c.num_tiers     = :num_client
and		c.type_commande = '$flag_commande_devis'
$order_query";

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='0';
$tab_size[2]='10'; // N� Commande
$tab_size[3]='10'; // Statut
$tab_size[4]='40'; // Fournisseurs
$tab_size[5]='10'; // Total HT
$tab_size[6]='10'; // Date de commande
$tab_size[7]='10'; // Date modification
$tab_size[8]='10'; // Date cr�ation


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);

$statement->bindParam('nom_champ', $nom_champ, PDO::PARAM_STR);
$statement->bindParam('num_client',$num_client, PDO::PARAM_INT);
$statement->bindParam('login',$login, PDO::PARAM_STR);




			

$res_sql = $statement->execute() or die('<br> Erreur sql f_affiche_liste_commande_devis_client - 2');

// Affichage du tableau
echo '<table width=100% cellpadding=0 align=center border=0 class=style_form_1>';
echo '<tr>';
echo '<td> <br><br><br> </td>';
echo '</tr>';
echo '<tr>';
echo '<td bgcolor=#B3B3B3 class=titre2> '.$titre .'</td>';
echo '</tr>';
echo '<tr>';
echo '<td> <br> </td>';
echo '</tr>';
echo '</table>';

f_affiche_tableau($statement, $tab_size);

//include('inc/end_connexion.php');

}

// fonction qui affiche la liste des fournisseurs dans une liste d�roulante d'un formulaire -----------------------
function f_form_affiche_liste_clients_fournisseurs ($login, $flag_clt_fou, $premiere_ligne) {

echo '<option>' . $premiere_ligne . '</option>';

//include('inc/start_connexion.php');

$req_sql = "
select	nom_tiers_code
from	wm_ref_tiers 
where	login_site				= :login
and		tiers_visible			= 'O'
and     flag_fournisseur_client	= :flag_clt_fou
and		trim(nom_tiers_code)	!= trim(:premiere_ligne)
order by nom_tiers_code";


$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->bindParam("flag_clt_fou", $flag_clt_fou, PDO::PARAM_STR);
  $statement->bindParam("premiere_ligne", $premiere_ligne, PDO::PARAM_STR);



 $statement->execute() or die('<br> Erreur sql f_form_affiche_liste_fournisseurs');

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {
      echo '<option>' . $ligne[0]. '</option>';
}

//include('inc/end_connexion.php');
}

// fonction qui affiche les n lignes dans le formulaire commande  -----------------------
function f_form_affiche_lignes_commandes ($login, $nb_lignes, $id_commande, $color_title) {

$req_sql ="
select	f.nom_tiers_code			nom_fournisseur,
		c.produit,
		c.quantite,
		c.prix_ht,
		c.commission		divers,
		case c.flag_ok when 'O' then round(c.quantite*c.prix_ht,2) else 0 end total_ligne
from    wm_commande			c,
		wm_ref_tiers		f
where   c.login_site              = :login
and		c.num_commande		      = :id_commande
and     c.id_fournisseur          = f.num_tiers
and     f.flag_fournisseur_client = 'F'
and     c.login_site		      = f.login_site
order by f.nom_tiers_code, produit";

echo '<table width=100%>';
echo '<tr>';
echo '<td width=40% bgcolor=' . $color_title . ' align=center> Fournisseur </td>';
echo '<td width=25% bgcolor=' . $color_title . ' align=center> Produit </td>';
echo '<td width=5% bgcolor=' . $color_title . ' align=center> Quantit� </td>';
echo '<td width=6% bgcolor=' . $color_title . ' align=center> Prix HT </td>';
echo '<td width=9% bgcolor=' . $color_title . ' align=center> Total </td>';
echo '<td width=5% bgcolor=' . $color_title . ' align=center> Divers </td>';
echo '</tr>';

for($i=1 ;$i <= $nb_lignes; $i++) {

$n_fournisseur = 'nom_fournisseur_' . $i ;
$n_produit     = 'produit_' . $i ;
$n_quantite    = 'quantite_' . $i ;
$n_prix_ht     = 'prix_ht_' . $i ;
$n_divers      = 'divers_' . $i ;
$n_total       = 'total_' . $i ;

$v_fournisseur = '' ;
$v_produit     = '' ;
$v_quantite    = '' ;
$v_prix_ht     = '' ;
$v_divers      = '' ;
$v_total       = '' ;

$cpt=0;

//include('inc/start_connexion.php');
$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam('login', $login,PDO::PARAM_STR);
  $statement->bindParam('id_commande', $id_commande,type: PDO::PARAM_INT);
  
  $statement->execute() or die('<br> Erreur sql f_form_affiche_lignes_commandes');


while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {
	$cpt=$cpt+1;
	if($cpt == $i) {
		for ($j = 0; $j < count($ligne); $j++) {
				if ($j == 0) { $v_fournisseur = $ligne[$j]; }
				if ($j == 1) { $v_produit     = $ligne[$j]; }
				if ($j == 2) { $v_quantite    = $ligne[$j]; }
				if ($j == 3) { $v_prix_ht     = $ligne[$j]; }
				if ($j == 4) { $v_divers      = $ligne[$j]; }
				if ($j == 5) { $v_total       = $ligne[$j]; }
		}
	}
}

//include('inc/end_connexion.php');

echo '<tr valign=center>';
echo '<td align=center>';
echo "<select input type=text class=style_form_1 name=$n_fournisseur value='$v_fournisseur' style='width: 480px; height: 20px;'>";

if (strlen($v_fournisseur) > 0) {$premiere_ligne=$v_fournisseur;}
else {$premiere_ligne='';}
f_form_affiche_liste_clients_fournisseurs($login, 'F', $premiere_ligne);
echo '</select>';

echo '</td>';

$style_form_produit  = 'style_form_1';
$style_form_quantite = 'style_form_1';
$style_form_prix_ht  = 'style_form_1';
$style_form_divers   = 'style_form_1';

// GESTION DES ERREURS
if ($v_produit=='pb' ) { $v_produit  = 'A RENSEIGNER'; $style_form_produit  = 'style_form_2'; }
if ($v_quantite==-1 )  { $v_quantite = 'PB';           $style_form_quantite = 'style_form_2'; }
if ($v_prix_ht==-1 )   { $v_prix_ht  = 'PB';           $style_form_prix_ht  = 'style_form_2'; }
if ($v_divers==-1 )    { $v_divers   = 'PB';           $style_form_divers   = 'style_form_2'; }

?>
<td align=center> <input type=text class=<?php echo $style_form_produit; ?>    name="<?php echo $n_produit; ?>" style='width: 400px; height: 15px;'     value="<?php echo $v_produit; ?>"> </td>
<?php

echo "<td align=center> <input type=text class=$style_form_quantite	name='$n_quantite'	style='width: 50px; height: 15px;'	value='$v_quantite'> </td>";
echo "<td align=center> <input type=text class=$style_form_prix_ht	name='$n_prix_ht'	style='width: 80px; height: 15px;'	 value='$v_prix_ht'> </td>";
echo "<td align=center> <input type=text class=$style_form_prix_ht	name='$n_total'	    style='width: 100px; height: 15px;'	 value='$v_total' disabled=disabled> </td>";
echo "<td align=center> <input type=text class=$style_form_divers	name='$n_divers'	style='width: 80px; height: 15px;'	 value='$v_divers'> </td>";

echo '</tr>';
}

echo '</table>';

}

// fonction qui modifie une commande -----------------------
function f_modification_commande ($login, $id_commande, $tab_com_client, $tab_commmande, $nb_lignes, $tab_plv) {

$nom_client = trim($tab_com_client['nom_client']); 
$id_client = f_retourne_id_tiers ($login, $nom_client);

if ($id_client > 0) {
//include('inc/start_connexion.php');

$commande_date		= trim($tab_com_client['commande_date']);
$type_commande		= trim($tab_com_client['type_commande']);
$livraison_date		= trim($tab_com_client['livraison_date']);
$livraison_h_debut	= trim($tab_com_client['livraison_h_debut']);
$livraison_h_fin	= trim($tab_com_client['livraison_h_fin']);
$commentaire		= trim($tab_com_client['commentaire']);
$etat_commande		= trim($tab_com_client['etat_commande']);
$livraison_adr_flag	= trim($tab_com_client['adr_livraison_flag']);
$livraison_adr		= trim($tab_com_client['adr_livraison']);

if ($type_commande == '') { $type_commande = 'C'; }

if (strlen($commande_date) > 0 and strlen($type_commande) > 0 and strlen($livraison_date) > 0 and strlen($livraison_h_debut) > 0 and  strlen($livraison_h_fin) > 0 and strlen($etat_commande) > 0) {
$flag_ok = 'O';
}
else {
$flag_ok = 'N';
}

// UPDATE wm_client_commande
$req_sql ="
update	wm_client_commande
set		commande_date			= '$commande_date',
		num_tiers				=  $id_client,
		type_commande			= '$type_commande',
		livraison_date			= '$livraison_date',
		livraison_h_debut		= '$livraison_h_debut',
		livraison_h_fin			= '$livraison_h_fin',
		commentaire				= '$commentaire',
		date_modification		= CURRENT_TIMESTAMP,
		flag_ok					= '$flag_ok',
		etat_commande			= '$etat_commande',
		livraison_adr_flag		= '$livraison_adr_flag',
		livraison_adr			= case when '$livraison_adr_flag' = 'N' then null when '$livraison_adr' = '' then null else trim('$livraison_adr') end
where	num_commande			= $id_commande
and		login_site				= '$login'";

  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);


  $statement->execute() or die('<br> Erreur sql f_modification_commande - 1');

// GESTION DE LA TABLE wm_commande & PLV

// Suppression
$req_del_sql ="
delete	from wm_commande
where	login_site		= :login
and		num_commande	= :id_commande";


$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_del_sql);
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('login', $id_commande, PDO::PARAM_INT);
  
  $statement->execute() or die('<br> Erreur sql f_modification_commande - 2');

// Insertion
for($i=1 ;$i <= $nb_lignes; $i++) {

	$v_nom_fournisseur	= trim($tab_commmande[$i]['nom_fournisseur']);
	$v_produit			= trim($tab_commmande[$i]['produit']);
	$v_quantite			= trim($tab_commmande[$i]['quantite']);
	$v_prix_ht			= trim($tab_commmande[$i]['prix_ht']);
	$v_divers			= trim($tab_commmande[$i]['divers']);
	$v_id_fournisseur	= f_retourne_id_tiers($login, $v_nom_fournisseur);

	// L'insertion ne se fait que si le fournisseur est renseigne.
	if ($v_id_fournisseur > 0) {
	
	$error = 0;
	// Gestion des erreurs
	if (f_test_int($v_quantite) == 0) { $v_quantite = -1; $error = $error + 1; }
	if (f_test_float($v_prix_ht) == 0) { $v_prix_ht = -1; $error = $error + 1; }
	if (f_test_float($v_divers) == 0) { $v_divers = -1; $error = $error + 1; } 
	if (strlen(trim($v_produit)) > 0) { $v_produit = trim($v_produit); } else { $v_produit = 'pb'; $error = $error + 1;}
	if (trim($v_produit) == 'A RENSEIGNER')  { $v_produit = 'pb'; $error = $error + 1;}
	if ($error == 0) { $flag_ok = 'O'; } else { $flag_ok = 'N'; }
	
	$req_ins_sql = "
	insert into wm_commande (login_site, num_commande, id_fournisseur, produit, quantite, prix_ht, commission, flag_ok)
	values ('$login', $id_commande, $v_id_fournisseur, '$v_produit', $v_quantite, $v_prix_ht, $v_divers, '$flag_ok')";
	
	$statement = $pdo_instance->prepare($req_del_sql);

	$tab =  $statement->execute() or die('<br> Erreur sql f_modification_commande - 3');

	}
}


// GESTION DE LA TABLE wm_commande_plv

$nb_fournisseurs = f_calcul_nb_plv_commande($id_commande, $login);

// Suppression des fournisseurs qui n'existent plus
f_supprime_plv($login, $id_commande);
// Creation des PLV
f_ajoute_plv($login, $id_commande);

//include('inc/start_connexion.php');


$pdo_instance = SPDO::getInstance();

// Modification du PLV
for($i=1 ;$i <= $nb_fournisseurs; $i++) {
	
	$v_num_plv			= $tab_plv[$i]['num_plv'];
	$v_plv				= str_replace("'"," ", trim($tab_plv[$i]['plv']));
	
	$req_upd_sql = "
	update	wm_commande_plv
	set		plv				= '$v_plv'
	where	login_site		= '$login'
	and		num_plv			= $v_num_plv
	and		num_commande	= $id_commande";
	$statement = $pdo_instance->prepare($req_upd_sql);
	$statement->execute() or  die('<br> Erreur sql f_modification_commande - 4');
	
}

}

}

// Cette fonction retourne l'id d'une commande en fonction de son num_plv
function f_retourne_id_commande ($login, $num_plv) {

//include('inc/start_connexion.php');

// Recuperation de l id du client en fonction de son nom
$req_sql = "
select	max(num_commande) num_commande
from	wm_commande_plv 
where	login_site		= '$login'
and		num_plv			= $num_plv";


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam('num_plv', $num_plv, PDO::PARAM_INT);
$statement->bindParam('login', $login, PDO::PARAM_STR);

$statement->execute() or die('');
$tab_res = $statement->fetch(PDO::FETCH_ASSOC);

if ($tab_res['num_commande'] > 0) {
	return $tab_res['num_commande'];
}
else {
	return 0;
}


}

// Cette fonction retourne l'id du tiers en fonction de son nom et de son login
function f_retourne_id_tiers ($login, $nom_tiers) {

//include('inc/start_connexion.php');

// Recuperation de l id du client en fonction de son nom
$req_sql = "
select	max(num_tiers) num_tiers
from	wm_ref_tiers 
where	nom_tiers_code	= :nom_tiers
and		login_site		= :login
and		nom_tiers		is not null 
and		nom_tiers		!= 'A RENSEIGNER'
and		tiers_visible	= 'O'";

//echo '<br><br>' .$req_sql. '<br><br>';

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login, 'nom_tiers'=> $nom_tiers]);
$tab_res = $statement->fetch(PDO::FETCH_NUM);



if ($tab_res['num_tiers'] > 0) {
	return $tab_res['num_tiers'];
}
else {
	return 0;
}

//include('inc/end_connexion.php');

}

// fonction qui recupere les infos d une commande cote client ----------------------------------------------
function f_affiche_commande_client_1($login, $id_commande) {

//include('inc/start_connexion.php');

$req_sql ="
select	num_commande,
		commande_date,
		type_commande,
		etat_commande,
		livraison_date,
		livraison_h_debut,
		livraison_h_fin,
		commentaire,
		date_modification,
		date_insertion,
		livraison_adr_flag,
		livraison_adr
from    wm_client_commande
where   login_site		= :login
and		num_commande	= :id_commande";

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->bindParam("id_commande", $id_commande, PDO::PARAM_INT);

  $statement->execute() or die('<br> Erreur sql f_affiche_commande_client_1');


$tab_res = $statement->fetch(PDO::FETCH_NUM);
return $tab_res;

//include('inc/end_connexion.php');

}

// fonction qui recupere les infos d une commande cote client ----------------------------------------------
function f_affiche_commande_client_2($login, $id_commande) {

//include('inc/start_connexion.php');

$req_sql ="
select	c.nom_tiers_code nom_client
from    wm_client_commande  cc,
		wm_ref_tiers		c
where   cc.login_site       = :login
and		cc.num_commande		= :id_commande
and     cc.num_tiers        = c.num_tiers
and     cc.login_site		= c.login_site";


  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->bindParam("id_commande", $id_commande, PDO::PARAM_INT);
  
  $statement->execute() or die('<br> Erreur sql f_affiche_commande_client_2 ');
  $ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne;

//include('inc/end_connexion.php');

}

// fonction qui recupere les infos d une commande cote commande ----------------------------------------------
function f_affiche_commande_client_3($login, $id_commande) {

//include('inc/start_connexion.php');

$req_sql ="
select	f.nom_tiers_code			nom_fournisseur,
		c.produit,
		c.quantite,
		c.prix_ht,
		c.commission		divers
from    wm_commande			c,
		wm_ref_tiers		f
where   c.login_site       = :login
and		c.num_commande		= :id_commande
and     c.id_fournisseur    = f.num_tiers
and     c.login_site		= f.login_site
order by f.nom_tiers_code, produit";
$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->bindParam("id_commande", $id_commande, PDO::PARAM_INT);
  
  $statement->execute() or die('<br> Erreur sql f_affiche_commande_client_3 ');
  $ligne = $statement->fetch(PDO::FETCH_NUM);

return $ligne;

//include('inc/end_connexion.php');

}

// fonction qui annule 1 commande ----------------------------------------------
function f_annuler_commande($login, $num_commande) {

//include('inc/start_connexion.php');

$req_upd_sql ="
update	wm_client_commande
set		etat_commande		= 'A',
		date_modification	= CURRENT_TIMESTAMP,
		commande_visible	= 'N'
where	login_site		= :login
and		num_commande	= :num_commande";



$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_upd_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);
$statement->bindParam('num_commande', $num_commande, PDO::PARAM_INT); 

$tab = $statement->execute() or die('<br> Erreur sql f_annuler_commande');

//include('inc/end_connexion.php');

}

// fonction qui valide 1 devis ----------------------------------------------
function f_valider_devis($login, $num_commande) {

//include('inc/start_connexion.php');

$req_upd_sql ="
update	wm_client_commande
set		etat_commande		= 'E',
		date_modification	= CURRENT_TIMESTAMP,
		type_commande		= 'C'
where	login_site			= :login
and		num_commande		= :num_commande";
		


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_upd_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);
$statement->bindParam('num_commande', $num_commande, PDO::PARAM_INT); 

$tab = $statement->execute() or die('<br> Erreur sql f_valider_devis');

//include('inc/end_connexion.php');

}

// fonction qui teste si une commande est ok, si ok retourne 0 ---------------------------------
function f_test_commande_ok($login, $num_commande) {

$result = 0;

// Calcul du nb de lignes PLV
$nb_lignes_plv = f_calcul_nb_plv_commande($num_commande, $login);

//include('inc/start_connexion.php');

// TEST que tout est ok dans la table wm_client_commande
$req_sql ="
select	sum(case flag_ok when 'O' then 0 else 1 end) flag_ok
from	wm_client_commande
where	login_site		= :login
and 	num_commande	= :num_commande";

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);

  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->execute() or die('<br> Erreur sql f_test_commande_ok - 1 ');
  $ligne = $statement->fetch(PDO::FETCH_NUM);

$result = $ligne [0];

// TEST que tout est ok dans la table wm_commande
$req_sql ="
select	sum(case flag_ok when 'O' then 0 else 1 end) flag_ok
from	wm_commande
where	login_site		= :login
and 	num_commande	= :num_commande";

$statement = $pdo_instance->prepare($req_sql);

$statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);

  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->execute() or die('<br> Erreur sql f_test_commande_ok - 2 ');
  $ligne = $statement->fetch(PDO::FETCH_NUM);

$result = $result + $ligne [0];

// TEST que la table PLV est ok
$req_sql = "
select	ifnull(count(distinct num_plv), 0) nb_lignes
from	wm_commande_plv
where	login_site		= :login
and		num_commande	= :num_commande
and		etat			= 'A'";

$statement = $pdo_instance->prepare($req_sql);

$statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);

  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->execute() or die('<br> Erreur sql f_test_commande_ok - 3 ');
  $ligne = $statement->fetch(PDO::FETCH_NUM);




// Il faut que le nb de fournisseurs soit egal au nb de plv et qu'au moins une ligne dans PLV existe
if ($ligne [0] != $nb_lignes_plv or $nb_lignes_plv == 0) {
$result = $result + 1;
}

// Si retourne 0 alors tout est ok, sinon il manque des infos
return $result;

//include('inc/end_connexion.php');

}

// fonction qui supprime les donnees PLV qui n'ont plus lieu d'exister --------------
function f_supprime_plv($login, $num_commande) {

//include('inc/start_connexion.php');

$req_del_sql ="
delete from	wm_commande_plv
where		num_commande	= :num_commande
and			login_site		= :login
and			etat			= 'A'
and			id_fournisseur	not in (	select distinct id_fournisseur 
										from			wm_commande
										where			num_commande	= :num_commande
										and				login_site		= :login
										and				flag_ok			= 'O')";



$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_del_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);
$statement->bindParam('num_commande', $num_commande, PDO::PARAM_INT); 

$tab = $statement->execute()  or die('<br> Erreur sql f_supprime_plv');


}

// fonction qui ajoute les donnees PLV ---------------------------------
function f_ajoute_plv($login, $num_commande) {

//include('inc/start_connexion.php');

$req_ins_sql ="
insert into wm_commande_plv (
login_site, num_commande, id_fournisseur, plv, etat, date_insertion, date_modification)
select distinct	:login, 
				:num_commande,
				id_fournisseur,
				'',
				'A',
				CURRENT_TIMESTAMP, 
				CURRENT_TIMESTAMP
from			wm_commande			c,
				wm_client_commande	cc
where			c.num_commande		= :num_commande
and				c.login_site		= :login
and				c.login_site		= cc.login_site
and				c.num_commande		= cc.num_commande
and				cc.etat_commande	= 'E'
and				cc.commande_visible	= 'O'
and				c.id_fournisseur	not in (	select distinct id_fournisseur 
												from			wm_commande_plv 
												where			num_commande	= :num_commande
												and				login_site		= :login)";
	

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_ins_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);
$statement->bindParam('num_commande', $num_commande, PDO::PARAM_INT); 
												
$tab = $statement->execute()  or die('<br> Erreur sql f_ajoute_plv');

//include('inc/end_connexion.php');

}

// Fonction qui affiche les donnees plv pour une commande
function f_affiche_plv($login, $num_commande, $color_title) {

//include('inc/start_connexion.php');

$req_sql ="
select	p.num_plv,
		p.id_fournisseur,
		f.nom_tiers_code,
		p.plv,
		p.date_envoi
from	wm_commande_plv	p,
		wm_ref_tiers	f
where	p.num_commande		= :num_commande
and		p.login_site		= :login
and		p.login_site		= f.login_site
and		p.id_fournisseur	= f.num_tiers";

$i = 0;

echo '<br>';
echo '<table class=style_form1 width=100% align=center>';
echo '<tr>';
echo '<td align=center bgcolor='.$color_title.' width=5%> N� PLV </td>';
echo '<td align=center bgcolor='.$color_title.' width=5%> N� Fournisseur </td>';
echo '<td align=center bgcolor='.$color_title.' width=30%> Nom fournisseur </td>';
echo '<td align=center bgcolor='.$color_title.' width=30%> PLV </td>';
echo '<td align=center bgcolor='.$color_title.' width=10%> Envoyer </td>';
echo '<td align=center bgcolor='.$color_title.' width=10%> PDF </td>';
echo '<td align=center bgcolor='.$color_title.' width=10%> Date envoi </td>';
echo '</tr>';


$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam('login', $login, PDO::PARAM_STR);

  $statement->bindParam('num_commande', $num_commande, PDO::PARAM_STR);
  $statement->execute() or die('<br> Erreur sql f_affiche_plv');

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {
	
	$i=$i+1;
	
	for ($j = 0; $j < count($ligne); $j++) {
		if ($j == 0) { $v_num_plv = $ligne[$j]; }
		if ($j == 1) { $v_id_fournisseur = $ligne[$j]; }
		if ($j == 2) { $v_nom_tiers = $ligne[$j]; }
		if ($j == 3) { $v_plv = $ligne[$j]; }
		if ($j == 4) { $v_date_envoi = $ligne[$j]; }
	}
	
	if ($v_date_envoi != '') { $v_date_envoi = NormalDate_heure_min($v_date_envoi); }
	
	$n_num_plv			= 'num_plv_' . $i ;
	$n_id_fournisseur	= 'id_fournisseur_' . $i ;
	$n_nom_tiers		= 'nom_tiers_' . $i ;
	$n_plv				= 'plv_' . $i ;
	$n_date_envoi		= 'date_envoi_' . $i ;
	
	$url_plv='wm_accueil.php?menu_=n_a&action_=commande&num_commande='.$num_commande.'&num_plv_='.$v_num_plv;
	$url_plv_pdf='wm_accueil.php?menu_=n_a&action_=commande&num_commande='.$num_commande.'&num_plv_pdf='.$v_num_plv;
	
	echo '<tr>';
	echo "<td align=center> <input type=text style='width: 40px; height: 15px;'	 value=$v_num_plv	disabled=disabled> <input type=hidden name=$n_num_plv value=$v_num_plv> </td>";
	echo "<td align=center> <input type=text name=$n_id_fournisseur style='width: 40px; height: 15px;'	 value=$v_id_fournisseur	disabled=disabled> </td>";
	echo "<td align=center> <input type=text name=$n_nom_tiers		style='width: 360px; height: 15px;'	 value='$v_nom_tiers'		disabled=disabled> </td>";
	echo "<td align=center> <input type=text name=$n_plv			style='width: 450px; height: 15px;'	 value='$v_plv'> </td>";
	echo "<td align=center> <span onClick=document.location='" . $url_plv . "'; style=cursor:pointer> Envoyer </span> </td>";
	echo "<td align=center> <span onClick=document.location='" . $url_plv_pdf . "'; style=cursor:pointer> PDF </span> </td>";
	echo "<td align=center> <input type=text name=$n_date_envoi		style='width: 100px; height: 15px;'	 value='$v_date_envoi'		disabled=disabled> </td>";
	echo '</tr>';
	
}
echo '</table>';
echo '<br>';



}

// Fonction qui renvoie le nb de fournisseur pour une commande
function f_calcul_nb_plv_commande ($num_commande, $login) {

$req_sql = "
select	ifnull(count(distinct id_fournisseur), 0) nb_lignes
from	wm_commande
where	login_site		= :login
and		num_commande	= :num_commande
and		flag_ok			= 'O'";

//include('inc/start_connexion.php');

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);

  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->execute();

  $ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne[0];

//include('inc/end_connexion.php');

}

// fonction qui Supprime les lignes non ok dans une commande ----------------------------------------------
function f_epurer_commande($login, $num_commande) {

//include('inc/start_connexion.php');

$req_del_sql ="
delete	from wm_commande
where	login_site		= :login
and		num_commande	= :num_commande
and		flag_ok			= 'N'";

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_del_sql);
  $statement->bindParam('login', $login, PDO::PARAM_STR);

  $statement->bindParam('num_commande', $num_commande, PDO::PARAM_STR);
  $statement->execute() or die('<br> Erreur sql f_epurer_commande');

$nb_fournisseurs = f_calcul_nb_plv_commande($num_commande, $login);

// Suppression des fournisseurs qui n'existent plus
f_supprime_plv($login, $num_commande);

}

// Fonction qui renvoie l'etat pour une commande
function f_calcul_etat_commande ($num_commande, $login) {

$req_sql = "
select	etat_commande
from	wm_client_commande
where	login_site		= :login
and		num_commande	= :num_commande";

//include('inc/start_connexion.php');
$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);
  

$statement->execute() or die('<br> Erreur sql f_calcul_etat_commande');
$ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne[0];

//include('inc/end_connexion.php');

}

// Fonction qui envoi la commande au client
function f_envoyer_commande_client ($login, $num_commande, $color_title, $style) {

f_epurer_commande($login, $num_commande);

//$adr_facturation = f_retourne_adr_livraison_client ($login, $num_commande);
$adr_livraison = f_retourne_adr_livraison_client ($login, $num_commande);

// Recuperation des informations de la commande et du client
$req_sql = "
select	cc.num_tiers,
		cc.commande_date,
		cc.type_commande,
		cc.etat_commande,
		cc.livraison_date,
		cc.livraison_h_debut,
		cc.livraison_h_fin,
		cc.commentaire,
		c.nom_tiers,
		c.nom_contact_1,
		c.mail_contact_1,
		c.adr_facturation_1,
		c.adr_facturation_2,
		c.adr_facturation_cp,
		c.adr_facturation_ville,
		c.adr_livraison_1,
		c.adr_livraison_2,
		c.adr_livraison_cp,
		c.adr_livraison_ville,
		c.mail_contact_2
from	wm_client_commande	cc,
		wm_ref_tiers		c
where	cc.login_site		= :login
and		cc.num_commande		= :num_commande
and		cc.login_site		= c.login_site
and		cc.num_tiers		= c.num_tiers";


  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);
 
  $statement->execute() or die('<br> Erreur sql f_envoyer_commande_client - 1');
  $ligne =  $statement->fetch(PDO::FETCH_NUM);

$num_tiers				= $ligne[0];
$commande_date			= $ligne[1];
$type_commande			= $ligne[2];
$etat_commande			= $ligne[3];
$livraison_date			= NormalDate($ligne[4]);
$livraison_h_debut		= $ligne[5];
$livraison_h_fin		= $ligne[6];
$commentaire			= $ligne[7];
$nom_tiers				= $ligne[8];
$nom_contact_1			= $ligne[9];
$mail_contact_1			= $ligne[10];
$adr_facturation_1		= $ligne[11];
$adr_facturation_2		= $ligne[12];
$adr_facturation_cp		= $ligne[13];
$adr_facturation_ville	= $ligne[14];
$adr_livraison_1		= $ligne[15];
$adr_livraison_2		= $ligne[16];
$adr_livraison_cp		= $ligne[17];
$adr_livraison_ville	= $ligne[18];
$mail_contact_2			= $ligne[19];

//$sujet="$cpt_nom_tiers commande - $num_commande";

$sujet="$nom_tiers commande - $num_commande";

// Recuperation des informations du compte
$req_sql = "
select	nom,
		prenom,
		adresse1,
		adresse2,
		cp,
		ville,
		num_siret,
		num_tva,
		e_mail,
		tel_fixe,
		tel_mobile,
		nom_tiers,
		ifnull(e_mail_1, '') e_mail_1,
		ifnull(e_mail_2, '') e_mail_2
from	ref_comptes
where	login = :login";


$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute(['login' => $login]) or die('<br> Erreur sql f_envoyer_commande_client - 2');
  $ligne = $statement->fetch(PDO::FETCH_NUM);

$cpt_nom			= $ligne[0];
$cpt_prenom			= $ligne[1];
$cpt_adresse1		= $ligne[2];
$cpt_adresse2		= $ligne[3];
$cpt_cp				= $ligne[4];
$cpt_ville			= $ligne[5];
$cpt_num_siret		= $ligne[6];
$cpt_num_tva		= $ligne[7];
$cpt_e_mail			= $ligne[8];
$cpt_tel_fixe		= $ligne[9];
$cpt_tel_mobile		= $ligne[10];
$cpt_nom_tiers		= $ligne[11];
$e_mail_1			= $ligne[12];
$e_mail_2			= $ligne[13];

/*
if (trim($adr_livraison_2)=='') { $adr_livraison_2 = '<br>'; } else { $adr_livraison_2 = '<br>' . $adr_livraison_2 . '<br>' ; }
if (trim($cpt_adresse2)=='') { $cpt_adresse2 = '<br>'; } else { $cpt_adresse2 = '<br>' . $cpt_adresse2 . '<br>' ; }
if (strlen(trim($commentaire))>0) { $commentaire = '<br>Commentaire : '.$commentaire.'<br>'; } else {  $commentaire = '<br><br>';   }

$adr_livraison		= $adr_livraison_1 . $adr_livraison_2 . $adr_livraison_cp . ' ' . $adr_livraison_ville;
$cpt_adresse		= $cpt_adresse1 . $cpt_adresse2 . $cpt_cp . ' ' . $cpt_ville;
*/

if (trim($adr_facturation_2)=='') { $adr_facturation_2 = '<br>'; } else { $adr_facturation_2 = '<br>' . $adr_facturation_2 . '<br>' ; }
if (trim($cpt_adresse2)=='') { $cpt_adresse2 = '<br>'; } else { $cpt_adresse2 = '<br>' . $cpt_adresse2 . '<br>' ; }

$adr_facturation	= $adr_facturation_1 . $adr_facturation_2 . $adr_facturation_cp . ' ' . $adr_facturation_ville;
$cpt_adresse		= $cpt_adresse1 . $cpt_adresse2 . $cpt_cp . ' ' . $cpt_ville;


$destinataire			= '';

// Gestion des mails pour le client
// Cas les 2 mails sont renseignes
if (trim($mail_contact_1) != '' and trim($mail_contact_2) != '') { $destinataire = '<'.$mail_contact_1.'>,<'.$mail_contact_2.'>'; }
// Cas o� uniquement le mail 1 est renseign�
if (trim($mail_contact_1) != '' and trim($mail_contact_2) == '') { $destinataire = '<'.$mail_contact_1.'>'; }
// Cas o� uniquement le mail 2 est renseign�
if (trim($mail_contact_1) == '' and trim($mail_contact_2) != '') { $destinataire = '<'.$mail_contact_2.'>'; }


if (trim($e_mail_1) != '') { $destinataire .= ', <'.$e_mail_1.'>'; }
if (trim($e_mail_2) != '') { $destinataire .= ', <'.$e_mail_2.'>'; }

$boundary = md5(uniqid(microtime(), TRUE));

// Headers
$headers = 'From: '.$cpt_nom.' '.$cpt_prenom.' <contact@winemanager.fr>'."\r\n";
$headers .= 'Reply-To: '.$cpt_e_mail."\r\n";
$headers .= 'Bcc: '.$cpt_nom.' '.$cpt_prenom.' <'.$cpt_e_mail.'>'."\r\n";
$headers .= 'Mime-Version: 1.0'."\r\n";
$headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
$headers .= "\r\n";
 
// Message
$contenu_mail = 'Texte affich� par des clients mail ne supportant pas le type MIME.'."\r\n\r\n";

// Message HTML
$contenu_mail .= '--'.$boundary."\r\n";
$contenu_mail .= 'Content-type: text/html; charset=utf-8'."\r\n\r\n";
 
$contenu_mail .= "
<table class=$style>
<tr>
<td>
Bonjour $nom_contact_1,<br><br>
</td>
</tr>
<tr><td>
<br>
Veuillez trouver ci joint le r�capitulatif de votre commande n&ordm;$num_commande : <br><br>
</td></tr>

<tr>
<td align=center bgcolor=$color_title> Information de livraison </td>
</tr>
<tr> 
<td> Date de la livraison : $livraison_date Entre $livraison_h_debut et $livraison_h_fin  
<br><br>
</td> 
</tr>

<tr><td>
<table width=90% align=left class=$style><tr>
<td align=center bgcolor=$color_title> Adresse de livraison </td>
<td align=center bgcolor=$color_title> Adresse de facturation </td>
</tr>
<tr> 
<td> $adr_livraison </td> 
<td> $adr_facturation </td> 
</tr>
</table>
</td></tr>
<tr><td> $commentaire </td></tr>
</table>";

$req_sql ="
select	f.nom_tiers,
		p.plv
from	wm_commande_plv	p,
		wm_ref_tiers	f
where	p.num_commande		= :num_commande
and		p.login_site		= :login
and		p.login_site		= f.login_site
and		p.id_fournisseur	= f.num_tiers";

$contenu_plv = "
<br>
<table width=90% align=left class=$style><tr>
<td align=center bgcolor=$color_title width=40%> Nom fournisseur </td>
<td align=center bgcolor=$color_title width=60%> PLV </td>
</tr>";


$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam('num_commande', $num_commande, PDO::PARAM_INT);
  $statement->bindParam('login', $login, PDO::PARAM_STR);
   
  $statement->execute();

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {
	for ($j = 0; $j < count($ligne); $j++) {
		$v_nom_tiers	= $ligne[0];
		$v_plv			= $ligne[1];
	}
	$contenu_plv = $contenu_plv . "<tr> <td align=left> $v_nom_tiers </td> <td align=left> $v_plv </td> </tr>";
}
$contenu_plv = $contenu_plv . '</table><br><br>';

// Contenu facture
$req_sql ="
select	f.nom_tiers,
		c.produit,
		c.quantite,
		c.prix_ht,
		round(c.quantite * c.prix_ht,2) total_ligne_ht
from	wm_commande		c,
		wm_ref_tiers	f
where	c.num_commande		= :num_commande
and		c.login_site		= :login
and		c.login_site		= f.login_site
and		c.id_fournisseur	= f.num_tiers";

$contenu_commande = "
<br><br>
<table width=90% align=left class=$style><tr>
<td align=center bgcolor=$color_title > Nom fournisseur </td>
<td align=center bgcolor=$color_title > Produit </td>
<td align=center bgcolor=$color_title > Quantite </td>
<td align=center bgcolor=$color_title > Prix HT </td>
<td align=center bgcolor=$color_title > Total </td>
</tr>";

$total_facture_ht = 0;


$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);
$statement->bindParam("login", $login, PDO::PARAM_STR);
$statement->execute() or die('<br> Erreur sql f_envoyer_commande_client - 3');

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {

	for ($j = 0; $j < count($ligne); $j++) {
		$v_fournisseur	= $ligne[0];
		$v_produit		= $ligne[1];
		$v_quantite		= $ligne[2];
		$v_prix_ht		= $ligne[3];
		$v_ligne_total	= $ligne[4];
	}
	$total_facture_ht = $total_facture_ht + $v_ligne_total;
	$contenu_commande = $contenu_commande . "
	<tr> 
	<td align=left> $v_fournisseur </td> 
	<td align=left> $v_produit </td> 
	<td align=right> $v_quantite </td> 
	<td align=right> $v_prix_ht </td> 
	<td align=right> $v_ligne_total </td> 
	</tr>";
}
$contenu_commande = $contenu_commande . "
<tr>
<td bgcolor=$color_title colspan=4 align=right> TOTAL HT </td>
<td bgcolor=$color_title align=right> $total_facture_ht </td>
</table><br><br>";

//include('inc/end_connexion.php');

$pied_de_page = f_retourne_pied_de_mail($login);

$contenu_pied_page= "
<table class=$style>
<tr><td>
Bonne r�ception <br><br>
Cordialement <br><br>
$pied_de_page
</td></tr>
</table>";

$contenu_mail = $contenu_mail . $contenu_plv . $contenu_commande . $contenu_pied_page;

$contenu_mail = f_transforme_caractere_html($contenu_mail, 'html');



//// ENVOI AU CLIENT
if (mail($destinataire,$sujet,$contenu_mail,$headers)) {
		
	// Modification de la date d'envoi
	$req_sql ="
	update	wm_client_commande
	set		date_envoi				= CURRENT_TIMESTAMP,
			date_modification		= CURRENT_TIMESTAMP
	where	num_commande			= :num_commande
	and		login_site				= :login";

	
	$pdo_instance = SPDO::getInstance();
	$statement = $pdo_instance->prepare($req_sql);
	$statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);
	$statement->bindParam("login", $login, PDO::PARAM_STR);

	$statement->execute() or die('<br> Erreur sql f_envoyer_commande_client - 4');
	return 0;
}
else {
	return 1;
}

}

// Fonction qui envoie au fournisseur concern� les informations PLV -------------------------------------------------------------
function f_envoi_plv ($num_plv, $login, $color_title, $style) {

$num_commande=f_retourne_id_commande($login, $num_plv);
f_epurer_commande($login, $num_commande);
$adr_livraison=f_retourne_adr_livraison_client ($login, $num_commande);
$pied_de_page = f_retourne_pied_de_mail($login);
$cellpadding=3;
$nbsp_='';
$nbsp_4='';

// Recuperation des informations de la commande et du client
$req_sql = "
select	cc.num_tiers,
		cc.commande_date,
		cc.type_commande,
		cc.etat_commande,
		ifnull(cc.livraison_date, '01/01/1900') livraison_date,
		cc.livraison_h_debut,
		cc.livraison_h_fin,
		cc.commentaire,
		c.nom_tiers,
		c.nom_contact_1,
		c.mail_contact_1,
		c.adr_facturation_1,
		c.adr_facturation_2,
		c.adr_facturation_cp,
		c.adr_facturation_ville,
		c.adr_livraison_1,
		c.adr_livraison_2,
		c.adr_livraison_cp,
		c.adr_livraison_ville,
		f.nom_tiers				nom_fournisseur,
		f.mail_contact_1		mail_1_fournisseur,
		f.mail_contact_2		mail_2_fournisseur,
		f.nom_contact_1			nom_1_fournisseur,
		f.nom_contact_2			nom_2_fournisseur,
		f.adr_livraison_1		adr_1_fournisseur,
		f.adr_livraison_2		adr_1_fournisseur,
		f.adr_livraison_cp		adr_cp_fournisseur,
		f.adr_livraison_ville	adr_ville_fournisseur,
		p.num_commande,
		c.num_siret,
		c.num_tva,
		c.telephone_livraison,
		f.flag_envoi_pdf
from	wm_client_commande	cc,
		wm_ref_tiers		c,
		wm_commande_plv		p,
		wm_ref_tiers		f
where	cc.login_site		= :login
and		cc.login_site		= c.login_site
and		cc.login_site		= p.login_site
and		cc.num_tiers		= c.num_tiers
and		cc.num_commande		= p.num_commande
and		p.num_plv			= :num_plv
and		p.id_fournisseur	= f.num_tiers";



$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);

$statement->bindParam('num_plv', $num_plv, PDO::PARAM_INT);
  $statement->execute() or die('<br> Erreur sql f_envoi_plv - 1');

$ligne = $statement->fetch(PDO::FETCH_NUM);


$num_tiers				= $ligne[0];
$commande_date			= $ligne[1];
$type_commande			= $ligne[2];
$etat_commande			= $ligne[3];
$livraison_date			= NormalDate($ligne[4]);
$livraison_h_debut		= $ligne[5];
$livraison_h_fin		= $ligne[6];
$commentaire			= $ligne[7];
$nom_tiers				= $ligne[8];
$nom_contact_1			= $ligne[9];
$mail_contact_1			= $ligne[10];
$adr_facturation_1		= $ligne[11];
$adr_facturation_2		= $ligne[12];
$adr_facturation_cp		= $ligne[13];
$adr_facturation_ville	= $ligne[14];
$adr_livraison_1		= $ligne[15];
$adr_livraison_2		= $ligne[16];
$adr_livraison_cp		= $ligne[17];
$adr_livraison_ville	= $ligne[18];
$num_siret				= $ligne[29];
$num_tva				= $ligne[30];
$telephone_livraison	= $ligne[31];

$nom_fournisseur		= $ligne[19];
$mail_1_fournisseur		= $ligne[20];
$mail_2_fournisseur		= $ligne[21];
$nom_1_fournisseur		= $ligne[22];
$nom_2_fournisseur		= $ligne[23];
$adr_1_fournisseur		= $ligne[24];
$adr_1_fournisseur		= $ligne[25];
$adr_cp_fournisseur		= $ligne[26];
$adr_ville_fournisseur	= $ligne[27];
$flag_envoi_pdf			= $ligne[32];

// Recuperation des informations du compte
$req_sql = "
select	nom,
		prenom,
		adresse1,
		adresse2,
		cp,
		ville,
		num_siret,
		num_tva,
		e_mail,
		tel_fixe,
		tel_mobile,
		nom_tiers,
		ifnull(e_mail_1, '') e_mail_1,
		ifnull(e_mail_2, '') e_mail_2
from	ref_comptes
where	login = :login";



$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login])or die('<br> Erreur sql f_envoi_plv - 2');
 
$ligne = $statement->fetch(PDO::FETCH_NUM);

$cpt_nom			= $ligne[0];
$cpt_prenom			= $ligne[1];
$cpt_adresse1		= $ligne[2];
$cpt_adresse2		= $ligne[3];
$cpt_cp				= $ligne[4];
$cpt_ville			= $ligne[5];
$cpt_num_siret		= $ligne[6];
$cpt_num_tva		= $ligne[7];
$cpt_e_mail			= $ligne[8];
$cpt_tel_fixe		= $ligne[9];
$cpt_tel_mobile		= $ligne[10];
$cpt_nom_tiers		= $ligne[11];
$e_mail_1			= $ligne[12];
$e_mail_2			= $ligne[13];

if (trim($adr_facturation_2)=='') { $adr_facturation_2 = '<br>'; } else { $adr_facturation_2 = '<br>' . $adr_facturation_2 . '<br>' ; }
if (trim($cpt_adresse2)=='') { $cpt_adresse2 = '<br>'; } else { $cpt_adresse2 = '<br>' . $cpt_adresse2 . '<br>' ; }

$adr_facturation	= $adr_facturation_1 . $adr_facturation_2 . $adr_facturation_cp . ' ' . $adr_facturation_ville;
$cpt_adresse		= $cpt_adresse1 . $cpt_adresse2 . $cpt_cp . ' ' . $cpt_ville;

$destinataire = '';

// Gestion des mails pour le client
// Cas o� les 2 mails sont renseign�s
if (trim($mail_1_fournisseur) != '' and trim($mail_2_fournisseur) != '') { $destinataire = '<'.$mail_1_fournisseur.'>,<'.$mail_2_fournisseur.'>'; }
// Cas o� uniquement le mail 1 est renseign�
if (trim($mail_1_fournisseur) != '' and trim($mail_2_fournisseur) == '') { $destinataire = '<'.$mail_1_fournisseur.'>'; }
// Cas o� uniquement le mail 2 est renseign�
if (trim($mail_1_fournisseur) == '' and trim($mail_2_fournisseur) != '') { $destinataire = '<'.$mail_2_fournisseur.'>'; }


//if (trim($cpt_e_mail) != '') { $destinataire .= ', <'.$cpt_e_mail.'>'; }
if (trim($e_mail_1) != '') { $destinataire .= ', <'.$e_mail_1.'>'; }
if (trim($e_mail_2) != '') { $destinataire .= ', <'.$e_mail_2.'>'; }


$sujet="$cpt_nom_tiers commande n�$num_commande-$num_plv";

$boundary = md5(uniqid(microtime(), TRUE));

// Headers
$headers = 'From: '.$cpt_nom.' '.$cpt_prenom.' <contact@winemanager.fr>'."\r\n";
$headers .= 'Reply-To: '.$cpt_e_mail."\r\n";
//$headers .= 'Bcc: '.$cpt_nom.' '.$cpt_prenom.' <'.$cpt_e_mail.'>'."\r\n";
$headers .= 'Mime-Version: 1.0'."\r\n";
$headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
$headers .= "\r\n";

$contenu_pied_page= "
<table class=$style>
<tr><td>
<br><br>
Bonne r&eacute;ception <br><br>
Cordialement <br><br>
$pied_de_page
</td></tr>
</table>";

// GESTION DU CONTENU DU MAIL --------------------------------------------------------------

if ($flag_envoi_pdf == 'O') {       // SI ON ENVOIE LE MAIL EN PDF
	$nbsp_='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$nbsp_4='&nbsp;&nbsp;&nbsp;&nbsp;';
	
	$contenu_mail = '<page> '."\r\n\r\n"; 
	$contenu_mail .= "
	<table class=$style>
	<tr><td><br><br>
	$pied_de_page
	</td></tr>
	</table>
	<table width=100% class=$style>
	<tr>
	<td>
	<br><br>";
}
else {								// SI != ON ENVOIE LE MAIL EN PDF
	$contenu_mail = 'Texte affich� par des clients mail ne supportant pas le type MIME.'."\r\n\r\n";
	// Message HTML
	$contenu_mail .= '--'.$boundary."\r\n";
	$contenu_mail .= 'Content-type: text/html; charset=utf-8'."\r\n\r\n";
	$contenu_mail .= "
	<table width=100% class=$style>
	<tr>
	<td>
	Bonjour, <br><br>";
}

if ($info_livraison == '01/01/1900') { $info_livraison = 'Date de la livraison : Non defini'; }
else { $info_livraison = "Date de la livraison : $livraison_date entre $livraison_h_debut et $livraison_h_fin"; }

$contenu_mail .= "
<table width=100% align=left class=$style cellpadding=$cellpadding>
<tr>
<td bgcolor=$color_title colspan=2>$nbsp_ Veuillez trouver ci dessous les informations pour la livraison du client : $nbsp_</td>
</tr>
<tr>
<td bgcolor=$color_title width=20%> Nom du client $nbsp_</td>
<td width=80%> $nom_tiers </td>
</tr>
<tr>
<td bgcolor=$color_title> Nom du contact </td>
<td> $nom_contact_1 </td>
</tr>
<tr>
<td bgcolor=$color_title> T&eacute;l&eacute;phone </td>
<td> $telephone_livraison </td>
</tr>
<tr>
<td bgcolor=$color_title> SIRET </td>
<td> $num_siret </td>
</tr>
<tr>
<td bgcolor=$color_title> TVA </td>
<td> $num_tva </td>
</tr>
</table>
<br><br>

<table width=100% align=left class=$style cellpadding=$cellpadding>
<tr>
<td align=center bgcolor=$color_title>$nbsp_ Information de livraison $nbsp_</td>
</tr>
<tr> 
<td> $info_livraison</td> 
</tr>
</table>

 <br><br>

<table width=100% align=left class=$style cellpadding=$cellpadding>
<tr>
<td align=center bgcolor=$color_title> Information compl&eacute;mentaire $nbsp_</td>
</tr>
<tr> 
<td> $commentaire  </td> 
</tr>
</table>
<br><br>

</td>
</tr>
<tr><td>
<table width=100% align=left class=$style cellpadding=$cellpadding><tr>
<td align=center bgcolor=$color_title> Adresse de livraison $nbsp_ </td>
<td align=center bgcolor=$color_title> Adresse de facturation $nbsp_ </td>
</tr>
<tr> 
<td> $adr_livraison </td> 
<td> $adr_facturation  </td> 
</tr>
</table>
</td></tr>
<tr><td>
<br>
Veuillez trouver ci joint le r&eacute;capitulatif de la commande n&ordm;$num_commande-$num_plv : <br>
</td></tr></table>";

$contenu_plv = "
<br>
<table width=100% align=left class=$style cellpadding=$cellpadding><tr>
<td align=center bgcolor=$color_title width=40%> $nbsp_ Nom fournisseur $nbsp_</td>
<td align=center bgcolor=$color_title width=60%> $nbsp_ PLV $nbsp_</td>
</tr>";

$req_sql ="
select	f.nom_tiers,
		p.plv
from	wm_commande_plv	p,
		wm_ref_tiers	f
where	p.num_plv			= :num_plv
and		p.login_site		= :login
and		p.login_site		= f.login_site
and		p.id_fournisseur	= f.num_tiers";



  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('num_plv', $num_plv, PDO::PARAM_INT);
  $statement->execute() or die('<br> Erreur sql f_envoyer_commande_client - 3');

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {
	for ($j = 0; $j < count($ligne); $j++) {
		$v_nom_tiers	= $ligne[0];
		$v_plv			= $ligne[1];
	}
	$contenu_plv = $contenu_plv . "<tr> <td align=left> $v_nom_tiers </td> <td align=left> $v_plv </td> </tr>";
}
$contenu_plv = $contenu_plv . '</table><br><br>';

$contenu_commande = "
<br><br>
<table width=100% align=left class=$style cellpadding=$cellpadding>		
<tr>
<td align=center bgcolor=$color_title width=30%> Produit $nbsp_	$nbsp_	</td>
<td align=center bgcolor=$color_title width=10%> $nbsp_4 Quantit&eacute; 		</td>
<td align=center bgcolor=$color_title width=15%> $nbsp_4 Prix HT 		</td>
<td align=center bgcolor=$color_title width=15%> $nbsp_ Total 			</td>
<td align=center bgcolor=$color_title width=15%> $nbsp_4 % Com. 			</td>
<td align=center bgcolor=$color_title width=15%> $nbsp_4 Montant Com. 	</td>
</tr>";

// Contenu facture
$req_sql ="
select	f.nom_tiers,
		c.produit,
		c.quantite,
		c.prix_ht,
		round(c.quantite * c.prix_ht, 2) total_ligne_ht,
		c.commission pct_commission,
		round(c.quantite * c.prix_ht * c.commission / 100, 2) total_ligne_ht_com
from	wm_commande		c,
		wm_ref_tiers	f,
		wm_commande_plv	p
where	p.num_plv			= :num_plv
and		p.num_commande		= c.num_commande
and		p.login_site		= :login
and		p.login_site		= c.login_site
and		c.login_site		= f.login_site
and		c.id_fournisseur	= f.num_tiers
and		p.id_fournisseur	= c.id_fournisseur";

$statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('num_plv', $num_plv, PDO::PARAM_INT);
  $statement->execute() or die('<br> Erreur sql f_envoi_plv - 3');


$total_facture_ht	= 0;
$total_facture_com	= 0;

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {

	for ($j = 0; $j < count($ligne); $j++) {
		$v_produit				= $ligne[1];
		$v_quantite				= $ligne[2];
		$v_prix_ht				= $ligne[3];
		$v_ligne_total			= $ligne[4];
		$v_pct_commission		= $ligne[5];
		$v_total_ligne_ht_com	= $ligne[6];
	}
	$total_facture_ht	= $total_facture_ht		+ $v_ligne_total;
	$total_facture_com	= $total_facture_com	+ $v_total_ligne_ht_com;
	
	$contenu_commande = $contenu_commande . "
	<tr> 
	<td align=left> $v_produit </td> 
	<td align=right> $v_quantite </td> 
	<td align=right> $v_prix_ht </td> 
	<td align=right> $v_ligne_total </td> 
	<td align=right> $v_pct_commission% </td> 
	<td align=right> $v_total_ligne_ht_com </td> 
	</tr>";
}

$total_facture_ht = round($total_facture_ht,2);
$total_facture_com = round($total_facture_com,2);
$contenu_commande = $contenu_commande . "
<tr>
<td bgcolor=$color_title colspan=3 align=right> TOTAL HT </td>
<td bgcolor=$color_title align=right> $total_facture_ht </td>
<td bgcolor=$color_title align=right> <br> </td>
<td bgcolor=$color_title align=right> $total_facture_com </td>
</tr>
</table><br><br>";

//include('inc/end_connexion.php');

if ($flag_envoi_pdf == 'O') { 
	$contenu_mail =  $contenu_mail . $contenu_plv . $contenu_commande;
	$contenu_mail .= ' </page>'; 
}
else {
	$contenu_mail = $contenu_mail . $contenu_plv . $contenu_commande . $contenu_pied_page;
}

if ($flag_envoi_pdf == 'O') { // Gestion de l'envoi du bon de commande en PDF
	
	$chemin = 'inc_pdf/';
	$filename = date('Ymd') . '_' .  $num_commande . '_' . $num_plv . '.pdf';

$contenu_mail = f_transforme_caractere_html($contenu_mail, 'html');
	
	f_enregistre_pdf($contenu_mail, 'P', $filename, $chemin) ;
	
	//$filename = $chemin . $filename;
	$limite = "_parties_".md5(uniqid (rand())); 

	$headers = 'From: '.$cpt_nom.' '.$cpt_prenom.' <contact@winemanager.fr>'."\r\n";
	$headers .= 'Reply-To: '.$cpt_e_mail."\r\n";
	$headers .= 'Bcc: '.$cpt_nom.' '.$cpt_prenom.' <'.$cpt_e_mail.'>'."\r\n";
	$headers .= "Date: ".date("l j F Y, G:i")."\n"; 
	$headers .= 'Mime-Version: 1.0'."\r\n";
	$headers .= "Content-Type: multipart/mixed;\n"; 
	$headers .= " boundary=\"----=$limite\"\n\n"; 
	$headers .= "\r\n";

	//Le message en texte simple pour les navigateurs qui n'acceptent pas le HTML 
	$contenu_mail = "This is a multi-part message in MIME format. \r\n"; 
	$contenu_mail .= "Ceci est un message est au format MIME. \r\n"; 
	$contenu_mail .= "------=$limite \r\n"; 
	$contenu_mail .= "Content-Type: text/html; charset=\"iso-8859-1\" \r\n"; 
	$contenu_mail .= "Content-Transfer-Encoding: 7bit\n\n"; 
	$contenu_mail .= 'Bonjour,<br><br>';
	$contenu_mail .= 'Veuillez trouver en piece jointe le bon de commande. <br>';
	$contenu_mail .= 'Vous en souhaitant bonne reception.<br><br>';
	$contenu_mail .= 'Cordialement<br><br>';
	$contenu_mail .= '-----------------------------------------------';
	$contenu_mail .= $pied_de_page;
	$contenu_mail .= "\n\n"; 
  
	//le fichier 
	$attachement = "------=$limite\n"; 
	$attachement .= "Content-Type:'application/pdf'; name=\"$filename\"\n"; 
	$attachement .= "Content-Transfer-Encoding: base64\n"; 
	$attachement .= "Content-Disposition: attachment; filename=\"$filename\"\n\n"; 
  
	$fd = fopen( $chemin . $filename, "r" ); 
	$contenu = fread( $fd, filesize( $chemin . $filename ) ); 
	fclose( $fd ); 
	$attachement .= chunk_split(base64_encode($contenu)); 

	$attachement .= "\n\n\n------=$limite\n";

	$contenu_mail =  $contenu_mail . $attachement;
	
	unlink($chemin . $filename);

}

$contenu_mail = f_transforme_caractere_html($contenu_mail, 'html');
//$headers = f_transforme_caractere_html($headers);

/*
$contenu_mail = str_replace('�','&eacute;', $contenu_mail);
$contenu_mail = str_replace('�','&egrave;', $contenu_mail);
$contenu_mail = str_replace('�','&ecirc;', $contenu_mail);
$contenu_mail = str_replace('�','&agrave;', $contenu_mail);
$contenu_mail = str_replace('�','&ugrave;', $contenu_mail);
$contenu_mail = str_replace('�','&ccedil;', $contenu_mail);
$contenu_mail = str_replace('�','&ucirc;', $contenu_mail);
*/

$headers = str_replace('�','e', $headers);
$headers = str_replace('�','e', $headers);
$headers = str_replace('�','e', $headers);
$headers = str_replace('�','a', $headers);
$headers = str_replace('�','u', $headers);
$headers = str_replace('�','c', $headers);
$headers = str_replace('�','u', $headers);

// ENVOI AU FOURNISSEUR
if ( mail('contact@winemanager.fr',$sujet,$contenu_mail,$headers) ) {
	
	$destinataire = '<' . $_SESSION['e_mail'] . '>';
	
	if (trim($mail_1_fournisseur) != '') { $destinataire .= ', <' . $mail_1_fournisseur . '>' ; }
	if (trim($mail_2_fournisseur) != '') { $destinataire .= ', <' . $mail_2_fournisseur . '>' ; }
	if (trim($e_mail_1) != '')           { $destinataire .= ', <' . $e_mail_1 . '>' ; }
	if (trim($e_mail_2) != '')           { $destinataire .= ', <' . $e_mail_2 . '>' ; }
	
	mail($destinataire,$sujet,$contenu_mail,$headers);
	
	// Modification de la date d'envoi
	$req_sql ="
	update	wm_commande_plv
	set		date_envoi				= CURRENT_TIMESTAMP,
			date_modification		= CURRENT_TIMESTAMP
	where	num_plv					= :num_plv
	and		login_site				= :login";

	//include('inc/start_connexion.php');
	
$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam("num_plv", $num_plv, PDO::PARAM_INT);

$statement->bindParam("login", $login, PDO::PARAM_STR);
$statement->execute() or die('<br> Erreur sql f_envoi_plv - 4');

	// Modification du statut de la commande
	$req_sql ="
	select	count(distinct num_plv) nb_plv
	from	wm_commande_plv
	where	num_commande			= :num_commande
	and		login_site				= :login";
	$statement = $pdo_instance->prepare($req_sql);
	$statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);

	$statement->bindParam("login", $login, PDO::PARAM_STR);
	
	$statement->execute() or die('<br> Erreur sql f_envoi_plv - 5');
	
	$ligne = $statement->fetch(PDO::FETCH_NUM);

	$nb_plv = $ligne[0];

	$req_sql ="
	select	count(distinct num_plv) nb_plv
	from	wm_commande_plv
	where	num_commande			= :num_commande
	and		login_site				= :login
	and		date_envoi				is not null";

	$statement = $pdo_instance->prepare($req_sql);
	$statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);

	$statement->bindParam("login", $login, PDO::PARAM_STR);
	
	$statement->execute() or die('<br> Erreur sql f_envoi_plv - 6');
	
	$ligne = $statement->fetch(PDO::FETCH_NUM);

	$nb_plv_envoye = $ligne[0];

	if ($nb_plv_envoye == $nb_plv) {

		$req_sql ="
		update	wm_client_commande
		set		date_modification		= CURRENT_TIMESTAMP,
				etat_commande			= 'T'
		where	num_commande			= :num_commande
		and		login_site				= :login";

		$statement = $pdo_instance->prepare($req_sql);
		$statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);
	
		$statement->bindParam("login", $login, PDO::PARAM_STR);
		
		$statement->execute() or die('<br> Erreur sql f_envoi_plv - 7');

	}
		
	return 0;
}
else {
	return 1;
}

}

// Fonction qui renvoie le total ht pour une commande ---------------------------------------------------
function f_calcul_montant_ht_commande ($num_commande, $login) {

$req_sql = "
select	round(sum(ifnull(quantite*prix_ht,0)),2) total_facture
from	wm_commande
where	login_site		= :login
and		num_commande	= :num_commande
and		flag_ok			= 'O'";

//include('inc/start_connexion.php');

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);
  $statement->bindParam("login", $login, PDO::PARAM_STR);

  $statement->execute() or die('<br> Erreur sql f_calcul_montant_ht_commande');

	
$ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne[0];


}

// Fonction qui renvoie la derni�re date d'envoi au client pour une commande ---------------------------------------------------
function f_calcul_date_envoi_commande ($num_commande, $login) {

$req_sql = "
select	ifnull(date_envoi,'0000-00-00 00:00:00') date_envoi
from	wm_client_commande
where	login_site		= :login
and		num_commande	= :num_commande";

//include('inc/start_connexion.php');

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);
  $statement->bindParam("login", $login, PDO::PARAM_STR);

  $statement->execute() or die('<br> Erreur sql f_calcul_date_envoi_commande');



$ligne  = $statement->fetch(PDO::FETCH_NUM);
return $ligne[0];

//include('inc/end_connexion.php');

}

// Fonction qui renvoie la commission/ca/rang/nb_bouteilles/ca_moy/com_moy pour un client ----------------------------------
function f_calcul_stat_commande_client ($num_tiers, $flag_client_fournisseur, $login, $annee) {

if ($flag_client_fournisseur == 'C') {
	$req_sql = "
	select @a:=@a+1 rang, t.num_tiers, t.annee, t.ca, t.com, t.nb_bouteilles, t.nb_commandes, t.ca_moy_commande, t.com_moy_commande
	from  (select	date_format(cc.commande_date , '%Y' )												annee, 
					cc.num_tiers,
					sum(round(c.quantite*c.prix_ht,2))													ca,
					sum(round(c.quantite*c.prix_ht*commission/100, 2))									com,
					sum(c.quantite)																		nb_bouteilles,
					count(distinct cc.num_commande)														nb_commandes,
					round(sum(c.quantite*c.prix_ht)/count(distinct cc.num_commande),2)					ca_moy_commande,
					round(sum(c.quantite*c.prix_ht*commission/100)/count(distinct cc.num_commande),2)	com_moy_commande
			from	wm_commande			c,
					wm_client_commande	cc
			where	c.num_commande							= cc.num_commande
			and		cc.etat_commande						= 'T'
			and		c.login_site							= cc.login_site
			and		c.login_site							= :login
			and		date_format(cc.commande_date , '%Y' )	= :annee
			group by date_format(cc.commande_date , '%Y' ), cc.num_tiers
			order by 3 DESC) t
	order by 1";
}

if ($flag_client_fournisseur == 'F') {
	$req_sql = "
	select @a:=@a+1 rang, t.num_tiers, t.annee, t.ca, t.com, t.nb_bouteilles, t.nb_commandes, t.ca_moy_commande, t.com_moy_commande
	from  (select	date_format(cc.commande_date , '%Y' )												annee, 
					c.id_fournisseur																	num_tiers,
					sum(round(c.quantite*c.prix_ht,2))													ca,
					sum(round(c.quantite*c.prix_ht*commission/100, 2))									com,
					sum(c.quantite)																		nb_bouteilles,
					count(distinct c.num_commande)														nb_commandes,
					round(sum(c.quantite*c.prix_ht)/count(distinct cc.num_commande),2)					ca_moy_commande,
					round(sum(c.quantite*c.prix_ht*commission/100)/count(distinct cc.num_commande),2)	com_moy_commande
			from	wm_commande			c,
					wm_client_commande	cc
			where	c.num_commande							= cc.num_commande
			and		cc.etat_commande						= 'T'
			and		c.login_site							= cc.login_site
			and		c.login_site							= :login
			and		date_format(cc.commande_date , '%Y' )	= :annee
			group by date_format(cc.commande_date , '%Y' ), c.id_fournisseur
			order by 3 DESC) t
	order by 1";
}

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare('SET @a := 0');
  $statement->execute() or die('<br> Erreur sql f_calcul_stat_commande_client - 1');

$statement = $pdo_instance->prepare($req_sql);

$res_sql = $statement->execute(['login' => $login, 'annee' => $annee]) or die('<br> Erreur sql f_calcul_stat_commande_client - 2');

while ($ligne = $statement->fetch(PDO::FETCH_ASSOC)) {

	for ($j = 0; $j < count($ligne); $j++) {
		$v_rang					= $ligne[0];
		$v_num_tiers			= $ligne[1];
		$v_annee				= $ligne[2];
		$v_ca					= $ligne[3];
		$v_com					= $ligne[4];
		$v_nb_bouteilles		= $ligne[5];
		$v_nb_commandes			= $ligne[6];
		$v_ca_moy_commande		= $ligne[7];
		$v_com_moy_commande		= $ligne[8];
		
	}
	//echo '<br> ' . $v_rang . ' - ' . $v_num_tiers . ' - ' . $v_annee . ' - ' . $v_ca . ' - ' . $v_com . ' - ' . $v_nb_bouteilles . ' - ' . $v_nb_commandes . ' - ' . $v_ca_moy_commande . ' - ' . $v_com_moy_commande ; 
	if ($v_num_tiers == $num_tiers) { return $ligne; }
	
}

//include('inc/end_connexion.php');

}

// Fonction qui affiche un tableau de stat client ou fournisseur
function f_affiche_stat_commande ($login, $flag_client_fournisseur, $flag_total, $annee) {

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }

$order_query='order by ' . $id_col . ' ' . $sens_req;

if ($flag_client_fournisseur == 'F') {	
	if ($flag_total == 'N') {
		$req_sql = " 
		select		c.id_fournisseur																	num_fournisseur,
					f.nom_tiers																			Fournisseur,
					date_format(cc.commande_date , '%Y' )												Annee, 
					sum(round(c.quantite*c.prix_ht,2))													CA,
					sum(round(c.quantite*c.prix_ht*commission/100, 2))									'Comm.',
					sum(c.quantite)																		'Quantite',
					count(distinct c.num_commande)														'Nb Commandes',
					round(sum(c.quantite*c.prix_ht)/count(distinct cc.num_commande),2)					'Moy CA',
					round(sum(c.quantite*c.prix_ht*commission/100)/count(distinct cc.num_commande),2)	'Moy Comm.'
		from		wm_client_commande	cc,
					wm_commande			c,
					wm_ref_tiers		f
		where		date_format(cc.commande_date, '%Y' )	= $annee
		and			cc.num_commande							= c.num_commande
		and			cc.etat_commande						= 'T'
		and			cc.login_site							= '$login'
		and			cc.login_site							= c.login_site 
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.flag_ok								= 'O'
		group by	c.id_fournisseur,
					f.nom_tiers,
					date_format(cc.commande_date, '%Y' )
		$order_query" ;
	}
	
	if ($flag_total == 'Y') {
		$req_sql = " 
		select		'GLOBAL',
					sum(round(c.quantite*c.prix_ht,2))													CA,
					sum(round(c.quantite*c.prix_ht*commission/100, 2))									'Comm.',
					sum(c.quantite)																		'Quantit�',
					count(distinct c.num_commande)														'Nb Commandes',
					round(sum(c.quantite*c.prix_ht)/count(distinct cc.num_commande),2)					'Moy CA',
					round(sum(c.quantite*c.prix_ht*commission/100)/count(distinct cc.num_commande),2)	'Moy Comm.'
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= $annee
		and			c.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.flag_ok								= 'O'" ;
	}
}

if ($flag_client_fournisseur == 'C') {
	if ($flag_total == 'N') {
		$req_sql = " 
		select		cc.num_tiers																		num_client,
					f.nom_tiers																			Client,
					date_format(cc.commande_date , '%Y' )												Annee, 
					sum(round(c.quantite*c.prix_ht,2))													CA,
					sum(round(c.quantite*c.prix_ht*commission/100, 2))									'Comm.',
					sum(c.quantite)																		'Quantite',
					count(distinct c.num_commande)														'Nb Commandes',
					round(sum(c.quantite*c.prix_ht)/count(distinct cc.num_commande),2)					'Moy CA',
					round(sum(c.quantite*c.prix_ht*commission/100)/count(distinct cc.num_commande),2)	'Moy Comm.'
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		f
		where		c.num_commande = cc.num_commande
		and			cc.etat_commande = 'T'
		and			c.login_site = cc.login_site
		and			c.login_site = '$login'
		and			date_format(cc.commande_date , '%Y' ) = $annee
		and			c.login_site = f.login_site
		and			cc.num_tiers = f.num_tiers
		group by	cc.num_tiers,
					f.nom_tiers,
					date_format(cc.commande_date , '%Y' )
		$order_query" ;
	}
	
	if ($flag_total == 'Y') {
		$req_sql = " 
		select		'GLOBAL',
					sum(round(c.quantite*c.prix_ht,2))													CA,
					sum(round(c.quantite*c.prix_ht*commission/100, 2))									'Comm.',
					sum(c.quantite)																		'Quantite',
					count(distinct c.num_commande)														'Nb Commandes',
					round(sum(c.quantite*c.prix_ht)/count(distinct cc.num_commande),2)					'Moy CA',
					round(sum(c.quantite*c.prix_ht*commission/100)/count(distinct cc.num_commande),2)	'Moy Comm.'
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		f
		where		c.num_commande = cc.num_commande
		and			cc.etat_commande = 'T'
		and			c.login_site = cc.login_site
		and			c.login_site = '$login'
		and			date_format(cc.commande_date , '%Y' ) = $annee
		and			c.login_site = f.login_site
		and			cc.num_tiers = f.num_tiers" ;
	}
}

if ($flag_client_fournisseur == 'T') { // GLOBAL
	$req_sql = " 
	select		date_format(cc.commande_date , '%Y' )												Annee, 
				sum(round(c.quantite*c.prix_ht,2))													CA,
				sum(round(c.quantite*c.prix_ht*commission/100, 2))									'Comm.',
				sum(c.quantite)																		'Quantite',
				count(distinct c.num_commande)														'Nb Commandes',
				round(sum(c.quantite*c.prix_ht)/count(distinct cc.num_commande),2)					'Moy CA',
				round(sum(c.quantite*c.prix_ht*commission/100)/count(distinct cc.num_commande),2)	'Moy Comm.'
	from		wm_commande			c,
				wm_client_commande	cc
	where		c.num_commande = cc.num_commande
	and			cc.etat_commande = 'T'
	and			c.login_site = cc.login_site
	and			c.login_site = '$login'
	group by	date_format(cc.commande_date , '%Y' )
	$order_query" ;
}

if ($flag_client_fournisseur == 'TM') { // GLOBAL
	$req_sql = " 
	select		date_format(cc.commande_date , '%Y-%m' )											'Annee - Mois', 
				sum(round(c.quantite*c.prix_ht,2))													CA,
				sum(round(c.quantite*c.prix_ht*commission/100, 2))									'Comm.',
				sum(c.quantite)																		'Quantite',
				count(distinct c.num_commande)														'Nb Commandes',
				round(sum(c.quantite*c.prix_ht)/count(distinct cc.num_commande),2)					'Moy CA',
				round(sum(c.quantite*c.prix_ht*commission/100)/count(distinct cc.num_commande),2)	'Moy Comm.'
	from		wm_commande			c,
				wm_client_commande	cc
	where		c.num_commande = cc.num_commande
	and			cc.etat_commande = 'T'
	and			c.login_site = cc.login_site
	and			c.login_site = '$login'
	group by	date_format(cc.commande_date , '%Y-%m' )
	$order_query" ;
}

//include('inc/start_connexion.php');


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$res_sql =   $statement->execute() or die('<br> Erreur sql f_affiche_stat_commande');

if ($flag_total == 'N') {
// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='30';
$tab_size[2]='10';
$tab_size[3]='10';
$tab_size[4]='10';
$tab_size[5]='10';
$tab_size[6]='10';
$tab_size[7]='10';
$tab_size[8]='10';
$tab_size[9]='0';
}
if ($flag_total == 'Y') {
// % du size du tableau
$tab_size[0]='40';
$tab_size[1]='10';
$tab_size[2]='10';
$tab_size[3]='10';
$tab_size[4]='10';
$tab_size[5]='10';
$tab_size[6]='10';
$tab_size[7]='0';
}

if ($flag_total == 'N') { f_affiche_tableau($res_sql, $tab_size); }
if ($flag_total == 'Y') { f_affiche_tableau_global($res_sql, $tab_size); }

//include('inc/end_connexion.php');

}

// fonction affiche la liste de tous les utilisateurs de l'application (admin only) ----------------------------------------------
function f_affiche_liste_comptes ($login) {

//include('inc/start_connexion.php');

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col']+1 ; } else { $id_col=1; }
if($id_col > 9) { $id_col=1; }

$order_query='order by ' . $id_col . ' ' . $sens_req;

$req_sql = " 
select	login
from	ref_comptes 
where	login		= '$login' 
and		flag_admin	= 'O'";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login]) or die('<br> Erreur sql f_affiche_liste_comptes - 1');
$ligne = $statement->fetch(PDO::FETCH_NUM);

$login_adm = $ligne [0];

if ($login_adm == $login) {

$req_sql = " 
select	r.login																'Compte',
		concat(r.nom, ' ', r.prenom)										'Nom Prenom', 
 		nom_tiers															'Societe', 
		date_format( r.dat_cre, '%Y-%m-%d' )								'Date cr�ation',
		date_format( r.dat_upd, '%Y-%m-%d' )								'Date modification',
		date_format( r.begin_date, '%Y-%m-%d' )								'Date Debut',
		date_format( r.end_date, '%Y-%m-%d' )								'Date Fin',
		(select date_format( max(c.stamp_date), '%Y-%m-%d %H:%i' ) from tb_connection c where r.login = c.login) 'Derni&egrave;re connexion',
		(select count(*) from tb_connection c where r.login = c.login)		'Nb Connexion'
from	ref_comptes r
$order_query" ;

$statement = $pdo_instance->prepare($req_sql);
$statement->execute() or die('<br> Erreur sql f_affiche_liste_comptes - 2');

// % du size du tableau
$tab_size[0]='11'; // Compte
$tab_size[1]='15'; // Nom Prenom
$tab_size[2]='20'; // Societe
$tab_size[3]='10'; // date creation
$tab_size[4]='10'; // date update
$tab_size[5]='5'; // date deb
$tab_size[6]='5'; // date fin 
$tab_size[7]='12'; // date derniere connexion
$tab_size[8]='5'; // nb connexion

f_affiche_tableau($res_sql, $tab_size);

}

//include('inc/end_connexion.php');

}

// fonction qui modifie les dates de d�but et de fin d'un compte (admin only) ----------------------------------------------------
function f_modification_compte_date ($login, $tab_mod) {

//include('inc/start_connexion.php');

$dat_deb	= trim($tab_mod['v_dat_deb']);
$dat_fin	= trim($tab_mod['v_dat_fin']);

$req_sql ="
update	ref_comptes
set		begin_date	= :dat_deb,
		end_date	= :dat_fin,
		dat_upd		= CURRENT_TIMESTAMP
where	login		= :login";


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login, 'dat_deb'=> $dat_deb, 'dat_fin' => $dat_fin]) or die('<br> Erreur sql f_modification_compte_date');
		

}

// fonction qui re-initialise un mot de passe pour un compte ou mail et envoi par mail un nouveau mot de passe -------------------
function f_mot_de_passe_oublie ($login) {

//include('inc/start_connexion.php');

$req_sql = " 
select	login, e_mail
from	ref_comptes 
where	login		= :login 
or		e_mail		= :login";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);

$statement->execute(['login' => $login]) or die('<br> Erreur sql f_mot_de_passe_oublie - 1');
$ligne = $statement->fetch(PDO::FETCH_NUM);

$login_ = $ligne [0];
$mail_	= $ligne [1];

if ($login_ == $login) { // l'utilisateur est connu dans la base, on peut donc lui envoyer un mail

	$_new_passwd_ = substr(md5(rand()), 2, 8);
	$_new_passwd_md5 = md5($_new_passwd_);

	$req_sql ="
	update	ref_comptes
	set		mdp			= :new_passwd_md5,
			dat_upd		= CURRENT_TIMESTAMP
	where	login		= :login";



	$pdo_instance = SPDO::getInstance();
	$statement = $pdo_instance->prepare($req_sql);
	$statement->execute(['login' => $login_, 'new_passwd_md5' => $_new_passwd_md5]) or die('<br> Erreur sql f_mot_de_passe_oublie - 2');
	
	// Envoi du mail a l'utilisateur sur son compte.
	
	$destinataire='<'.$mail_.'>';

	$sujet="WINE MANAGER : nouveau mot de passe";

	$boundary = md5(uniqid(microtime(), TRUE));

	// Headers
	//$headers = 'From: <contact@winemanager.fr>'."\r\n";
	$headers = 'From: Contact WineManager <contact@winemanager.fr>'."\r\n";

	$headers .= 'Reply-To: <contact@winemanager.fr>'."\r\n";
	$headers .= 'Mime-Version: 1.0'."\r\n";
	$headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
	$headers .= "\r\n";
 
	// Message
	$contenu_mail = 'Texte affich� par des clients mail ne supportant pas le type MIME.'."\r\n\r\n";
	 
	// Message HTML
	$contenu_mail .= '--'.$boundary."\r\n";
	$contenu_mail .= 'Content-type: text/html; charset=utf-8'."\r\n\r\n";

	$contenu_mail .= "
	<table width=100% class=$style>
	<tr>
	<td>
	Bonjour, <br>
	Veuillez trouver ci dessous votre nouveau mot de passe pour le site www.winemanager.fr : <br>
	$_new_passwd_
	<br><br><br>
	Pensez � le changer � votre prochaine connexion.
	<br><br>
	</td>
	</tr></table>";
	
	//include('inc/end_connexion.php');

	$contenu_mail = f_transforme_caractere_html($contenu_mail, 'html');
	/*
	$contenu_mail = str_replace('�','&eacute;', $contenu_mail);
	$contenu_mail = str_replace('�','&egrave;', $contenu_mail);
	$contenu_mail = str_replace('�','&ecirc;', $contenu_mail);
	$contenu_mail = str_replace('�','&agrave;', $contenu_mail);
	$contenu_mail = str_replace('�','&ugrave;', $contenu_mail);
	$contenu_mail = str_replace('�','&ccedil;', $contenu_mail);
	$contenu_mail = str_replace('�','&ucirc;', $contenu_mail);
	*/
	
	if (mail($destinataire,$sujet,$contenu_mail,$headers)) {
		return "Un mail vient de vous �tre envoy�.";
	}
	else {
		return "Un probl�me est survenu lors de l'envoi du mail.";
	}
}
else {
		return "Votre compte n'existe pas.";
}

//include('inc/end_connexion.php');
}

// Fonction qui affiche les commandes termin�es pour un fournisseur --------------------
function f_affiche_liste_commande_fournisseurs ($num_client, $login) {

//include('inc/start_connexion.php');

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='DESC'; }

if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }
//if ($id_col>7) {$id_col=3;}

$order_query='order by ' . $id_col . ' ' . $sens_req;

// Gestion du titre -----------
$req_sql = "
select    nom_tiers, flag_fournisseur_client
from    wm_ref_tiers       t
where    login_site    = :login
and        num_tiers     = :num_client";


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam("login", $login, PDO::PARAM_STR);
$statement->bindParam("num_client", $num_client, PDO::PARAM_INT);


$statement->execute() or die('<br> Erreur sql f_affiche_liste_commande_fournisseurs - 1');

$ligne = $statement->fetch(PDO::FETCH_NUM);
$nom_client = $ligne[0];
$flag_fournisseur_client = $ligne[1];

if ($flag_fournisseur_client == 'C') { $flag_fournisseur_client = 'client'; } else { $flag_fournisseur_client = 'fournisseur'; }
$url_='wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client='.$num_client;
$lien = "<span onClick=document.location='" . $url_ . "'; style=cursor:pointer> $nom_client </span>";
$titre = 'Commandes du ' . $flag_fournisseur_client . ' : ' . $lien;

$nom_champ3 = 'Commande';
$nom_champ4 = 'PLV';

// Gestion du tableau -----------
$req_sql = "
select    c.num_tiers            num_client,
        c.num_commande        num_commande,
        p.num_plv            num_plv,
		c.num_commande        :nom_champ3,
        date_format(c.commande_date,'%Y-%m-%d')    'Date de commande',
        t.nom_tiers            'Client',
        round(sum(co.quantite*co.prix_ht),2) 'Montant HT',
        round(sum(co.quantite*co.prix_ht*co.commission)/100, 2) 'Commission',
        date_format(c.date_modification,'%Y-%m-%d')    'Date de modification'
from    wm_client_commande    c,
        wm_ref_tiers        t,
        wm_commande_plv        p,
        wm_commande            co
where    c.login_site        = :login
and     c.login_site        = t.login_site
and     c.login_site        = p.login_site
and     c.num_tiers         = t.num_tiers
and        c.type_commande     = 'C'
and        c.etat_commande     = 'T'
and        p.id_fournisseur    = :num_client
and        c.num_commande        = p.num_commande
and        p.login_site        = co.login_site
and        p.id_fournisseur    = co.id_fournisseur
and        p.num_commande        = co.num_commande
group by    c.num_tiers,
            c.num_commande,
            p.num_plv,
            c.num_commande,
            p.num_plv,
            date_format(c.commande_date,'%Y-%m-%d'),
            t.nom_tiers,
            date_format(c.date_modification,'%Y-%m-%d')
$order_query";

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='0';
$tab_size[2]='0';
$tab_size[3]='10';
$tab_size[4]='10';
$tab_size[5]='40';
$tab_size[6]='15';
$tab_size[7]='15';
$tab_size[8]='10';


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindColumn('nom_champ3', $nom_champ3, PDO::PARAM_STR);
$statement->bindColumn('login', $login, PDO::PARAM_STR);
$statement->bindColumn('num_client', $num_client, PDO::PARAM_INT);
  
$statement->execute() or die('<br> Erreur sql f_affiche_liste_commande_fournisseurs - 2');

// Affichage du tableau
echo '<table width=100% cellpadding=0 align=center border=0 class=style_form_1>';
echo '<tr>';
echo '<td> <br><br><br> </td>';
echo '</tr>';
echo '<tr>';
echo '<td bgcolor=#B3B3B3 class=titre2> '.$titre .'</td>';
echo '</tr>';
echo '<tr>';
echo '<td> <br> </td>';
echo '</tr>';
echo '</table>';

f_affiche_tableau($statement, $tab_size);


}

// Fonction d'envoi de mail de contact 
function f_envoi_mail_contact ($e_mail_ , $nom_prenom_ , $mobile_ , $message_) {

$destinataire='tocutx@yahoo.fr';
$sujet="WINE MANAGER : demande d'information";

$boundary = md5(uniqid(microtime(), TRUE));

$nom_prenom_ = f_transforme_caractere_html($nom_prenom_, '');

// Headers
//$headers = 'From: '.$nom_prenom_.' <'.$e_mail_.'>'."\r\n";
$headers = 'From: Contact WineManager <contact@winemanager.fr>'."\r\n";
$headers .= 'Reply-To: '.$e_mail_."\r\n";
$headers .= 'Mime-Version: 1.0'."\r\n";
$headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
$headers .= "\r\n";
 
// Message
$contenu_mail = 'Texte affich� par des clients mail ne supportant pas le type MIME.'."\r\n\r\n";
 
// Message HTML
$contenu_mail .= '--'.$boundary."\r\n";
$contenu_mail .= 'Content-type: text/html; charset=utf-8'."\r\n\r\n";

$contenu_mail .= $message_ . '<br><br> ________________________ <br> Tel : ' . $mobile_ . ' <br> ' . $nom_prenom_;

$contenu_mail = f_transforme_caractere_html($contenu_mail, 'html');

/*
$contenu_mail = str_replace('�','&eacute;', $contenu_mail);
$contenu_mail = str_replace('�','&egrave;', $contenu_mail);
$contenu_mail = str_replace('�','&ecirc;', $contenu_mail);
$contenu_mail = str_replace('�','&agrave;', $contenu_mail);
$contenu_mail = str_replace('�','&ugrave;', $contenu_mail);
$contenu_mail = str_replace('�','&ccedil;', $contenu_mail);
$contenu_mail = str_replace('�','&ucirc;', $contenu_mail);
*/

if (mail($destinataire,$sujet,$contenu_mail,$headers)) {
	return 0;
}
else {
	return 1;
}

}

// fonction qui affiche la liste des fournisseurs - produit dans une liste d�roulante d'un formulaire -----------------------
function f_form_affiche_liste_fournisseurs_produit ($login, $premiere_ligne) {

echo '<option>' . $premiere_ligne . '</option>';

//include('inc/start_connexion.php');

$req_sql = "
select	concat(f.nom_tiers_code, ' - ', p.nom_produit) fournisseurs_prod
from	wm_ref_tiers	f,
		wm_produit		p
where	f.login_site				= :login
and		f.tiers_visible				= 'O'
and     f.flag_fournisseur_client	= 'F'
and		f.num_tiers					= p.id_fournisseur
and		f.login_site				= p.login
and		p.produit_visible			= 'O'
and		trim(concat(f.nom_tiers_code, ' - ', p.nom_produit))	!= trim(:premiere_ligne)
order by 1";

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute(['login' => $login, 'premiere_ligne'=> $premiere_ligne]) or die('<br> Erreur sql f_form_affiche_liste_fournisseurs_produit');

while ($tab_res = $statement->fetch(PDO::FETCH_NUM)) {
      echo '<option>' . $tab_res[0]. '</option>';
}

}

// Fonction qui affiche les commandes termin�es pour un fournisseur --------------------
function f_affiche_n_dernieres_commandes ($login, $nb_lignes) {


if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }
//$order_query='order by ' . $id_col . ' ' . $sens_req;

$req_sql = " 
select	cc.num_commande,
		cc.num_tiers num_client,
		cc.num_commande 'Commande',
		case cc.etat_commande when 'T' then 'Termin&eacute;e' when 'A' then 'Annul&eacute;e' when 'E' then 'En cours' when 'V' then 'Valid&eacute;e' else '' end Etat,
		case cc.type_commande when 'C' then 'Commande' when 'D' then 'Devis' else '' end Type,
		date_format(cc.commande_date,'%d/%m/%Y') 'Date',
		c.nom_tiers 'Client'
from	wm_client_commande	cc,
		wm_ref_tiers		c
where	cc.login_site	= :login
and		cc.login_site	= c.login_site
and		cc.num_tiers	= c.num_tiers
order by cc.date_insertion desc
limit 0, :nb_lignes";


  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql) or die('<br> Erreur de test');
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('nb_lignes', $nb_lignes, PDO::PARAM_INT);
  $statement->execute();
  
  
// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='0';
$tab_size[2]='10';
$tab_size[3]='15';
$tab_size[4]='15';
$tab_size[5]='15';
$tab_size[6]='45';

f_affiche_tableau($statement, $tab_size, );

////include('inc/end_connexion.php');

}

// Fonction qui affiche le top des n meilleurs clients en commission depuis la date d'entree en reference --------------------
function f_affiche_n_top_client_fournisseur_periode ($login, $nb_clients, $date_debut, $flag_client_fournisseur) {

//include('inc/start_connexion.php');

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }
//$order_query='order by ' . $id_col . ' ' . $sens_req;

if ($flag_client_fournisseur == 'C') {
	$req_sql = " 
	select	cc.num_tiers num_client,
			c.nom_tiers Client,
			round(sum(co.quantite*co.prix_ht*co.commission/100),2) Commission
	from	wm_client_commande	cc,
			wm_ref_tiers		c,
			wm_commande			co
	where	cc.login_site		= :login
	and		cc.login_site		= c.login_site
	and		cc.num_tiers		= c.num_tiers
	and		cc.login_site		= co.login_site
	and		cc.etat_commande	= 'T'
	and		cc.type_commande	= 'C'
	and		cc.commande_date	>= :date_debut
	and		cc.num_commande		= co.num_commande
	and		co.flag_ok			= 'O'
	group by	cc.num_tiers,
				c.nom_tiers
	order by 3 desc
	limit 0, :nb_clients";
}

if ($flag_client_fournisseur == 'F') {
	$req_sql = " 
	select	c.num_tiers num_fournisseur,
			c.nom_tiers Fournisseur,
			round(sum(co.quantite*co.prix_ht*co.commission/100),2) Commission
	from	wm_client_commande	cc,
			wm_ref_tiers		c,
			wm_commande			co
	where	cc.login_site		= :login
	and		cc.login_site		= c.login_site
	and		co.id_fournisseur	= c.num_tiers
	and		cc.login_site		= co.login_site
	and		cc.etat_commande	= 'T'
	and		cc.type_commande	= 'C'
	and		cc.commande_date	>= :date_debut
	and		cc.num_commande		= co.num_commande
	and		co.flag_ok			= 'O'
	group by	c.num_tiers,
				c.nom_tiers
	order by 3 desc
	limit 0, :nb_clients";
}

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql) or die('<br> Erreur de test');
  $statement->bindParam('date_debut', $date_debut, PDO::PARAM_STR);
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('nb_clients', $nb_clients, PDO::PARAM_INT);

  $statement->execute();
  


// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='80';
$tab_size[2]='20';

f_affiche_tableau($statement, $tab_size);

////include('inc/end_connexion.php');

}

// Fonction qui affiche le top client/fournisseur --------------------------------------------------------------------
function f_affiche_top_client_fournisseurs ($login, $id_tiers, $flag_clt_fou, $top, $annee) {

//include('inc/start_connexion.php');

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }

if ($flag_clt_fou == 'C') {
	
	$req_sql = " 
	select		count(distinct c.id_fournisseur)
	from		wm_client_commande	cc,
				wm_commande			c,
				wm_ref_tiers		f
	where		date_format(cc.commande_date, '%Y' )	= :annee
	and			cc.num_commande							= c.num_commande
	and			cc.etat_commande						= 'T'
	and			cc.login_site							= :login
	and			cc.login_site							= c.login_site 
	and			cc.login_site							= f.login_site
	and			c.id_fournisseur						= f.num_tiers
	and			c.flag_ok								= 'O'
	and			cc.num_tiers							= :id_tiers" ;
	
	$pdo_instance = SPDO::getInstance();
  	$statement = $pdo_instance->prepare($req_sql);
	$statement->bindParam("login", $login, PDO::PARAM_STR);

	$statement->bindParam("annee", $annee, PDO::PARAM_INT);
	$statement->bindParam("id_tiers", $id_tiers, PDO::PARAM_INT);

	
	$statement->execute() or die('<br> Erreur sql f_affiche_top_client_fournisseurs');
	$ligne = $statement->fetch(PDO::FETCH_NUM);
	$top_res	= $ligne[0];
	
	$limit = '';
	if ($top_res == 1) { $limit = ' limit 1'; }
	else if ($top_res > 1 and $top_res < $top) { $limit = ' limit 1, ' . $top_res; }
	else { $limit = ' limit 1, ' . $top; }
	
	$req_sql = " 
	select		c.id_fournisseur									num_fournisseur,
				f.nom_tiers											Fournisseur,
				sum(round(c.quantite*c.prix_ht*commission/100, 2))	'Comm.'
	from		wm_client_commande	cc,
				wm_commande			c,
				wm_ref_tiers		f
	where		date_format(cc.commande_date, '%Y' )	= :annee
	and			cc.num_commande							= c.num_commande
	and			cc.etat_commande						= 'T'
	and			cc.login_site							= :login
	and			cc.login_site							= c.login_site 
	and			cc.login_site							= f.login_site
	and			c.id_fournisseur						= f.num_tiers
	and			c.flag_ok								= 'O'
	and			cc.num_tiers							= :id_tiers
	group by	c.id_fournisseur,
				f.nom_tiers
	order by	3 DESC
	$limit
	" ;
}

if ($flag_clt_fou == 'F') {
	
	$req_sql = " 
	select		count(distinct f.num_tiers)
	from		wm_client_commande	cc,
				wm_commande			c,
				wm_ref_tiers		f
	where		date_format(cc.commande_date, '%Y' )	= :annee
	and			cc.num_commande							= c.num_commande
	and			cc.etat_commande						= 'T'
	and			cc.login_site							= :login
	and			cc.login_site							= c.login_site 
	and			cc.login_site							= f.login_site
	and			cc.num_tiers							= f.num_tiers
	and			c.flag_ok								= 'O'
	and			c.id_fournisseur						= :id_tiers" ;
	
	$pdo_instance = SPDO::getInstance();
  	$statement = $pdo_instance->prepare($req_sql);

	$statement->bindParam("login", $login, PDO::PARAM_STR);
	$statement->bindParam("annee", $annee, PDO::PARAM_INT);
	$statement->bindParam("id_tiers", $id_tiers, PDO::PARAM_INT);

	
	$statement->execute() or die('<br> Erreur sql f_affiche_top_client_fournisseurs');
	$ligne = $statement->fetch(PDO::FETCH_NUM);
	$top_res	= $ligne[0];
	
	$limit = '';
	if ($top_res == 1) { $limit = ' limit 1'; }
	else if ($top_res > 1 and $top_res < $top) { $limit = ' limit 1, ' . $top_res; }
	else { $limit = ' limit 1, ' . $top; }
	
	$req_sql = " 
	select		f.num_tiers											num_client,
				f.nom_tiers											Client,
				sum(round(c.quantite*c.prix_ht*commission/100, 2))	'Comm.'
	from		wm_client_commande	cc,
				wm_commande			c,
				wm_ref_tiers		f
	where		date_format(cc.commande_date, '%Y' )	= :annee
	and			cc.num_commande							= c.num_commande
	and			cc.etat_commande						= 'T'
	and			cc.login_site							= :login
	and			cc.login_site							= c.login_site 
	and			cc.login_site							= f.login_site
	and			cc.num_tiers							= f.num_tiers
	and			c.flag_ok								= 'O'
	and			c.id_fournisseur						= :id_tiers
	group by	f.nom_tiers
	order by	3 DESC
	$limit" ;
}

	$pdo_instance = SPDO::getInstance();
  	$statement = $pdo_instance->prepare($req_sql);
	$statement->bindParam("login", $login, PDO::PARAM_STR);

	$statement->bindParam("annee", $annee, PDO::PARAM_INT);
	$statement->bindParam("id_tiers", $id_tiers, PDO::PARAM_INT);

	
	$statement->execute() or die('<br> Erreur sql f_affiche_top_client_fournisseurs ');

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='80';
$tab_size[2]='20';

f_affiche_tableau($statement, $tab_size);


}

// Fonction qui verifie si un client/fournisseur/commande existe -------------------------------------------------------
// $type --> Ct:Client / Fr:Fournisseur / Ce: Commande
function f_verifie_info_ok ($login, $type, $id) {

//include('inc/start_connexion.php');

if ($type == 'Ct') {
	$req_sql = "
	select	ifnull(num_tiers, 0)        id_req
	from	wm_ref_tiers
	where	login_site				= :login
	and		num_tiers				= :id
	and		flag_fournisseur_client	= 'C'" ;
}

if ($type == 'Fr') {
	$req_sql = "
	select	ifnull(num_tiers, 0)	id_req
	from	wm_ref_tiers
	where	login_site				= :login
	and		num_tiers				= :id
	and		flag_fournisseur_client	= 'F'" ;
}

if ($type == 'Ce') {
    $req_sql = "
	select	ifnull(num_commande, 0)	id_req
	from	wm_client_commande
	where	login_site		= :login
	and		num_commande	= :id" ;
}

$pdo_instance = SPDO::getInstance();
$statement    = $pdo_instance->prepare($req_sql);
//$statement->bindParam("login", $login, PDO::PARAM_STR);
//$statement->bindParam("id", $id, PDO::PARAM_STR);


$res_sql	  = $statement->execute(['login' => $login, 'id' => $id]) or die('<br> Erreur sql f_verifie_info_ok');
$ligne		  = $statement->fetch(PDO::FETCH_NUM);
$res_req	  = $ligne[0];

//include('inc/end_connexion.php');

if ($res_req == 0) { return 1; }
else { return 0; }

}

// fonction qui epure les clients ----------------------------------------------
function f_epurer_client($login) {

////include('inc/start_connexion.php');

$pdo_instance = SPDO::getInstance();


$req_upd_sql ="
update	wm_ref_tiers
set		nom_tiers             = 'A RENSEIGNER',
		nom_tiers_code        = 'A RENSEIGNER',
		date_modification     = CURRENT_TIMESTAMP
where	login_site = :login
and		(nom_tiers is null or nom_tiers = '')";

$statement = $pdo_instance->prepare($req_upd_sql);
$statement->execute(['login' => $login]) or die('<br> Erreur sql f_epurer_client');



// Suppression des clients supprim�s par l'utilisateur qui n'a pas de commandes
$req_del_sql ="
delete from wm_ref_tiers 
where login_site    = '$login' 
and   tiers_visible = 'N' 
and   num_tiers     not in ( select num_tiers 
                             from   wm_client_commande 
		    			     where  login_site = :login
					        )
and   num_tiers     not in ( select id_fournisseur
                             from   wm_commande
                             where  login_site = :login
                            )";

$statement = $pdo_instance->prepare($req_del_sql);
$statement->execute(['login' => $login]) or die('<br> Erreur sql f_epurer_client');



////include('inc/end_connexion.php');

}

// Fonction qui renvoie le nom du client --------------------------------------------------------------
function f_affiche_nom_client ($num_client, $login) {

$req_sql = "
select    nom_tiers
from    wm_ref_tiers
where    login_site    = :login
and        num_tiers     = :num_client";

//include('inc/start_connexion.php');
  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('num_client', $num_client, PDO::PARAM_INT);

  
$res_sql    = $statement->execute() or die('<br> Erreur sql f_affiche_nom_client');
$ligne      = $statement->fetch(PDO::FETCH_NUM);
$nom_client = $ligne[0];

//include('inc/end_connexion.php');

$url_    = 'wm_accueil.php?menu_=n_a&tiers_=client&id_client=' . $num_client;
$lien    = "<span onClick=document.location='" . $url_ . "'; style=cursor:pointer> $nom_client </span>";
$titre    = 'RDV du client : ' . $lien;

return $titre;

}

// Fonction qui renvoie le dernier num_rdv d'un client, 0 si pas de RDV ------------------------------------------------
function f_retourne_dernier_rdv_client ($num_client, $login) {

$req_sql_count = "
select    count(num_rdv)
from    wm_rdv
where    login_site  = :login
and        num_client  = :num_client
and        date_rdv    = (select max(date_rdv) from wm_rdv where login_site = :login and num_client = :num_client)";

$req_sql = "
select    num_rdv
from    wm_rdv
where    login_site  = :login
and        num_client  = :num_client
and        date_rdv    = (select max(date_rdv) from wm_rdv where login_site  = :login and num_client = :num_client)";

//include('inc/start_connexion.php');

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql_count);
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('num_client', $num_client, PDO::PARAM_INT);


$res_sql    = $statement->execute() or die('<br> Erreur sql f_retourne_dernier_rdv_client - 1');
$ligne        = $statement->fetch(PDO::FETCH_NUM);
$nb_rdv    = $ligne[0];

if ($nb_rdv == 0) {
    $num_rdv = 0;
}
else {
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam('login', $login, PDO::PARAM_STR);
  $statement->bindParam('num_client', $num_client, PDO::PARAM_INT);
  $res_sql    = $statement->execute() or die('<br> Erreur sql f_retourne_dernier_rdv_client - 2');
  $ligne        = $statement->fetch(PDO::FETCH_NUM);
  $num_rdv    = $ligne[0];
}


return $num_rdv;

}

// Fonction qui affiche le tableau des RDV pour 1 client --------------------
function f_affiche_tab_rdv_client ($num_client, $login) {

//include('inc/start_connexion.php');

$req_sql_count = "
select    count(num_rdv)
from    wm_rdv
where    login_site  = :login
and        num_client  = :num_client";


  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql_count);
  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->bindParam("num_client", $num_client, PDO::PARAM_INT);
  
  

$res_sql    = $statement->execute() or die('<br> Erreur sql f_affiche_tab_rdv_client - 1');
$ligne        = $statement->fetch(PDO::FETCH_NUM);
$nb_rdv    = $ligne[0];

if ($nb_rdv == 0) {
    echo '<br> Aucun RDV pour ce client.';
}
else {
	
	if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='DESC'; }
    if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }
    if ($id_col >= 4) { $id_col=3; }

    $order_query='order by ' . $id_col . ' ' . $sens_req;
	
    $req_sql = "
    select  num_rdv,
            num_rdv 'N&deg; RDV',
            date_format(  date_rdv  , '%Y-%m-%d' ) 'Date RDV',
            substring(sujet, 1, 50) Sujet
    from    wm_rdv
    where    login_site    = :login
    and        num_client    = :num_client
    and        rdv_visible    = 'O'
    :order_query";
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam("login", $login, PDO::PARAM_STR);
  $statement->bindParam("num_client", $num_client, PDO::PARAM_INT);
  $statement->bindParam("order_query", $order_query, PDO::PARAM_STR);
  

    $res_sql =  $statement->execute() or die('<br> Erreur sql f_affiche_tab_rdv_client - 2');

    // % du size du tableau
    $tab_size[0]='0';
    $tab_size[1]='15';
    $tab_size[2]='15';
    $tab_size[3]='70';

    f_affiche_tableau($statement, $tab_size);
}
//include('inc/end_connexion.php');

}

// Fonction qui recupere les informations du formulaire RDV --------------------
function f_affiche_form_rdv_client ($num_client, $login, $num_rdv) {

$req_sql = "
select  date_rdv,
        sujet,
        objectif,
        heure_rdv
from    wm_rdv
where	login_site	= :login
and		num_client	= :num_client
and		num_rdv		= :num_rdv";

//include('inc/start_connexion.php');

if ($num_rdv == 0) {
    $ligne['date_rdv']	= '';
    $ligne['sujet']		= '';
    $ligne['objectif']	= '';
    $ligne['heure_rdv']	= '';
}

else {


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);

$statement->bindParam('num_rdv', $num_rdv, PDO::PARAM_INT);
$statement->bindParam('num_client', $num_client, PDO::PARAM_INT);

$statement->execute();
$ligne = $statement->fetch(PDO::FETCH_NUM);
}

return $ligne;

}

// fonction qui cr�e un nouveau RDV ----------------------------------------------
function f_ajoute_rdv ($login, $num_client) {

f_supprime_rdv_invalide($login, $num_client);

//include('inc/start_connexion.php');

$req_ins_sql ="
insert into wm_rdv (date_insertion, date_modification, login_site, rdv_visible, num_client)
values (CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :login, 'O', :num_client)";


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_ins_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);
$statement->bindParam('num_client', $num_client, PDO::PARAM_INT);

$statement->execute() or die('<br> Erreur sql f_ajoute_rdv - 1');

$req_sql ="
select    max(num_rdv) num_rdv
from    wm_rdv
where    login_site    = :login
and        num_client    = :num_client
and        sujet        is null";

$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);
$statement->bindParam('num_client', $num_client, PDO::PARAM_INT);
$statement->execute() or die('<br> Erreur sql f_ajoute_rdv - 2');


$ligne = $statement->fetch(PDO::FETCH_NUM);
return $ligne[0];


}

// fonction qui supprime 1 rdv invalide ----------------------------------------------
function f_supprime_rdv_invalide ($login, $num_client) {


$req_upd_sql ="
update	wm_rdv
set		rdv_visible			= 'N',
		date_modification	= CURRENT_TIMESTAMP
where	login_site    = :login
and		num_client    = :num_client
and		(sujet  = '' or sujet is null)";
       
$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_upd_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);
$statement->bindParam('num_client', $num_client, PDO::PARAM_INT);

$tab = $statement->execute() or die('<br> Erreur sql f_supprime_rdv_invalide');

//include('inc/end_connexion.php');

}

// fonction qui supprime 1 rdv ----------------------------------------------
function f_supprime_rdv ($login, $num_client, $num_rdv) {

//include('inc/start_connexion.php');

$req_upd_sql ="
update	wm_rdv
set		rdv_visible			= 'N',
		date_modification	= CURRENT_TIMESTAMP
where	login_site	= :login
and		num_client	= :num_client
and		num_rdv		= :num_rdv";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_upd_sql);
$statement->bindParam('login', $login, PDO::PARAM_STR);
$statement->bindParam('num_client', $num_client, PDO::PARAM_INT);
$statement->bindParam('num_rdv', $num_rdv, PDO::PARAM_INT);


$tab = $statement->execute() or die('<br> Erreur sql f_supprime_rdv');

//include('inc/end_connexion.php');

}

// fonction qui modifie les infos d'un rdv_client ----------------------------------------------
function f_modification_rdv ($login, $id_client, $num_rdv, $tab_mod) {

//include('inc/start_connexion.php');

$date_rdv	= $tab_mod['date_rdv'];
$sujet		= $tab_mod['sujet'];
$objectif	= $tab_mod['objectif'];
$heure_rdv	= $tab_mod['heure_rdv'];

   
$req_sql ="
update	wm_rdv
set		date_rdv			= '$date_rdv',
		sujet				= '$sujet',
		objectif			= '$objectif',
		date_modification	= CURRENT_TIMESTAMP,
		heure_rdv			= '$heure_rdv'
where	num_client	= $id_client
and		login_site	= '$login'
and		num_rdv		= $num_rdv";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);

$statement->execute() or die('<br> Erreur sql f_modification_rdv');
       

}

// fonction qui r�cup�re la date du prochain rdv d'un client ----------------------------------------------
function f_retourne_prochain_rdv_client($login, $id_client) {


$req_sql ="
select	date_rdv,
		heure_rdv 
from	wm_rdv
where	login_site			= :login
and		num_client			= :id_client
and		date_rdv	>= CURRENT_DATE
and		date_rdv	in (	select	max(date_rdv) date_rdv_suivant
								from	wm_rdv
								where	login_site	= :login
								and		num_client	= :id_client
								and		date_rdv	>= CURRENT_DATE)";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login, 'id_client' => $id_client]) or die('<br> Erreur sql f_retourne_prochain_rdv_client');


$ligne = $statement->fetch(PDO::FETCH_NUM);
print_r($ligne);
$date_rdv_suivant	= $ligne[0];
$heure_rdv_suivant	= $ligne[1];

$date_rdv_suivant = NormalDate($date_rdv_suivant);

if ($date_rdv_suivant == '//' or $date_rdv_suivant == '00/00/0000') { $date_rdv_suivant = 'Pas de RDV pr&eacute;vu'; }
else { 
	if (strlen($heure_rdv_suivant) > 0) { $date_rdv_suivant = $date_rdv_suivant . ' &agrave; ' . $heure_rdv_suivant; }
}

return $date_rdv_suivant;

//include('inc/end_connexion.php');

}

// fonction qui r�cup�re la date du dernier rdv d'un client ----------------------------------------------
function f_retourne_date_dernier_rdv_client($login, $id_client) {

//include('inc/start_connexion.php');

$req_sql ="
select	date_rdv,
		heure_rdv 
from	wm_rdv
where	login_site	= :login
and		num_client	= :id_client
and		date_rdv	<= CURRENT_DATE
and		date_rdv	in (	select	max(date_rdv) date_rdv
							from	wm_rdv
							where	login_site	= :login
							and		num_client	= :id_client
							and		date_rdv	<= CURRENT_DATE)";




 
$pdo_instance = SPDO::getInstance();

$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login, 'id_client'=> $id_client]) or die('<br> Erreur sql f_retourne_dernier_rdv_client');

$ligne = $statement->fetch(PDO::FETCH_NUM);
$dernier_rdv_client	= $ligne[0];
$heure_rdv_client	= $ligne[1];

$dernier_rdv_client = NormalDate($dernier_rdv_client);

if ($dernier_rdv_client == '//' or $dernier_rdv_client == '00/00/0000') { $dernier_rdv_client = 'Aucun RDV'; }
else { 
	if (strlen($heure_rdv_client) > 0) { $dernier_rdv_client = $dernier_rdv_client . ' &agrave; ' . $heure_rdv_client; }
}

return $dernier_rdv_client;

//include('inc/end_connexion.php');

}

// Fonction qui retourne le n� de client par rapport � un n� de rdv
function f_retourne_client_id_num_rdv($num_rdv) {

//include('inc/start_connexion.php');

$req_sql = " 
select	num_client
from	wm_rdv
where	num_rdv		= :num_rdv" ;


  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->bindParam('num_rdv', $num_rdv, PDO::PARAM_INT);
  $statement->execute() or die('<br> Erreur sql f_retourne_client_id_num_rdv ');
  $ligne = $statement->fetch(PDO::FETCH_NUM);

return $ligne [0];


}

// Fonction qui affiche les prochains rdv ---------------------------------------------------------------------------
function f_affiche_calendrier ($login) {

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=6; }
if ($id_col > 7) { $id_col=6; }

$order_query='order by ' . $id_col . ' ' . $sens_req;

//include('inc/start_connexion.php');

$req_sql = " 
select	r.num_rdv,
		r.num_client, 
		r.num_rdv   'N&deg; RDV',
 		c.nom_tiers Client, 
		concat(c.adr_livraison_cp, ' - ', c.adr_livraison_ville, ' ', ifnull(c.adr_livraison_1,'') , ' ', ifnull(c.adr_livraison_2,'') ) 'Adresse',
		date_format( r.date_rdv  , '%Y-%m-%d' ) 'Date RDV',
		r.heure_rdv	'Heure'
from	wm_rdv			r,
		wm_ref_tiers	c
where	r.login_site		= :login 
and		r.login_site		= c.login_site
and		r.date_rdv			>= CURRENT_DATE
and		r.num_client		= c.num_tiers
$order_query";

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute(['login' => $login]) or die('<br> Erreur sql f_affiche_calendrier');

// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='0';
$tab_size[2]='10';
$tab_size[3]='35';
$tab_size[4]='35';
$tab_size[5]='10';
$tab_size[6]='10';

f_affiche_tableau($statement, $tab_size);


}

// Fonction qui retourne la chaine en parametre avec des caracteres non speciaux
function f_retourne_chaine_sans_accent($var) {
	$var = str_replace(
		array(
			'�', '�', '�', '�', '�', '�', '�', 
			'�', '�', 
			'�', '�', '�', '�', 
			'�', '�', '�', '�', '�', '�', '�', 
			'�', '�', '�', '�', 
			'�', '�', '�', '�', 
			'�', '�', '�',
			'�', '�', '�', '�', '�', '�', '�', 
			'�', '�', '�', '�', 
			'�', '�', '�', '�', '�', '�', 
			'�', '�', '�', '�', 
			'�', '�', '�', '�', 
			'�', '�', '�', '�', 
			'�', '�', 
			'�', '�', '�', 
			//"`", "�", "�", "`", "�", "�", "�", "�", 
		),
		array(
			'a', 'a', 'a', 'a', 'a', 'a', 'a', 
			'B', 'Ss', 
			'i', 'i', 'i', 'i', 
			'o', 'o', 'o', 'o', 'o', 'o', 'o', 
			'u', 'u', 'u', 'u', 
			'e', 'e', 'e', 'e', 
			'c', 'y', 'n', 
			'A', 'A', 'A', 'A', 'A', 'A', 'A', 
			'I', 'I', 'I', 'I', 
			'O', 'O', 'O', 'O', 'O', 'O', 
			'U', 'U', 'U', 'U', 
			'E', 'E', 'E', 'E', 
			'C', 'Y', 'Y', 'N', 
			'S', 's', 
			'Z', 'z', 'y', 
			//"'", "'", ",", "'", "'", "\"", "\"", "'", 
		),$var);
	return $var;
}

// Fonction qui teste si le client n'existe pas retourne 0, 1 s'il existe -------------------------------------------------
function f_test_nom_tiers_doublon($login, $nom_tiers, $flag_client_fournisseur, $num_tiers) {

//include('inc/start_connexion.php');

$req_sql = " 
select	count(*)
from	wm_ref_tiers
where	login_site				= :login
and		nom_tiers_code			= trim(:nom_tiers)
and		flag_fournisseur_client	= :flag_client_fournisseur
and		tiers_visible			= 'O'
and		num_tiers				!= :num_tiers";


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam("login", $login, PDO::PARAM_STR);

$statement->bindParam("nom_tiers", $nom_tiers, PDO::PARAM_STR);
$statement->bindParam("flag_client_fournisseur", $flag_client_fournisseur, PDO::PARAM_STR);
$statement->bindParam("num_tiers", $num_tiers, PDO::PARAM_INT);

$statement->execute() or die('<br> Erreur sql f_test_nom_tiers_doublon');

$ligne = $statement->fetch(PDO::FETCH_NUM);

if ($ligne [0] == 0) {
	return 0;
}
else {
	return 1;
}

//include('inc/end_connexion.php');

}

// Fonction qui teste si le client est un client ou un prospect ------------------------------------------------------------
function f_modification_tiers_client_prospect($login) {
	$pdo_instance = SPDO::getInstance();

$req_sql = " 
update	wm_ref_tiers
set		flag_client_prospect	= 'P'
where	login_site				= :login
and		flag_fournisseur_client	= 'C'
and		tiers_visible			= 'O'";


$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login]) or die('<br> Erreur sql f_modification_tiers_client_prospect - 1');

$req_sql = " 
update	wm_ref_tiers
set		flag_client_prospect	= 'C'
where	flag_fournisseur_client	= 'C'
and		tiers_visible			= 'O'
and		login_site				= :login
and		num_tiers				in (	select distinct num_tiers
										from			wm_client_commande
										where			login_site			= :login
										and				type_commande		= 'C'
										and				etat_commande		= 'T'
										and				commande_visible	= 'O')";

$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login]) or die('<br> Erreur sql f_modification_tiers_client_prospect - 2');;


}

// Fonction qui retourne le pied de mail ------------------------------------------------------------
function f_retourne_pied_de_mail($login) {

//include('inc/start_connexion.php');

$req_sql = "
select	nom,
		prenom,
		adresse1,
		adresse2,
		cp,
		ville,
		num_siret,
		num_tva,
		e_mail,
		tel_fixe,
		tel_mobile,
		nom_tiers,
		ifnull(trim(pied_de_mail),'')
from	ref_comptes
where	login = :login";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute(['login' => $login]) or die('<br> Erreur sql f_retourne_pied_de_mail');
$ligne = $statement->fetch(PDO::FETCH_NUM);

$cpt_nom			= $ligne[0];
$cpt_prenom			= $ligne[1];
$cpt_adresse1		= $ligne[2];
$cpt_adresse2		= $ligne[3];
$cpt_cp				= $ligne[4];
$cpt_ville			= $ligne[5];
$cpt_num_siret		= $ligne[6];
$cpt_num_tva		= $ligne[7];
$cpt_e_mail			= $ligne[8];
$cpt_tel_fixe		= $ligne[9];
$cpt_tel_mobile		= $ligne[10];
$cpt_nom_tiers		= $ligne[11];
$contenu_pied_page	= $ligne[12];

//include('inc/end_connexion.php');

if ($contenu_pied_page == '') {
$pied_de_page = "--------------------------------------------------------------- <br>
$cpt_nom_tiers <br>
$cpt_nom $cpt_prenom <br>
// FIx 
$cpt_adresse1 <br>
Tel fixe : $cpt_tel_fixe <br>
Tel Mobile : $cpt_tel_mobile <br><br>
www.winemanager.fr<br>
--------------------------------------------------------------- <br>";
}
else { 
$contenu_pied_page=nl2br($contenu_pied_page);
$pied_de_page = "--------------------------------------------------------------- <br> $contenu_pied_page <br><br> www.winemanager.fr <br> --------------------------------------------------------------- <br>"; }

return $pied_de_page;

}

// Fonction qui retourne le n� de client par rapport � un n� de rdv ---------------------------------
function f_retourne_adr_livraison_client ($login, $num_commande) {

//include('inc/start_connexion.php');

$req_sql = " 
select	case when cc.livraison_adr_flag = 'O' and trim(cc.livraison_adr) != '' then cc.livraison_adr 
		else concat(ifnull(adr_livraison_1, ''), case ifnull(adr_livraison_2, '') when '' then '' else concat('<br>',adr_livraison_2) end , '<br>',ifnull(adr_livraison_cp, ''), ' ', ifnull(adr_livraison_ville, '')) 
		end livraison_adr
from	wm_client_commande	cc,
		wm_ref_tiers		c
where	cc.login_site	= :login
and		cc.login_site	= c.login_site
and		cc.num_tiers	= c.num_tiers
and		cc.num_commande	= :num_commande" ;


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam("login", $login, PDO::PARAM_STR);
$statement->bindParam("num_commande", $num_commande, PDO::PARAM_INT);
$statement->execute() or die('<br> Erreur sql f_retourne_adr_livraison_client ');
$ligne = $statement->fetch(PDO::FETCH_NUM);
$adr_livraison_commande = nl2br($ligne[0]);

return $adr_livraison_commande;


}

// Fonction qui enregistre le contenu en PDF ------------------------------------------------------
function f_enregistre_pdf($content, $mode, $file_name, $chemin) { //mode : portrait : P paysage : L
	
	$chemin = $chemin.$file_name ;
	
    try
    {
        $pdf = new HTML2PDF($mode,'A4','fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->WriteHTML($content);
        $pdf->Output($chemin, 'F');
    }
    catch(HTML2PDF_exception $e)
    {
        die ($e);
    }
	
}

// fonction qui affiche les stats des utilisateurs  ----------------------------------------------
function f_affiche_indicateurs_utilisateurs () {

//include('inc/start_connexion.php');

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col']; } else { $id_col=1; }
if($id_col>8){ $id_col=1; }

$order_query='order by ' . $id_col . ' ' . $sens_req;

$req_sql = " 
select compte.login 'Compte',
	(select count(distinct num_tiers) from wm_ref_tiers client where client.login_site = compte.login and flag_fournisseur_client = 'C' and flag_client_prospect = 'P') 'Nb prospects',
	(select count(distinct num_tiers) from wm_ref_tiers client where client.login_site = compte.login and flag_fournisseur_client = 'C' and flag_client_prospect = 'C') 'Nb clients',
	(select count(distinct num_tiers) from wm_ref_tiers client where client.login_site = compte.login and flag_fournisseur_client = 'F' ) 'Nb fournisseurs',
	(select count(distinct num_commande) from wm_client_commande commande where commande.login_site = compte.login and type_commande = 'C' and etat_commande='A') 'Nb commande annul�e',
	(select count(distinct num_commande) from wm_client_commande commande where commande.login_site = compte.login and type_commande = 'C' and etat_commande='E') 'Nb commande en cours',
	(select count(distinct num_commande) from wm_client_commande commande where commande.login_site = compte.login and type_commande = 'C' and etat_commande='T') 'Nb commande termin�e',
	(select count(distinct num_commande) from wm_client_commande commande where commande.login_site = compte.login and type_commande = 'D' and etat_commande='E') 'Nb devis en cours'
from ref_comptes compte
$order_query" ;

// % du size du tableau
$tab_size[0]='30';
$tab_size[1]='10';
$tab_size[2]='10';
$tab_size[3]='10';
$tab_size[4]='10';
$tab_size[5]='10';
$tab_size[6]= '10';
$tab_size[7]= '10';

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);

  $statement->execute() or die('<br> Erreur sql f_affiche_indicateurs_utilisateurs');

f_affiche_tableau($statement, $tab_size);

//include('inc/end_connexion.php');

}

// fonction qui affiche les versionning  ----------------------------------------------
function f_affiche_version ($nb_jours, $flag_visible) {

//include('inc/start_connexion.php');

if ($flag_visible=='O') { $condition_flag_visible = " and flag_visible = 'O'"; } else { $condition_flag_visible = ''; }


$req_sql = " 
select	num_version 'N� Version',
		dt_mep		'Date de Production',
		commentaire	'Evolution apport�e'
from	wm_versioning
where	dt_mep		>= date_add(CURRENT_DATE, INTERVAL -$nb_jours DAY) 
$condition_flag_visible 
order by 2 DESC" ;

// % du size du tableau
$tab_size[0]='15';
$tab_size[1]='15';
$tab_size[2]='70';


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute() or die('<br> Erreur sql f_affiche_version');

f_affiche_tableau($statement, $tab_size);

//include('inc/end_connexion.php');

}

// fonction qui retourne le nb de ligne du versionning  ----------------------------------------------
function f_retourne_nb_lignes_versionning($nb_jours, $flag_visible) {

////include('inc/start_connexion.php');

if ($flag_visible=='O') { $condition_flag_visible = " and flag_visible = 'O'"; } else { $condition_flag_visible = ''; }

$req_sql = " 
select	ifnull(count(*), 0) nb_lignes
from	wm_versioning
where	dt_mep		>= date_add(CURRENT_DATE, INTERVAL -:nb_jours DAY) 
$condition_flag_visible ";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql) or die('<br> Erreur sql f_retourne_nb_lignes_versionning ');
$statement->bindParam('nb_jours', $nb_jours, PDO::PARAM_INT);
$statement->execute(); // Récupérer les résultats 
$tab_form = $statement->fetch(PDO::FETCH_ASSOC);


return $tab_form ['nb_lignes'];

////include('inc/end_connexion.php');

}

// fonction qui retourne le nb de ligne du versionning  ----------------------------------------------
function f_transforme_caractere_html($chaine_a_retourner, $flag_type) { // $flag_type : si html alors retourne le html sinon la conversion

if ($flag_type == 'html') {
$chaine_a_retourner = str_replace('�','&eacute;', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','&egrave;', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','&ecirc;', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','&agrave;', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','&ugrave;', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','&ccedil;', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','&ucirc;', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','&deg;', $chaine_a_retourner);
}
else {
$chaine_a_retourner = str_replace('�','e', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','e', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','e', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','a', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','u', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','c', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�','u', $chaine_a_retourner);
$chaine_a_retourner = str_replace('�',' ', $chaine_a_retourner);
}	
	
return $chaine_a_retourner;
}

// Fonction qui affiche un tableau crois� dynamique par produit en fct� des fournisseurs ou des clients
function f_affiche_stat_produit ($login, $flag_client_fournisseur, $flag_total, $id_tiers) {

if ($flag_total == 'N') {
	// Gestion du titre -----------
	$req_sql = "
	select	nom_tiers, flag_fournisseur_client
	from	wm_ref_tiers       t
	where	login_site    = :login
	and		num_tiers     = :id_tiers";

	$pdo_instance = SPDO::getInstance();
	$statement = $pdo_instance->prepare($req_sql);
	$statement->bindParam("login", $login, PDO::PARAM_STR);

	$statement->bindParam("id_tiers", $id_tiers, PDO::PARAM_INT);
	$statement->execute() or die('<br> Erreur sql f_affiche_stat_produit - 1');
	$ligne = $statement->fetch(PDO::FETCH_NUM);
	
	$nom_client = $ligne[0];
	$flag_fournisseur_client = $ligne[1]; 

	if ($flag_fournisseur_client == 'C') { 
		$flag_fournisseur_client = 'client'; 
		$url_='wm_accueil.php?menu_=n_a&tiers_=client&id_client='.$id_tiers;
	} 
	else { 
		$flag_fournisseur_client = 'fournisseur'; 
		$url_='wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client='.$id_tiers;
	}
	
	$lien = "<span onClick=document.location='" . $url_ . "'; style=cursor:pointer> $nom_client </span>";
	$titre = 'Produits du ' . $flag_fournisseur_client . ' : ' . $lien;
	
	// Affichage du tableau
	echo '<table width=100% cellpadding=0 align=center border=0 class=style_form_1>';
	echo '<tr>';
	echo '<td> <br><br><br> </td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td bgcolor=#B3B3B3 class=titre2> '.$titre .'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td> <br> </td>';
	echo '</tr>';
	echo '</table>';
}

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }

$order_query='order by ' . $id_col . ' ' . $sens_req;

// Generation du nb de mois
$nb_mois = date('m');
$nb_mois_int = intval(date('m'));
$annee = date('Y'); 

$sql_mois_valeur = '';
for ($j = 1; $j <= $nb_mois_int; $j++) {
	
	if ($j <= 10) { $val_test = strval('0'.$j); } else { $val_test = strval($j); }
	$nom_colonne = date('Y') . '-' . $val_test;
	$sql_mois_valeur .= " sum( case when date_format(cc.commande_date , '%m') = '$val_test' then c.quantite else 0 end ) '$nom_colonne'";
	if ($j != $nb_mois_int) { $sql_mois_valeur .= ','; }
	
}		

if ($flag_client_fournisseur == 'F') {	
	if ($flag_total == 'N') {
		$req_sql = " 
		select		cc.num_tiers									num_client,
					cl.nom_tiers									Client,
					upper(c.produit)								Produits,
					sum(ifnull(c.quantite, 0))						Global,
					$sql_mois_valeur
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		cl,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= date_format( CURRENT_DATE , '%Y' )
		and			c.login_site							= cl.login_site
		and			cc.num_tiers							= cl.num_tiers
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.id_fournisseur						= $id_tiers
		and			c.flag_ok								= 'O'
		group by	cc.num_tiers,
					cl.nom_tiers,
					upper(c.produit)
		$order_query
		";
	}
	
	if ($flag_total == 'Y') {
		$req_sql = " 
		select		'GLOBAL',
					sum(ifnull(c.quantite, 0))						Global,
					$sql_mois_valeur
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		cl,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= date_format( CURRENT_DATE , '%Y' )
		and			c.login_site							= cl.login_site
		and			cc.num_tiers							= cl.num_tiers
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.id_fournisseur						= $id_tiers
		and			c.flag_ok								= 'O'";
	}
}

if ($flag_client_fournisseur == 'C') {
	if ($flag_total == 'N') {
		$req_sql = " 
		select		c.id_fournisseur																	num_fournisseur,
					f.nom_tiers																			Fournisseur,
					upper(c.produit)																	Produits,
					sum(ifnull(c.quantite, 0))															Global,
					$sql_mois_valeur
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		cl,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= date_format( CURRENT_DATE , '%Y' )
		and			c.login_site							= cl.login_site
		and			cc.num_tiers							= cl.num_tiers
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.flag_ok								= 'O'
		and			cl.num_tiers							= $id_tiers
		group by	cc.num_tiers,
					c.id_fournisseur,
					f.nom_tiers,
					cl.nom_tiers,
					upper(c.produit)
		$order_query" ;
	}
	
	if ($flag_total == 'Y') {
		$req_sql = " 
		select		'GLOBAL',
					sum(ifnull(c.quantite, 0))																Global,
					$sql_mois_valeur
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		cl,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= date_format( CURRENT_DATE , '%Y' )
		and			c.login_site							= cl.login_site
		and			cc.num_tiers							= cl.num_tiers
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.flag_ok								= 'O'
		and			cl.num_tiers							= $id_tiers";
	}
}

$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);

  $statement->execute() or die('<br> Erreur sql f_affiche_stat_produit - 2');

if ($flag_total == 'N') {
// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='15';
$tab_size[2]='15';
$tab_size[3]='5';
$tab_size[4]='5';
$tab_size[5]='5';
$tab_size[6]='5';
$tab_size[7]='5';
$tab_size[8]='5';
$tab_size[9]='5';
$tab_size[10]='5';
$tab_size[11]='5';
$tab_size[12]='5';
$tab_size[13]='5';
$tab_size[14]='5';
$tab_size[15]='5';
$tab_size[16]='5';
}
if ($flag_total == 'Y') {
// % du size du tableau
$tab_size[0]='30';
$tab_size[1]='5';
$tab_size[2]='5';
$tab_size[3]='5';
$tab_size[4]='5';
$tab_size[5]='5';
$tab_size[6]='5';
$tab_size[7]='5';
$tab_size[8]='5';
$tab_size[9]='5';
$tab_size[10]='5';
$tab_size[11]='5';
$tab_size[12]='5';
$tab_size[13]='5';
$tab_size[14]='5';
}

if ($flag_total == 'N') { f_affiche_tableau($statement, $tab_size); }
if ($flag_total == 'Y') { f_affiche_tableau_global($statement, $tab_size); }


}


// Fonction qui affiche un tableau crois� dynamique par Client/fournisseur sur la periode en cours
function f_affiche_stat_evolution ($login, $flag_client_fournisseur, $flag_total) {

if(isset($_GET['sens_req'])) { $sens_req=$_GET['sens_req']; } else { $sens_req='ASC'; }
if(isset($_GET['id_col'])) { $id_col=$_GET['id_col'] + 1 ; } else { $id_col=3; }

$order_query='order by ' . $id_col . ' ' . $sens_req;

// Generation du nb de mois
$nb_mois = date('m');
$nb_mois_int = intval(date('m'));
$annee = date('Y'); 

$sql_mois_valeur = '';
for ($j = 1; $j <= $nb_mois_int; $j++) {
	if ($j <= 10) { $val_test = strval('0'.$j); } else { $val_test = strval($j); }
	$nom_colonne = date('Y') . '-' . $val_test;
	$sql_mois_valeur .= " sum( case when date_format(cc.commande_date , '%m') = '$val_test' then round(c.quantite*c.prix_ht*commission/100, 2) else 0 end ) '$nom_colonne'";
	if ($j != $nb_mois_int) { $sql_mois_valeur .= ','; }
}		

if ($flag_client_fournisseur == 'C') {	
	if ($flag_total == 'N') {
		$req_sql = " 
		select		cc.num_tiers													num_client,
					cl.nom_tiers													Client,
					sum(ifnull(round(c.quantite*c.prix_ht*commission/100, 2), 0))	Global,
					$sql_mois_valeur
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		cl,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= date_format( CURRENT_DATE , '%Y' )
		and			c.login_site							= cl.login_site
		and			cc.num_tiers							= cl.num_tiers
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.flag_ok								= 'O'
		group by	cc.num_tiers,
					cl.nom_tiers
		$order_query
		";
	}
	
	if ($flag_total == 'Y') {
		$req_sql = " 
		select		'Commission GLOBALE',
					sum(ifnull(round(c.quantite*c.prix_ht*commission/100, 2), 0))	Global,
					$sql_mois_valeur
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		cl,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= date_format( CURRENT_DATE , '%Y' )
		and			c.login_site							= cl.login_site
		and			cc.num_tiers							= cl.num_tiers
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.flag_ok								= 'O'";
	}
}

if ($flag_client_fournisseur == 'F') {
	if ($flag_total == 'N') {
		$req_sql = " 
		select		c.id_fournisseur																	num_fournisseur,
					f.nom_tiers																			Fournisseur,
					sum(ifnull(round(c.quantite*c.prix_ht*commission/100, 2), 0))						Global,
					$sql_mois_valeur
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		cl,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= date_format( CURRENT_DATE , '%Y' )
		and			c.login_site							= cl.login_site
		and			cc.num_tiers							= cl.num_tiers
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.flag_ok								= 'O'
		group by	c.id_fournisseur,
					f.nom_tiers
		$order_query" ;
	}
	
	if ($flag_total == 'Y') {
		$req_sql = " 
		select		'Commission GLOBALE',
					sum(ifnull(round(c.quantite*c.prix_ht*commission/100, 2), 0))	Global,
					$sql_mois_valeur
		from		wm_commande			c,
					wm_client_commande	cc,
					wm_ref_tiers		cl,
					wm_ref_tiers		f
		where		c.num_commande							= cc.num_commande
		and			cc.etat_commande						= 'T'
		and			c.login_site							= cc.login_site
		and			c.login_site							= '$login'
		and			date_format(cc.commande_date , '%Y' )	= date_format( CURRENT_DATE , '%Y' )
		and			c.login_site							= cl.login_site
		and			cc.num_tiers							= cl.num_tiers
		and			cc.login_site							= f.login_site
		and			c.id_fournisseur						= f.num_tiers
		and			c.flag_ok								= 'O'";
	}
}

//echo $req_sql ;

////include('inc/start_connexion.php');
  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute() or die('<br> Erreur sql f_affiche_stat_evolution');

if ($flag_total == 'N') {
// % du size du tableau
$tab_size[0]='0';
$tab_size[1]='30';
$tab_size[2]='5';
$tab_size[3]='5';
$tab_size[4]='5';
$tab_size[5]='5';
$tab_size[6]='5';
$tab_size[7]='5';
$tab_size[8]='5';
$tab_size[9]='5';
$tab_size[10]='5';
$tab_size[11]='5';
$tab_size[12]='5';
$tab_size[13]='5';
$tab_size[14]='5';
$tab_size[15]='5';
}
if ($flag_total == 'Y') {
// % du size du tableau
$tab_size[0]='30';
$tab_size[1]='5';
$tab_size[2]='5';
$tab_size[3]='5';
$tab_size[4]='5';
$tab_size[5]='5';
$tab_size[6]='5';
$tab_size[7]='5';
$tab_size[8]='5';
$tab_size[9]='5';
$tab_size[10]='5';
$tab_size[11]='5';
$tab_size[12]='5';
$tab_size[13]='5';
$tab_size[14]='5';
}

if ($flag_total == 'N') { f_affiche_tableau($statement, $tab_size); }
if ($flag_total == 'Y') { f_affiche_tableau_global($statement, $tab_size); }

//include('inc/end_connexion.php');

}

// fonction qui exporte les r�sultats d une requete sous excel  ----------------------------------------------
function f_affiche_tableau_reporting($login) {

$req_sql = "select r.libelle_req    Extraction, 
                   r.descriptif_req Descriptif, 
				   r.num_reporting,
				   (select max(date_envoi) from wm_log_reporting l where l.num_reporting = r.num_reporting) 'Derniere extraction',
				   'Exporter' Exporter
				   from wm_ref_reporting r
				   where r.visible = 'O'";

// % du size du tableau
$tab_size[0]='20';
$tab_size[1]='55';
$tab_size[2]='0';
$tab_size[3]='15';
$tab_size[4]='10';




$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute() or die('<br> Erreur sql f_affiche_stat_evolution');
f_affiche_tableau($statement, $tab_size);

$date = date("ymd");
$extract_filename = ('_'.$login.'_'.$date.'_export.xls' ); 
	
//f_exporte_requete_excel($login, $req_sql, $extract_filename);

}

// fonction qui va g�rer la req. et l'envoi des donn�es reporting  ----------------------------------------------
function f_gestion_envoi_reporting($login, $num_reporting) {

////include('inc/start_connexion.php');

$req_sql = "
select req_sql,
       mail_objet,
	   nom_fichier,
	   ligne_1_fic_csv
from   wm_ref_reporting 
where  num_reporting = $num_reporting";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute() or die('<br> Erreur sql f_gestion_envoi_reporting - 1');
$ligne = $statement->fetch(PDO::FETCH_NUM);

$req_sql      = str_replace('$login', $login, "$ligne[0]");
$mail_objet   = $ligne[1];
$nom_fichier  = date('Ymd') . '_' . $login . '_' . $ligne[2] .'.xls' ;
$ligne_1_csv  = $ligne[3];

//echo $req_sql ;

if ($num_reporting==1) { // trop long pour tenir dans la colonne
	$ligne_1_csv='num_tiers|nom_tiers|categorie|num_siret|num_tva|adr_livraison_1|adr_livraison_2|adr_livraison_cp|adr_livraison_ville|adr_facturation_1|adr_facturation_2|adr_facturation_cp|adr_facturation_ville|paiement_mode|paiement_delai_j|telephone_livraison|telephone_portable|telephone_fixe|nom_contact_1|mail_contact_1|fonction_contact_1|nom_contact_2|mail_contact_2|fonction_contact_2|nom_contact_3|mail_contact_3|fonction_contact_3|nom_contact_4|mail_contact_4|fonction_contact_4|nom_contact_5|mail_contact_5|fonction_contact_5|flag_client_prospect|date_anniversaire|date_insertion|date_modification';
}
$chemin = 'exportxls/';

f_exporte_requete_excel($login, $req_sql, $chemin, $nom_fichier, $mail_objet, $ligne_1_csv);

////include('inc/start_connexion.php');
$ins = "insert into wm_log_reporting (login, num_reporting, date_envoi) select '$login', $num_reporting, CURRENT_TIMESTAMP";



  $pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($ins);
  $statement->execute() or die('<br> Erreur sql f_gestion_envoi_reporting - 2');

}

// fonction qui exporte les r�sultats d une requete sous excel  ----------------------------------------------
function f_exporte_requete_excel($login, $req_sql, $chemin, $extract_filename, $mail_objet, $ligne_1_csv) {



	$pdo_instance = SPDO::getInstance();
	$statement = $pdo_instance->prepare($req_sql);
	$statement->execute() or die('<br> Erreur sql f_exporte_requete_excel');

$fp=fopen($chemin.$extract_filename, "w+");

fwrite($fp,utf8_decode("$ligne_1_csv"));

for ($i = 0; $i < $statement->columnCount(); $i++) {
	
	if($i != 0) {
		$nom_colonne = $statement->getColumnMeta($i)['name'];
		fwrite($fp,utf8_decode("$nom_colonne"));
	}
}
fwrite($fp,utf8_decode("\n"));

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {
	
    for ($j = 0; $j < count($ligne); $j++) {
		$value_field=$ligne[$j];
		fwrite($fp,utf8_decode("$value_field\t"));
	}
	fwrite($fp,utf8_decode("\n"));
}

fclose($chemin.$extract_filename); 	

//include('inc/end_connexion.php');

f_envoi_extraction_excel($login, $chemin, $extract_filename, $mail_objet);

}


// fonction qui envoi le fichier extrait au mail de l'utilisateur   -------------------------------------------
function f_envoi_extraction_excel($login, $chemin, $extract_filename, $mail_objet) {
	
	//$filename = $chemin . $filename;
	$limite = "_parties_".md5(uniqid (rand())); 

	$headers = 'From: <contact@winemanager.fr>'."\r\n";
	$headers .= 'Reply-To: contact@winemanager.fr'."\r\n";
	$headers .= 'Bcc: <contact@winemanager.fr>'."\r\n";
	$headers .= "Date: ".date("l j F Y, G:i")."\n"; 
	$headers .= 'Mime-Version: 1.0'."\r\n";
	$headers .= "Content-Type: multipart/mixed;\n"; 
	$headers .= " boundary=\"----=$limite\"\n\n"; 
	$headers .= "\r\n";

	//Le message en texte simple pour les navigateurs qui n'acceptent pas le HTML 
	$contenu_mail = "This is a multi-part message in MIME format. \r\n"; 
	$contenu_mail .= "Ceci est un message est au format MIME. \r\n"; 
	$contenu_mail .= "------=$limite \r\n"; 
	$contenu_mail .= "Content-Type: text/html; charset=\"iso-8859-1\" \r\n"; 
	$contenu_mail .= "Content-Transfer-Encoding: 7bit\n\n"; 
	$contenu_mail .= 'Bonjour,<br><br>';
	$contenu_mail .= 'Veuillez trouver en piece jointe le reporting genere sur le site winemanager. <br>';
	$contenu_mail .= 'Vous en souhaitant bonne reception.<br><br>';
	$contenu_mail .= 'Cordialement<br><br>';
	$contenu_mail .= '-----------------------------------------------<br>';
	$contenu_mail .= 'www.winemanager.fr';
	$contenu_mail .= "\n\n"; 
  
	//le fichier 
	$attachement = "------=$limite\n"; 
	$attachement .= "Content-Type:'application/vnd.ms-excel'; name=\"$extract_filename\"\n"; 
	$attachement .= "Content-Transfer-Encoding: base64\n"; 
	$attachement .= "Content-Disposition: attachment; filename=\"$extract_filename\"\n\n"; 
  
	$fd = fopen( $chemin.$extract_filename, "r" ); 
	$contenu = fread( $fd, filesize( $chemin.$extract_filename ) ); 
	fclose( $fd ); 
	$attachement .= chunk_split(base64_encode($contenu)); 

	$attachement .= "\n\n\n------=$limite\n";

	$contenu_mail =  $contenu_mail . $attachement;
	
	//unlink($chemin.$extract_filename);
	
	//mail($_SESSION['e_mail'],$mail_objet,$contenu_mail,$headers);
	if (file_exists($chemin.$extract_filename)) {
			//ok
			//echo $chemin.$extract_filename;
			//$ressource = fopen($chemin.$extract_filename, 'rb');
            //echo fread($ressource, filesize($chemin.$extract_filename));
			echo " ";
	}
	else {
		  echo "Fichier inexistant";
	} 

}



















// Fonction qui envoie au fournisseur concern� les informations PLV -------------------------------------------------------------
function f_generate_commande_pdf_fournisseur ($login, $num_commande, $color_title, $style, $num_plv) {

$adr_livraison=f_retourne_adr_livraison_client ($login, $num_commande);
$pied_de_page = f_retourne_pied_de_mail($login);
$cellpadding=3;
$nbsp_='';
$nbsp_4='';

// Recuperation des informations de la commande et du client
$req_sql = "
select	cc.num_tiers,
		cc.commande_date,
		cc.type_commande,
		cc.etat_commande,
		ifnull(cc.livraison_date, '01/01/1900') livraison_date,
		cc.livraison_h_debut,
		cc.livraison_h_fin,
		cc.commentaire,
		c.nom_tiers,
		c.nom_contact_1,
		c.mail_contact_1,
		c.adr_facturation_1,
		c.adr_facturation_2,
		c.adr_facturation_cp,
		c.adr_facturation_ville,
		c.adr_livraison_1,
		c.adr_livraison_2,
		c.adr_livraison_cp,
		c.adr_livraison_ville,
		f.nom_tiers				nom_fournisseur,
		f.mail_contact_1		mail_1_fournisseur,
		f.mail_contact_2		mail_2_fournisseur,
		f.nom_contact_1			nom_1_fournisseur,
		f.nom_contact_2			nom_2_fournisseur,
		f.adr_livraison_1		adr_1_fournisseur,
		f.adr_livraison_2		adr_1_fournisseur,
		f.adr_livraison_cp		adr_cp_fournisseur,
		f.adr_livraison_ville	adr_ville_fournisseur,
		p.num_commande,
		c.num_siret,
		c.num_tva,
		c.telephone_livraison,
		f.flag_envoi_pdf
from	wm_client_commande	cc,
		wm_ref_tiers		c,
		wm_commande_plv		p,
		wm_ref_tiers		f
where	cc.login_site		= :login
and		cc.login_site		= c.login_site
and		cc.login_site		= p.login_site
and		cc.num_tiers		= c.num_tiers
and		cc.num_commande		= p.num_commande
and		p.num_plv			= :num_plv
and		p.id_fournisseur	= f.num_tiers";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->execute() or die('<br> Erreur sql f_envoi_plv - 1');
$ligne = $statement->fetch(PDO::FETCH_NUM);

$num_tiers				= $ligne[0];
$commande_date			= $ligne[1];
$type_commande			= $ligne[2];
$etat_commande			= $ligne[3];
$livraison_date			= NormalDate($ligne[4]);
$livraison_h_debut		= $ligne[5];
$livraison_h_fin		= $ligne[6];
$commentaire			= $ligne[7];
$nom_tiers				= $ligne[8];
$nom_contact_1			= $ligne[9];
$mail_contact_1			= $ligne[10];
$adr_facturation_1		= $ligne[11];
$adr_facturation_2		= $ligne[12];
$adr_facturation_cp		= $ligne[13];
$adr_facturation_ville	= $ligne[14];
$adr_livraison_1		= $ligne[15];
$adr_livraison_2		= $ligne[16];
$adr_livraison_cp		= $ligne[17];
$adr_livraison_ville	= $ligne[18];
$num_siret				= $ligne[29];
$num_tva				= $ligne[30];
$telephone_livraison	= $ligne[31];

$nom_fournisseur		= $ligne[19];
$mail_1_fournisseur		= $ligne[20];
$mail_2_fournisseur		= $ligne[21];
$nom_1_fournisseur		= $ligne[22];
$nom_2_fournisseur		= $ligne[23];
$adr_1_fournisseur		= $ligne[24];
$adr_1_fournisseur		= $ligne[25];
$adr_cp_fournisseur		= $ligne[26];
$adr_ville_fournisseur	= $ligne[27];
$flag_envoi_pdf			= $ligne[32];

// Recuperation des informations du compte
$req_sql = "
select	nom,
		prenom,
		adresse1,
		adresse2,
		cp,
		ville,
		num_siret,
		num_tva,
		e_mail,
		tel_fixe,
		tel_mobile,
		nom_tiers,
		ifnull(e_mail_1, '') e_mail_1,
		ifnull(e_mail_2, '') e_mail_2
from	ref_comptes
where	login = :login";



$pdo_instance = SPDO::getInstance();
  $statement = $pdo_instance->prepare($req_sql);
  $statement->execute(['login' => $login]) or die('<br> Erreur sql f_envoi_plv - 2');
  $ligne = $statement->fetch(PDO::FETCH_NUM);

$cpt_nom			= $ligne[0];
$cpt_prenom			= $ligne[1];
$cpt_adresse1		= $ligne[2];
$cpt_adresse2		= $ligne[3];
$cpt_cp				= $ligne[4];
$cpt_ville			= $ligne[5];
$cpt_num_siret		= $ligne[6];
$cpt_num_tva		= $ligne[7];
$cpt_e_mail			= $ligne[8];
$cpt_tel_fixe		= $ligne[9];
$cpt_tel_mobile		= $ligne[10];
$cpt_nom_tiers		= $ligne[11];
$e_mail_1			= $ligne[12];
$e_mail_2			= $ligne[13];

if (trim($adr_facturation_2)=='') { $adr_facturation_2 = '<br>'; } else { $adr_facturation_2 = '<br>' . $adr_facturation_2 . '<br>' ; }
if (trim($cpt_adresse2)=='') { $cpt_adresse2 = '<br>'; } else { $cpt_adresse2 = '<br>' . $cpt_adresse2 . '<br>' ; }

$adr_facturation	= $adr_facturation_1 . $adr_facturation_2 . $adr_facturation_cp . ' ' . $adr_facturation_ville;
$cpt_adresse		= $cpt_adresse1 . $cpt_adresse2 . $cpt_cp . ' ' . $cpt_ville;

$destinataire = '';

// Gestion des mails pour le client
// Cas o� les 2 mails sont renseign�s
if (trim($mail_1_fournisseur) != '' and trim($mail_2_fournisseur) != '') { $destinataire = '<'.$mail_1_fournisseur.'>,<'.$mail_2_fournisseur.'>'; }
// Cas o� uniquement le mail 1 est renseign�
if (trim($mail_1_fournisseur) != '' and trim($mail_2_fournisseur) == '') { $destinataire = '<'.$mail_1_fournisseur.'>'; }
// Cas o� uniquement le mail 2 est renseign�
if (trim($mail_1_fournisseur) == '' and trim($mail_2_fournisseur) != '') { $destinataire = '<'.$mail_2_fournisseur.'>'; }


//if (trim($cpt_e_mail) != '') { $destinataire .= ', <'.$cpt_e_mail.'>'; }
if (trim($e_mail_1) != '') { $destinataire .= ', <'.$e_mail_1.'>'; }
if (trim($e_mail_2) != '') { $destinataire .= ', <'.$e_mail_2.'>'; }


$sujet="$cpt_nom_tiers commande n�$num_commande-$num_plv";

$boundary = md5(uniqid(microtime(), TRUE));

// Headers
$headers = 'From: '.$cpt_nom.' '.$cpt_prenom.' <contact@winemanager.fr>'."\r\n";
$headers .= 'Reply-To: '.$cpt_e_mail."\r\n";
//$headers .= 'Bcc: '.$cpt_nom.' '.$cpt_prenom.' <'.$cpt_e_mail.'>'."\r\n";
$headers .= 'Mime-Version: 1.0'."\r\n";
$headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
$headers .= "\r\n";

$contenu_pied_page= "
<table class=$style>
<tr><td>
<br><br>
Bonne r&eacute;ception <br><br>
Cordialement <br><br>
$pied_de_page
</td></tr>
</table>";

// GESTION DU CONTENU DU MAIL --------------------------------------------------------------

$nbsp_='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$nbsp_4='&nbsp;&nbsp;&nbsp;&nbsp;';

$contenu_mail = '<page> '."\r\n\r\n"; 
$contenu_mail .= "
<table class=$style>
<tr><td><br><br>
$pied_de_page
</td></tr>
</table>
<table width=100% class=$style>
<tr>
<td>
<br><br>";

if ($info_livraison == '01/01/1900') { $info_livraison = 'Date de la livraison : Non defini'; }
else { $info_livraison = "Date de la livraison : $livraison_date entre $livraison_h_debut et $livraison_h_fin"; }

$contenu_mail .= "
<table width=100% align=left class=$style cellpadding=$cellpadding>
<tr>
<td bgcolor=$color_title colspan=2>$nbsp_ Veuillez trouver ci dessous les informations pour la livraison du client : $nbsp_</td>
</tr>
<tr>
<td bgcolor=$color_title width=20%> Nom du client $nbsp_</td>
<td width=80%> $nom_tiers </td>
</tr>
<tr>
<td bgcolor=$color_title> Nom du contact </td>
<td> $nom_contact_1 </td>
</tr>
<tr>
<td bgcolor=$color_title> T&eacute;l&eacute;phone </td>
<td> $telephone_livraison </td>
</tr>
<tr>
<td bgcolor=$color_title> SIRET </td>
<td> $num_siret </td>
</tr>
<tr>
<td bgcolor=$color_title> TVA </td>
<td> $num_tva </td>
</tr>
</table>
<br><br>

<table width=100% align=left class=$style cellpadding=$cellpadding>
<tr>
<td align=center bgcolor=$color_title>$nbsp_ Information de livraison $nbsp_</td>
</tr>
<tr> 
<td> $info_livraison</td> 
</tr>
</table>

 <br><br>

<table width=100% align=left class=$style cellpadding=$cellpadding>
<tr>
<td align=center bgcolor=$color_title> Information compl&eacute;mentaire $nbsp_</td>
</tr>
<tr> 
<td> $commentaire  </td> 
</tr>
</table>
<br><br>

</td>
</tr>
<tr><td>
<table width=100% align=left class=$style cellpadding=$cellpadding><tr>
<td align=center bgcolor=$color_title> Adresse de livraison $nbsp_ </td>
<td align=center bgcolor=$color_title> Adresse de facturation $nbsp_ </td>
</tr>
<tr> 
<td> $adr_livraison </td> 
<td> $adr_facturation  </td> 
</tr>
</table>
</td></tr>
<tr><td>
<br>
Veuillez trouver ci joint le r&eacute;capitulatif de la commande n&ordm;$num_commande-$num_plv : <br>
</td></tr></table>";

$contenu_plv = "
<br>
<table width=100% align=left class=$style cellpadding=$cellpadding><tr>
<td align=center bgcolor=$color_title width=40%> $nbsp_ Nom fournisseur $nbsp_</td>
<td align=center bgcolor=$color_title width=60%> $nbsp_ PLV $nbsp_</td>
</tr>";

$req_sql ="
select	f.nom_tiers,
		p.plv
from	wm_commande_plv	p,
		wm_ref_tiers	f
where	p.num_plv			= :num_plv
and		p.login_site		= :login
and		p.login_site		= f.login_site
and		p.id_fournisseur	= f.num_tiers";


$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam("login", $login, PDO::PARAM_STR);
$statement->bindParam("num_plv", $num_plv, PDO::PARAM_INT);
$statement->execute() or die('<br> Erreur sql f_envoyer_commande_client - 3');

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {
	for ($j = 0; $j < count($ligne); $j++) {
		$v_nom_tiers	= $ligne[0];
		$v_plv			= $ligne[1];
	}
	$contenu_plv = $contenu_plv . "<tr> <td align=left> $v_nom_tiers </td> <td align=left> $v_plv </td> </tr>";
}
$contenu_plv = $contenu_plv . '</table><br><br>';

$contenu_commande = "
<br><br>
<table width=100% align=left class=$style cellpadding=$cellpadding>		
<tr>
<td align=center bgcolor=$color_title width=30%> Produit $nbsp_	$nbsp_	</td>
<td align=center bgcolor=$color_title width=10%> $nbsp_4 Quantit&eacute; 		</td>
<td align=center bgcolor=$color_title width=15%> $nbsp_4 Prix HT 		</td>
<td align=center bgcolor=$color_title width=15%> $nbsp_ Total 			</td>
<td align=center bgcolor=$color_title width=15%> $nbsp_4 % Com. 			</td>
<td align=center bgcolor=$color_title width=15%> $nbsp_4 Montant Com. 	</td>
</tr>";

// Contenu facture
$req_sql ="
select	f.nom_tiers,
		c.produit,
		c.quantite,
		c.prix_ht,
		round(c.quantite * c.prix_ht, 2) total_ligne_ht,
		c.commission pct_commission,
		round(c.quantite * c.prix_ht * c.commission / 100, 2) total_ligne_ht_com
from	wm_commande		c,
		wm_ref_tiers	f,
		wm_commande_plv	p
where	p.num_plv			= :num_plv
and		p.num_commande		= c.num_commande
and		p.login_site		= :login
and		p.login_site		= c.login_site
and		c.login_site		= f.login_site
and		c.id_fournisseur	= f.num_tiers
and		p.id_fournisseur	= c.id_fournisseur";

$pdo_instance = SPDO::getInstance();
$statement = $pdo_instance->prepare($req_sql);
$statement->bindParam("login", $login, PDO::PARAM_STR);
$statement->bindParam("num_plv", $num_plv, PDO::PARAM_INT);
$statement->execute() or die('<br> Erreur sql f_envoi_plv - 3');

$total_facture_ht	= 0;
$total_facture_com	= 0;

while ($ligne = $statement->fetch(PDO::FETCH_NUM)) {

	for ($j = 0; $j < count($ligne); $j++) {
		$v_produit				= $ligne[1];
		$v_quantite				= $ligne[2];
		$v_prix_ht				= $ligne[3];
		$v_ligne_total			= $ligne[4];
		$v_pct_commission		= $ligne[5];
		$v_total_ligne_ht_com	= $ligne[6];
	}
	$total_facture_ht	= $total_facture_ht		+ $v_ligne_total;
	$total_facture_com	= $total_facture_com	+ $v_total_ligne_ht_com;
	
	$contenu_commande = $contenu_commande . "
	<tr> 
	<td align=left> $v_produit </td> 
	<td align=right> $v_quantite </td> 
	<td align=right> $v_prix_ht </td> 
	<td align=right> $v_ligne_total </td> 
	<td align=right> $v_pct_commission% </td> 
	<td align=right> $v_total_ligne_ht_com </td> 
	</tr>";
}

$total_facture_ht = round($total_facture_ht,2);
$total_facture_com = round($total_facture_com,2);
$contenu_commande = $contenu_commande . "
<tr>
<td bgcolor=$color_title colspan=3 align=right> TOTAL HT </td>
<td bgcolor=$color_title align=right> $total_facture_ht </td>
<td bgcolor=$color_title align=right> <br> </td>
<td bgcolor=$color_title align=right> $total_facture_com </td>
</tr>
</table><br><br>";

//include('inc/end_connexion.php');

$contenu_mail =  $contenu_mail . $contenu_plv . $contenu_commande;
$contenu_mail .= ' </page>'; 

// Enregistrement du fichier
$chemin = 'users/'.$login.'/commandes_pdf/';
$filename = date('Ymd') . '_' .  $num_commande . '_' . $num_plv . '.pdf';

$contenu_mail = f_transforme_caractere_html($contenu_mail, 'html');
	
f_enregistre_pdf($contenu_mail, 'P', $filename, $chemin) ;


}


?>






