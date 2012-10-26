<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('16_products.tpl');
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

$categories = ProductCategoryFactory::factoryBySolution($solution->getId());
foreach ($categories AS $cat) {
	$slow->assign(array("CATEGORY_NAME" => $cat->getName(),
											"CATEGORY_ID" => $cat->getId(),
											"CATEGORY_DESCRIPTION" => $cat->getFormatedDescription()));

	$products = $cat->getProducts();
	$alternating = false;
	foreach($products AS $product) {
		$slow->assign(array("ITEM_ID" => $product->getId(),
												"ITEM_NAME" => $product->getName(),
												"ITEM_PRICE" => $product->getFormatedTotalPrice(),
												"ITEM_DESCRIPTION" => nl2br($product->getDescription())
												));
		$alternating = !$alternating;

		if (trim($product->getDescription()) != "") {
			$slow->parse("Item_description");
		}
		$slow->parse("Item");
	}

	$slow->parse("Category");
}


$slow->assign(array("CSS_FILE" => "css.php?id=" . $solution->getId()));


$slow->parse();
$slow->slowPrint();

?>