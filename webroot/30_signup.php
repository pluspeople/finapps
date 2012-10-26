<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('30_signup.tpl');
$util = WebUtility::instantiate();

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

}



//////////////////////// MAIN DISPLAY

$slow->assign(array("CSS_FILE" => "css.php?id=1"));


$slow->parse();
$slow->slowPrint();

?>