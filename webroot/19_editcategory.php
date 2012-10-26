<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('19_editcategory.tpl');
$util = WebUtility::instantiate();

// Only Loged in
$user = UserFactory::factoryOne((int)@$_SESSION["userid_from_cookie"]);
if (!is_object($user)) {
	$util->redirect('10_login.php');
}
$solution = $user->getSolution();

// ADD NEW CATEGORY
if (isset($_GET["new"])) {
	$category = ProductCategory::createNew($solution->getId());
	$category->setname("New Category " . $category->getId());
	$category->update();

	$util->redirect('19_editcategory.php?id=' . $category->getId());
}



// SANITY CHECK
$category = ProductCategoryFactory::factoryOne($_GET["id"]);
if (is_object($category)) {
	$prodSolution = $category->getSolution();
	if ($prodSolution->getId() != $solution->getId()) {
		$util->redirect('16_products.php');
	}
} else {
	$util->redirect('16_products.php');
}

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["OK"])) {
		$category->setName($_POST["name"]);
		$category->setDescription($_POST["description"]);

		$category->update();
		
		$util->redirect("16_products.php");
	}
}



//////////////////////// MAIN DISPLAY


$slow->assign(array("NAME" => $category->getName(),
										"DESCRIPTION" => $category->getDescription()
										));


$slow->parse();
$slow->slowPrint();

?>