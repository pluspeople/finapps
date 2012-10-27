<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('30_signup.tpl');
$util = WebUtility::instantiate();

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["sign"])) {
		if ($_POST["name"] != "" AND $_POST["domain"] != "" AND WebUtility::validateEmail($_POST["email"])) {
			$colors = array(array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f'),
											array('#000000', '#d90d6f')
											);


			$solution = Solution::createNew($_POST["domain"]);
			$domain = $_POST["domain"] . ".dreamcakes.co.ke";
			$solution->setDomain($domain);
			$solution->setEmail($_POST["email"]);
			$col = $colors[rand(0, count($colors)-1)];
			$solution->setMainColor($col[0]);
			$solution->setSecondaryColor($col[1]);

			$solution->update();

			$user = User::createNew($solution->getId());
			$user->setLogin($solution->getEmail());
			$pw = $util->generatePassword(8);
			$user->setPassword($pw);

			$toEmail = $_POST["email"];
			$mail = "Welcome to the Dreamcakes solution - developed for FinAppsParty 2012\n\n";
			$mail .= "You can access your new mobile solution visit: http://" . $domain . "\n\n";
			$mail .= "To access the business dashboard login on http://www.dreamcakes.co.ke\n";
			$mail .= "Your login is: " . $toEmail . "\n";
			$mail .= "Your password is: " . $pw . "\n\n";
			$mail .= "Any support questions can be sent to support@uhasibu.co.ke\n\n";
			$mail .= "Enjoy the system\n";
			$mail .= "Team Dreamcakes 2012\n";

			$subject = "Dreamcake registration";

			mail($toEmail, $subject, $mail);

			//
			$_SESSION["userid_from_cookie"] = $user->getId();
			$util->redirect('11_dashboard.php');
		}
	} else {
		$slow->parse("Error");
	}
}



//////////////////////// MAIN DISPLAY

$slow->assign(array("CSS_FILE" => "css.php?id=1"));


$slow->parse();
$slow->slowPrint();

?>