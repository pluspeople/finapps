<?php
require_once("../include/Configuration.php");

$util = WebUtility::instantiate();
if ($_SERVER["SERVER_NAME"] == "www.dreamcakes.co.ke") {
	$util->redirect('10_login.php');
} else {
	$util->redirect("01_front.php");
}

?>