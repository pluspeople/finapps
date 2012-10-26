<?php

ini_set("include_path", "/home/a1646/public_html/include:./");
$singletonArray = array();

class Configuration {
	# Template system.

	protected $configArray=array(
    "GeneralProductionMode"       => false,															 
 		"Site:"												=> "",
 		"SiteUrl"											=> "dev.dreamcakes.co.ke",
		"Version"                     => "1.0.0",
		"ProductionMode"              => false,
 		
		"Database:"										=> "",
		"DatabaseType"								=> "mysql",
		"DatabaseHostRead"						=> "localhost",
		"DatabaseUserRead"						=> "root",
		"DatabasePasswordRead"				=> "ture",
		"DatabaseDatabaseRead"				=> "2012_finapps",
		"DatabaseHostWrite"						=> "localhost",
		"DatabaseUserWrite"						=> "root",
		"DatabasePasswordWrite"				=> "ture",
		"DatabaseDatabaseWrite"				=> "2012_finapps",

		"ConvertPath"                 => "/opt/local/bin/convert",
	);

#################################################################
#################################################################
	function getConfig($argument) {
		return $this->configArray[$argument];
	}

	static function instantiate() {
		global $singletonArray;
		if (!array_key_exists("Configuration", $singletonArray)) {
			$singletonArray["Configuration"] = new Configuration();
		}
		return $singletonArray["Configuration"];
	}
}

function __autoload($class) {
	//	$fileName = str_replace("\\", "/", $class);
	//	$fileName = ltrim(str_ireplace("uhasibu/", "/", $fileName), "/") . ".php";
	$fileName = $class . ".php";
	require_once($fileName);
}

?>
