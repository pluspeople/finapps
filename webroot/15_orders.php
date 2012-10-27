<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('15_orders.tpl');
$util = WebUtility::instantiate();

// Only Loged in
$user = UserFactory::factoryOne((int)@$_SESSION["userid_from_cookie"]);
if (!is_object($user)) {
	$util->redirect('10_login.php');
}
$solution = $user->getSolution();


/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["orderId"])) {
		$order = OrderFactory::factoryOne($_POST["orderId"]);
		if (is_object($order) AND $order->getSolutionId() == $solution->getId()) {
			if (isset($_POST["accept"])) {
				$order->setProcessStepId(Order::ACCEPTED_ORDER);
				$order->update();
			} elseif (isset($_POST["refuse"])) {
				$order->setProcessStepId(Order::REFUSED_ORDER);
				$order->update();
			}
			$util->redirect('15_orders.php');
		}
	}
}



//////////////////////// MAIN DISPLAY

$orders = OrderFactory::factoryByStep($solution->getId(), Order::AWAITING_BUSINESS);
$alternating = false;
foreach ($orders AS $order) {
	$slow->assign(array("ORDER_ID" => $order->getId(),
											"ORDER_NAME" => $order->getName(),
											"ORDER_PHONE" => $order->getPhone(),
											"ORDER_EMAIL" => $order->getEmail(),
											"ORDER_ADDRESS" => nl2br($order->getAddress()),
											"DARK" => ($alternating ? "dark" : "")
											));

	$alternating = !$alternating;
	
	$lines = OrderLineFactory::factoryByOrder($order->getId());
	foreach ($lines AS $line) {
		$slow->assign(array("LINE_AMOUNT" => $line->getAmount(),
												"LINE_NAME" => $line->getName()));

		$slow->parse("Line");
	}

	$slow->parse("Order");
}


$slow->assign(array("CSS_FILE" => "css.php?id=" . $solution->getId()));

$slow->parse();
$slow->slowPrint();

?>