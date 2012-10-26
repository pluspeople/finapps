<?php
require_once("../include/Configuration.php");

if (isset($_GET["id"])) {
	$solution = SolutionFactory::factoryOne($_GET["id"]);
} else {
	$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);
}

if (is_object($solution)) {
	header('Content-type: ' . $solution->getLogoType()); 
	print $solution->getLogo();
}

$slow->parse();
$slow->slowPrint();

?>