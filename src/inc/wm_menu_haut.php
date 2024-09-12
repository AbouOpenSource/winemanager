<?php

echo '<table border=0>';
echo '<tr>';
echo '<td> &nbsp;&nbsp;&nbsp;&nbsp; </td>';
echo "<td> <span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&tiers_=client'; style=cursor:pointer> CLIENTS </span></td>"; 
echo '<td> &nbsp;&nbsp;&nbsp;&nbsp; </td>';
echo "<td> <span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&tiers_=fournisseurs'; style=cursor:pointer> FOURNISSEURS </span></td>";
echo '<td> &nbsp;&nbsp;&nbsp;&nbsp; </td>';
echo "<td> <span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&action_=commande'; style=cursor:pointer> COMMANDES </span></td>";
echo '<td> &nbsp;&nbsp;&nbsp;&nbsp; </td>';
echo "<td> <span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&action_=devis'; style=cursor:pointer> DEVIS </span></td>";
echo '<td> &nbsp;&nbsp;&nbsp;&nbsp; </td>';
echo "<td> <span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&stats_=stats'; style=cursor:pointer>STATS </span></td>";
echo '<td> &nbsp;&nbsp;&nbsp;&nbsp; </td>';
echo "<td> <span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&calendrier_=calendrier'; style=cursor:pointer>CALENDRIER </span></td>";
echo '<td> &nbsp;&nbsp;&nbsp;&nbsp; </td>';
echo "<td> <span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=n_a&pdf_=pdf'; style=cursor:pointer>PDF </span></td>";
if ($_SESSION['flag_admin']=='O') {
echo '<td> &nbsp;&nbsp;&nbsp;&nbsp; </td>';
echo "<td> <span class=menu_gauche onClick=document.location='wm_accueil.php?menu_=compte_liste'; style=cursor:pointer>USERS </span></td>";

}

echo '</tr>';
echo '</table>';

?>