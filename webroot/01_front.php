<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('01_front.tpl');

$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);
$openCategoryId = 0;

if (isset($_GET["open"])) {
	$openCategoryId = (int)$_GET["open"];
}


/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$orderlines = isset($_SESSION["ORDERLINES"]) ? (array)$_SESSION["ORDERLINES"] : array();
	$temp = array();

	if (isset($_POST["buy"])) {
		$item = null;
		if (isset($_POST["buyId"])) {
			$item = ProductFactory::factoryOne((int)$_POST["buyId"]);
		}
		if (is_object($item)) {
			$set = false;
			for ($i = 0; $i < count($orderlines); $i++) {
				if ($orderlines[$i][0]->getId() == $item->getId() AND $orderlines[$i][2] != -1) {
					$orderlines[$i][1]++;
					$set = true;
				}
			}
			if (!$set) {
				$orderlines[] = array($item, 1, 0);
			}
			$openCategoryId = $item->getProductCategoryId();
		}
	}	elseif (isset($_POST["delete"]) AND isset($_POST["delId"])) {
		$delId = (int)$_POST["delId"];
		for ($i = 0; $i < count($orderlines); $i++) {
			if ($orderlines[$i][0]->getId() == $delId) {
				if ($orderlines[$i][1] > 1) {
					$orderlines[$i][1]--;
				} else {
					$left = $i;
					$right = $i+1;
					if ($orderlines[$left][2] == -1) {
						while ($right <= count($orderlines) AND $orderlines[$left][0]->getId() == $orderlines[$right][2]) {
							$right++;
						}
					}
					$orderlines = array_merge(array_slice($orderlines, 0, $left), array_slice($orderlines, $right, count($orderlines)-$i-1));
				}
				break;
			}
		}
		$openCategoryId = -1;
	}

	$_SESSION["ORDERLINES"] = $orderlines;

	$util = WebUtility::instantiate();

	if (isset($_POST["order"]) AND count($orderlines) > 0) {
		$util->redirect('02_basket.php' . "?open=" . $openCategoryId);
	} else {
		$util->redirect('01_front.php' . "?open=" . $openCategoryId);
	}
}


//////////////////////// BASKET DISPLAY
$orderlines = (array)@$_SESSION["ORDERLINES"];

// BASKET
if (count($orderlines)) {
	$amount = 0;
	$total = 0;
	$alternating = true;
	foreach ($orderlines AS $orderline) {
		// Variety
		$name = $orderline[0]->getName();
		$price = $orderline[1] * $orderline[0]->getTotalPrice();
		$total += $price;
					
		$slow->assign(array("ITEM_ID" => $orderline[0]->getId(),
												"ITEM_NAME" => $name,
												"ITEM_PRICE" => number_format($price/100, 2, '.', ','),
												"ITEM_AMOUNT" => $orderline[1],
												"ITEM_DARK" => ($alternating ? "dark" : "")));

		$amount += $orderline[1];
		$alternating = !$alternating;
		$slow->parse("Basket_item");
	}
	$slow->parse("Basket_item_wrap");

	$slow->assign(array("ITEMS_AMOUNT" => $amount,
											"ITEMS_TOTAL" => number_format($total/100, 2, '.', ','),
											"TOTAL_DARK" => ($alternating ? "dark" : "")));

	$slow->parse("Basket_wrap");
}




//////////////////////// MENU DISPLAY
$categories = ProductCategoryFactory::factoryBySolution($solution->getId());
foreach ($categories AS $cat) {
	$slow->assign(array("CATEGORY_NAME" => $cat->getName(),
											"CATEGORY_OPEN" => ($cat->getId() == $openCategoryId ? '1' : '0'),
											"CATEGORY_DESCRIPTION" => $cat->getFormatedDescription()));

	$products = $cat->getProducts();
	$alternating = false;
	foreach($products AS $product) {
		$slow->assign(array("ITEM_ID" => $product->getId(),
												"ITEM_NAME" => $product->getName(),
												"ITEM_PRICE" => $product->getFormatedTotalPrice(),
												"ITEM_DARK" => ($alternating ? "dark" : "")
												));
		$alternating = !$alternating;

		$slow->parse("Item");
		if (trim($product->getDescription()) != "") {
			$slow->parse("Item_description");
		}
	}

	if (count($products) > 0) {
		$slow->parse("Category");
	}
}



$slow->assign(array("CSS_FILE" => "css.php",
										"OPEN_BASKET" => $openCategoryId == -1 ? "true" : "false"));



$slow->parse();
$slow->slowPrint();

?>