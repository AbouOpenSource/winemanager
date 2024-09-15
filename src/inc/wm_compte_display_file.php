<?php
$color_title='#B3B3B3';
?>

<table width=100% cellpadding=0 align=center border=0 class=style_form_1>
<tr>
<td class=titre2 bgcolor=<?php  echo $color_title; ?> align=left> LISTE DES COMMANDES FOURNISSEURS</span>
</td>
</tr>

<tr>
<td>

<?php
$dir = 'users/'.$login.'/commandes_pdf/';
echo '<br/>';

	if ($a = opendir($dir)) 
	{
   		$i=0;
		$nb_img=0;
		/* LECTURE DU DOSSIER */
		while (false !== ($fichier = readdir($a)))
		{
        	if($i>1)
			{
				/* CONCATENATION : répertoire\fichier */
				$directory=$dir.'/'.$fichier;
				?>
				<a href="<? echo $directory; ?>" <span class="Style1"><? echo $fichier ; ?></span> </a>
				<br>
				<?php
				$nb_img++;
			}
			$i++;
    	}
    closedir($a);
}

?>

</td>
</tr>

</table>
