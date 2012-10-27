<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('02_basket.tpl');

$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);
$openCategoryId = 0;

if (isset($_GET["open"])) {
	$openCategoryId = (int)$_GET["open"];
}

$error = false;

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["continue"]) OR isset($_POST["back"]) OR isset($_POST["update"])) {
		$util = WebUtility::instantiate();

		// Determine ordervalue
		$orderlines = $_SESSION["ORDERLINES"];
		$orderValue = 0;
		foreach ($orderlines AS $orderline) {
			$orderValue += $orderline[0]->getTotalPrice() * $orderline[1];
		}
		
		// store session entries
		$_SESSION["ORDER_NAME"] = $_POST["name"];
		$_SESSION["ORDER_PHONE"] = $_POST["phone"];
		$_SESSION["ORDER_EMAIL"] = $_POST["email"];
		$_SESSION["ORDER_ADDRESS"] = $_POST["address"];
		
		if (isset($_POST["continue"])) {
			if ($_SESSION["ORDER_NAME"] != "" AND $_SESSION["ORDER_PHONE"] != "" AND $_SESSION["ORDER_EMAIL"] != "" AND count($_SESSION["ORDERLINES"]) > 0) {
				$util->redirect('03_payment.php');
			} else {
				$error = true;
			}
		} elseif (isset($_POST["back"])) {
			$util->redirect('01_front.php');
		}
	}
}



//////////////////////// MAIN DISPLAY
$orderlines = (array)@$_SESSION["ORDERLINES"];

if ($error) {
	$slow->parse("Error");
}

// display full order of items
$grandTotal = 0;
foreach ($orderlines AS $orderline) {
	$total = $orderline[0]->getTotalPrice() * $orderline[1];
	$grandTotal += $total;
	if ($orderline[2] > 0 AND $total == 0) {
		$total = "&nbsp;";
	}

	$name = $orderline[0]->getName();

	$slow->assign(array("ITEM_ID" => $orderline[0]->getId(),
											"ITEM_NAME" => $name,
											"ITEM_AMOUNT" => $orderline[1],
											"ITEM_UNITPRICE" => number_format($orderline[0]->getTotalPrice()/100, 2, '.', ','),
											"ITEM_TOTAL" => number_format($total/100, 2, '.', ',')
											));
			
	$slow->parse("Item");
}


$slow->assign(array("CSS_FILE" => "css.php",
										"GRAND_TOTAL" => number_format($grandTotal/100, 2, '.', ','),
										"NAME_VALUE" => @$_SESSION["ORDER_NAME"],
										"PHONE_VALUE" => @$_SESSION["ORDER_PHONE"],
										"EMAIL_VALUE" => @$_SESSION["ORDER_EMAIL"],
										"ADDRESS_VALUE" => @$_SESSION["ORDER_ADDRESS"],
										"STREET_VALUE" => @$_SESSION["ORDER_STREET"]
										));


$slow->parse();
$slow->slowPrint();

?>