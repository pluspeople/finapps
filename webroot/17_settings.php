<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('17_settings.tpl');
$util = WebUtility::instantiate();

// Only Loged in
$user = UserFactory::factoryOne((int)@$_SESSION["userid_from_cookie"]);
if (!is_object($user)) {
	$util->redirect('10_login.php');
}
$solution = $user->getSolution();


/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$solution->setName($_POST["name"]);
	$solution->setMainColor($_POST["bgcolor"]);
	$solution->setSecondaryColor($_POST["fgcolor"]);

	$solution->update();

	$util->redirect('11_dashboard.php');
}



//////////////////////// MAIN DISPLAY


$slow->assign(array("NAME" => $solution->getName(),
										"DOMAIN" => $solution->getDomain(),
										"BGCOLOR" => $solution->getMainColor(),
										"FGCOLOR" => $solution->getSecondaryColor(),
										"LOGO" => "logo.php?id=" . $solution->getId()
										));




$slow->assign(array("CSS_FILE" => "css.php?id=" . $solution->getId()));


$slow->parse();
$slow->slowPrint();

?>