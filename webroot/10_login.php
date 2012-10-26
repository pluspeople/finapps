<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('10_login.tpl');
$util = WebUtility::instantiate();

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//# L O G I N  H A N D L I N G
	$login = $_POST["login"];
	$password = $_POST["password"];
	
	if ($util->checkSubmit("ok") AND $login != "" AND $password != "") {
		$users = UserFactory::factoryByLogin($login, $password);
		
		if (count($users) == 1) {
			$_SESSION["userid_from_cookie"] = $users[0]->getId();
			$util->redirect('11_dashboard.php');
			exit;
		} else {
			$slow->parse("Error1");
		}
	}
}



//////////////////////// MAIN DISPLAY

//$slow->assign(array("CSS_FILE" => "css.php?id=" . $solution->getId()));
$slow->assign(array("CSS_FILE" => "css.php?id=1"));


$slow->parse();
$slow->slowPrint();

?>