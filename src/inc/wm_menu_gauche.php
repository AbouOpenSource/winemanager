<?php

echo '<br><br><br><br>';

if($menu_ == 'tiers'){
 echo '<span class=titre1>TIERS</span>';
 echo '<br><br>';
 echo '<table>';
 echo '<tr><td>';
 echo "<span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&tiers_=client'; style=cursor:pointer> CLIENT </span";
 echo '</td></tr><tr><td>';
 echo "<span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&tiers_=fournisseurs'; style=cursor:pointer> FOURNISSEURS </span";
 echo '</td></tr>';
 echo '</table>';
}

if($menu_ == 'action'){
 echo '<span class=titre1>ACTION</span>';
 echo '<br><br>';
 echo '<table>';
 echo '<tr><td>';
 echo "<span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&action_=commande'; style=cursor:pointer> COMMANDE </span";
 echo '</td></tr><tr><td>';
 echo "<span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&action_=devis'; style=cursor:pointer> DEVIS </span";
 echo '</td></tr>';
 echo '</table>';
}

if($menu_ == 'stats'){
 echo '<span class=titre1>STATS</span>';
 echo '<br><br>';
 echo '<table>';
 echo '<tr><td>';
 echo "<span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&stats_=clients'; style=cursor:pointer> CLIENTS </span";
 echo '</td></tr><tr><td>';
 echo "<span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&stats_=fournisseurs'; style=cursor:pointer> FOURNISSEURS </span";
 echo '</td></tr>';
 echo '</table>';

}

if($menu_ == 'info'){
 echo '<span class=titre1>INFO</span>';
 echo '<br><br>';
 echo '<table>';
 echo '<tr><td>';
 echo "<span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&info_=comptes'; style=cursor:pointer> COMPTES </span";
 echo '</td></tr><tr><td>';
 echo "<span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&info_=contact'; style=cursor:pointer> CONTACT </span";
 echo '</td></tr>';
 echo '</table>';
}





?>