<?php
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
		"DatabaseDatabaseRead"				=> "uhasibu",
		"DatabaseHostWrite"						=> "localhost",
		"DatabaseUserWrite"						=> "root",
		"DatabasePasswordWrite"				=> "ture",
		"DatabaseDatabaseWrite"				=> "uhasibu",

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
