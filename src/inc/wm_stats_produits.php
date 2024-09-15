<?php
$color_title='#B3B3B3';

echo '<table width=100%>';

echo '<tr><td>';
	f_affiche_stat_produit ($login, $flag_client_fournisseur, 'N', $id_client);
	f_affiche_stat_produit ($login, $flag_client_fournisseur, 'Y', $id_client);
echo '</td></tr>'; 


echo '</td>';
echo '</tr>';
echo '</table>';
?>