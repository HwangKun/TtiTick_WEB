<?php
require 'smarty/libs/Smarty.class.php';

$smarty = new Smarty();

$smarty->template_dir = 'themes';

$smarty->assign('name', 'Ned');
$smarty->display('index.tpl');
?>
