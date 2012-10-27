<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('18_editproduct.tpl');
$util = WebUtility::instantiate();

// Only Loged in
$user = UserFactory::factoryOne((int)@$_SESSION["userid_from_cookie"]);
if (!is_object($user)) {
	$util->redirect('10_login.php');
}
$solution = $user->getSolution();

// ADD NEW PRODUCT
if (isset($_POST["trash"])) {
	$product = ProductFactory::factoryOne($_GET["id"]);
	if (is_object($product)) {
		$category = $product->getProductCategory();
		if (is_object($category)) {
			$prodSolution = $category->getSolution();
			if ($prodSolution->getId() == $solution->getId()) {
				$product->delete();
				$util->redirect('16_products.php');
			}
		}
	} else {
		$util->redirect('16_products.php');
	}
}


if (isset($_GET["new"])) {
	$category = ProductCategoryFactory::factoryOne($_GET["new"]);
	if (is_object($category)) {
		$prodSolution = $category->getSolution();
		if ($prodSolution->getId() == $solution->getId()) {
			$product = Product::createNew($category->getId());
			$product->setName("New Product" . $product->getId());
			$product->setVatRate(21);
			$product->update();

			$util->redirect('18_editproduct.php?id=' . $product->getId());
		}
	}
}



// SANITY CHECK
$product = ProductFactory::factoryOne($_GET["id"]);
if (is_object($product)) {
	$category = $product->getProductCategory();
	if (is_object($category)) {
		$prodSolution = $category->getSolution();
		if ($prodSolution->getId() != $solution->getId()) {
			$util->redirect('16_products.php');
		}
	}
} else {
	$util->redirect('16_products.php');
}

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["OK"])) {
		$product->setName($_POST["name"]);
		$product->setDescription($_POST["description"]);
		$product->setPrice($util->numberInput($_POST["price"]));
		$product->setCost($util->numberInput($_POST["cost"]));
		$product->setVatRate($_POST["vat"]);

		$product->update();
		
		//		$util->redirect("16_products.php");
	}
}



//////////////////////// MAIN DISPLAY


$slow->assign(array("NAME" => $product->getName(),
										"DESCRIPTION" => $product->getDescription(),
										"PRICE" => number_format($product->getPrice()/100, 2, '.', ','),
										"COST" => number_format($product->getCost()/100, 2, '.', ','),
										"VAT_RATE" => $product->getVatRate()
										));


$slow->assign(array("CSS_FILE" => "css.php?id=" . $solution->getId()));


$slow->parse();
$slow->slowPrint();

?>