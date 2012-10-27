<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('03_payment.tpl');
$util = WebUtility::instantiate();

$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);

$error = "";

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["login"] != "" AND $_POST["passw"] != "" AND $_POST["card"]) {
		$orderlines = (array)@$_SESSION["ORDERLINES"];

		$order = Order::createNew($solution->getId());
		$order->setProcessStepId(Order::AWAITING_BUSINESS);
		$order->setName($_SESSION["ORDER_NAME"]);
		$order->setPhone($_SESSION["ORDER_PHONE"]);
		$order->setEmail($_SESSION["ORDER_EMAIL"]);
		$order->setAddress($_SESSION["ORDER_ADDRESS"]);

		$order->update();

		$orderValue = 0;
		foreach ($orderlines AS $orderline) {
			$line = OrderLine::createNew($order->getId());
			$line->setProductId($orderline[0]->getId());
			$line->setName($orderline[0]->getName());
			$line->setDescription($orderline[0]->getDescription());
			$line->setPrice($orderline[0]->getTotalPrice());
			$line->setCost($orderline[0]->getCost());
			$line->setAmount($orderline[1]);

			$line->update();

			$orderValue += $orderline[0]->getTotalPrice() * $orderline[1];
		}

		$order->setTotalPrice($orderValue);
		$order->update();


		/*
		$fin = new FinAppsApi();
		$data = $fin->login($solution->getAccount(), $_POST["passw"]);
		$token = $data->token;
		$data = $fin->getPayment($token, $_POST["card"], $orderValue/100);
		$code = $data->data->code;
		$data = $fin->doPayment($token, $code, $solution->getAccount());

		if ($data->status == "ERROR") {
			$error = $data->msg;
		}
		*/

		

		session_unset();
		$util->redirect('04_thank.php');
	}
}



//////////////////////// MAIN DISPLAY
$orderlines = (array)@$_SESSION["ORDERLINES"];

$slow->assign(array("CSS_FILE" => "css.php"
										));


$slow->parse();
$slow->slowPrint();

?>