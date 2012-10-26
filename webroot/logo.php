<?php
require_once("../include/Configuration.php");

$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);
if (is_object($solution)) {
	header('Content-type: ' . $solution->getLogoType()); 
	print $solution->getLogo();
}

$slow->parse();
$slow->slowPrint();

?>