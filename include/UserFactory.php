<?php
/*
 This legal notice is only available in English.
 
 Copyright 2001-2012 PLUSPeople All rights reserved.
 No use, copying or distribution of this work may be made except
 in accordance with a valid written agreement from PLUSPeople.
 This notice must be included on all copies, modifications and
 derivatives of this work.
 
 If you have any questions about this legal notice, please contact
 PLUSPeople at the following e-mail address: info@pluspeople.dk
*/

require_once("../include/Configuration.php");

class UserFactory {
  ############### Properties ####################
  const SELECTLIST = "
SELECT id,
solution_id,
login,
password ";

  # # # # # # # # misc methods # # # # # # # #

  static public function factoryOne($id) {
    $db = Database::instantiate(Database::TYPE_READ);
    $id = (int)$id;

	  $query = UserFactory::SELECTLIST . "
							FROM  user
							WHERE	id = '$id' ";
		
		if ($result = $db->query($query) AND $foo = $db->fetchObject($result)) {
		  $returnval = new User($foo->id, $foo);
		  $db->freeResult($result);
		  return $returnval;
		}
  }

  static function factoryAll() {
    $db = Database::instantiate(Database::TYPE_READ);

	  $query = UserFactory::SELECTLIST . "
							FROM  user ";
		
		$tempArray = array();
		if ($result = $db->query($query)) {
			while($foo = $db->fetchObject($result)) {
				$tempArray[] = new User($foo->id, $foo);
			}
			$db->freeResult($result);
		}
		return $tempArray;
  }

  static function factoryByLogin($login, $password) {
    $db = Database::instantiate(Database::TYPE_READ);

	  $query = UserFactory::SELECTLIST . "
							FROM  user
              WHERE login='" . $db->dbIn($login) . "'
              AND   password='" . $db->dbIn(md5($password)) . "'";

		$tempArray = array();
		if ($result = $db->query($query)) {
			while($foo = $db->fetchObject($result)) {
				$tempArray[] = new User($foo->id, $foo);
			}
			$db->freeResult($result);
		}
		return $tempArray;
  }
}
?>