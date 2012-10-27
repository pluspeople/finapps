<?php
require_once("../include/Configuration.php");

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('css.tpl');

header('Content-type: text/css'); 

if (isset($_GET["id"])) {
	$solution = SolutionFactory::factoryOne($_GET["id"]);
} else {
	$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);
}

$slow->assign(array("MAIN_COLOR" => $solution->getMainColor(),
										"SEC_COLOR" => $solution->getSecondaryColor(),
										"LOGO_URL" => "logo.php?id=" . $solution->getId()));


$slow->parse();
$slow->slowPrint();

?>