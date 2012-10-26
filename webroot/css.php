<?php
require_once("../include/Configuration.php");

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('css.tpl');

header('Content-type: text/css'); 

$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);

$slow->assign(array("MAIN_COLOR" => $solution->getMainColor(),
										"SEC_COLOR" => $solution->getSecondaryColor()));


$slow->parse();
$slow->slowPrint();

?>