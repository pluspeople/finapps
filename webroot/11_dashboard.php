<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('11_dashboard.tpl');
$util = WebUtility::instantiate();

// Only Loged in
$user = UserFactory::factoryOne((int)@$_SESSION["userid_from_cookie"]);
if (!is_object($user)) {
	$util->redirect('10_login.php');
}
$solution = $user->getSolution();


/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["openorders"])) {
		$util->redirect("15_orders.php");
	}
	
	if (isset($_POST["revenue"])) {
		$util->redirect("13_revenue.php");
	}

	if (isset($_POST["profit"])) {
		$util->redirect("14_profit.php");
	}

	if (isset($_POST["orders"])) {
		$util->redirect("15_orders.php");
	}

	if (isset($_POST["products"])) {
		$util->redirect("16_products.php");
	}

	if (isset($_POST["settings"])) {
		$util->redirect("17_settings.php");
	}

}



//////////////////////// MAIN DISPLAY



$waiting = OrderFactory::factoryByStep($solution->getId(), Order::AWAITING_BUSINESS);
$amount = count($waiting);
if ($amount > 0) {
	$slow->assign(array("WAITING_ORDERS" => $amount));
	$slow->parse("Open_orders");
}

$slow->assign(array("CSS_FILE" => "css.php?id=" . $solution->getId()));


$slow->parse();
$slow->slowPrint();

?>