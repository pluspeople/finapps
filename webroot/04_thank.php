<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('04_thank.tpl');

$solution = SolutionFactory::factoryByDomain($_SERVER["SERVER_NAME"]);

$error = "";

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
}



//////////////////////// MAIN DISPLAY
$orderlines = (array)@$_SESSION["ORDERLINES"];

$slow->assign(array("CSS_FILE" => "css.php"
										));


$slow->parse();
$slow->slowPrint();

?>