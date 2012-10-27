<?php
require_once("../include/Configuration.php");
session_start();

$slow = new SlowTemplate("/template", true);
$slow->setTemplateFile('30_signup.tpl');
$util = WebUtility::instantiate();

/*
$fin = new FinAppsApi();
for ($i = 0; $i < 500; $i++) {
	$fin->getOfficeList("c7f-b44e-c6ae088fe7d5");
}
exit();
*/

/////////////////// POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["sign"])) {
		if ($_POST["name"] != "" AND $_POST["domain"] != "" AND $util->validateEmail($_POST["email"])) {
			$colors = array(array('#DFC184', '#274257'),
											array('#EC6C3F', '#F9D654'),
											array('#9CB770', '#C7E1BA'),
											array('#C15D63', '#FEFEE8'),
											array('#017890', '#613D2D'),
											array('#DF7782', '#E95D22'),
											array('#2F2F2F', '#CCB647'),
											array('#003366', '#CCCCCC'),
											array('#FF3333', '#999999'),
											array('#669999', '#003333')
											);

			$solution = Solution::createNew($_POST["domain"]);
			$domain = $_POST["domain"] . ".dreamcakes.co.ke";
			$solution->setName($_POST["name"]);
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

			// Create merchant account.
			$fin = new FinAppsApi();
			$fin->createCommerce($solution->getId(), $pw, $solution->getName());
			$data = $fin->login($solution->getId(), $pw);
			$officeId = "508a8988e4b0a7694d240e8d";
			$data = $fin->createAccount($data->token, $officeId);
			$solution->setAccount($data->data->id);
			$solution->update();


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