<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('03_payment.tpl');

$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);


/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {



}



//////////////////////// MAIN DISPLAY
$orderlines = (array)@$_SESSION["ORDERLINES"];

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
											"ITEM_UNITPRICE" => $orderline[0]->getTotalPrice(),
											"ITEM_TOTAL" => $total));
			
	$slow->parse("Item");
}


$slow->assign(array("CSS_FILE" => "css.php",
										"GRAND_TOTAL" => $grandTotal,
										"NAME_VALUE" => @$_SESSION["ORDER_NAME"],
										"PHONE_VALUE" => @$_SESSION["ORDER_PHONE"],
										"EMAIL_VALUE" => @$_SESSION["ORDER_EMAIL"],
										"ADDRESS_VALUE" => @$_SESSION["ORDER_ADDRESS"],
										"STREET_VALUE" => @$_SESSION["ORDER_STREET"]
										));


$slow->parse();
$slow->slowPrint();

?>