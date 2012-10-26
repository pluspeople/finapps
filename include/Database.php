<?php
/*
 This legal notice is only available in English.
 
 Taesk CMS is Copyright 2001-2009 PLUSPEOPLE Aps - www.pluspeople.dk
 Taesk CMS is released under the GPLv3 licence, for full information
 regarding the GPLv3 licence see the included licence file.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 If the GPLv3 licence does not fullfill your (commercial) needs then 
 contact PLUSPEOPLE regarding an alternative licence agreement.

 If you have any questions about this legal notice, please contact
 PLUSPEOPLE at the following e-mail address: info@pluspeople.dk
*/
require_once("Configuration.php");

class Database {
	############## Properties ####################
	const TYPE_READ = "Read";
	const TYPE_WRITE = "Write";

	protected $config;
	protected $queryAmount = 0;
	protected $dbId = 0;

	############## Methods #######################
	# # # # # # # # Initializer # # # # # # # # # #
	protected function __construct($type) {
		$this->config = Configuration::instantiate();

		// if we need to use same credentials to the database then we need to use mysql_connect instead of mysql_pconnect.
		$this->dbId = mysql_pconnect($this->config->getConfig("DatabaseHost" . $type),$this->config->getConfig("DatabaseUser" . $type),$this->config->getConfig("DatabasePassword" . $type), true);
		if ($this->dbId > 0) {
			if (!mysql_select_db($this->config->getConfig("DatabaseDatabase" . $type), $this->dbId)) {
				exit;
			}
		}
	}

	// use this to check how many querys are posted.
	public function getQueryAmount() {
		return $this->queryAmount;		
	}

	public static function instantiate($type = Database::TYPE_READ) {
		global $singletonArray;

		if (!isset($singletonArray["Database" . $type] )) {
			$singletonArray["Database" . $type] = new Database($type);
		}
		return $singletonArray["Database" . $type];
	}

	public function dbIn($input) {
		return addslashes($input);
	}

	public function dbOut($input) {
		return stripslashes($input);
	}

	public function query($input) {
		++$this->queryAmount;
		return mysql_query($input, $this->dbId);		
	}

	public function fetchObject($input) {
		return mysql_fetch_object($input);
	}

	public function freeResult($input) {
		return mysql_free_result($input);
	}

	public function insertId() {
    return mysql_insert_id($this->dbId);
	} 

	public function affectedRows() {
		return mysql_affected_rows($this->dbId);
	}

	public function numRows($input) {
		return mysql_num_rows($input);
	}
}
?>