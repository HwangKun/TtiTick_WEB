<?php
include("include/smarty.php");

$smarty->setTemplateDir('themes/');

$smarty->assign('name', 'Ned');

$smarty->display('header.tpl');
$smarty->display('index.tpl');
$smarty->display('footer.tpl');
?>
