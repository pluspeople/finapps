<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('13_revenue.tpl');
$util = WebUtility::instantiate();

// Only Loged in
$user = UserFactory::factoryOne((int)@$_SESSION["userid_from_cookie"]);
if (!is_object($user)) {
	$util->redirect('10_login.php');
}
$solution = $user->getSolution();


/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

}



//////////////////////// MAIN DISPLAY

for ($i=0; $i < 12; $i++) {
	$date = mktime(12,0,0, date("n")-$i, 15);
	
	$amount = 0;
	$orders = OrderFactory::factoryByMonth($solution->getId(), $date);
	foreach ($orders AS $order) {
		$amount += $order->getTotalPrice();
	}

	$slow->assign(array("MONTH_NAME" => date("F Y", $date),
											"MONTH_SALE" => number_format($amount/100, 2, '.', ',')
											));

	$slow->parse("Month");
}

$slow->assign(array("CSS_FILE" => "css.php?id=" . $solution->getId()));

$slow->parse();
$slow->slowPrint();

?>