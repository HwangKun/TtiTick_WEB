<?php

require_once 'smarty/libs/Smarty.class.php';
$smarty = new Smarty();

$smarty->setCompileDir('smarty/templates_c/');
$smarty->setConfigDir('smarty/config/');
$smarty->setCacheDir('smarty/cache/');
$smarty->caching = Smarty::CACHING_LIFETIME_CURRENT;

?>