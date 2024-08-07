<?php

session_start();

include('inc/variables_site.php');

$page_php = 'index.php';
insert_tb_log($page_php);

if ($status = 'disconnected') {
// On ecrase le tableau de session
$_SESSION = array();
// On detruit la session
session_destroy();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<?php

echo '<head>';
echo '<meta name=author content=' . $author . '>';
echo '<title>Wine Manager Connection</title>';
echo '<link rel=stylesheet href=wm_style_site.css>';
echo '</head>';
echo '<body>';

include('inc/wm_form_index.php');

echo '</body>';
echo '</html>';
?>
