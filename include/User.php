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

require_once("Configuration.php");

class User {
  ############### Properties ####################


  protected $id = 0;
  protected $solutionId = 0;
  protected $login = "";
  protected $password = "";

  protected $idUpdated = false;
  protected $solutionIdUpdated = false;
  protected $loginUpdated = false;
  protected $passwordUpdated = false;

  protected $isDataRetrived = false;

  # # # # # # # # Initializer # # # # # # # # # #
  public function __construct($id, $initValues=NULL) {
    $this->id = (int)$id;
    #initValues is an object with values for fast restoring state (optimisation)
    if (isset($initValues)) {
      $this->assignValues($initValues);
    }
  }
  # # # # # # # # get/set methods # # # # # # # #
  public function getId() {
    return $this->id;
  }

	public function getSolution() {
		return SolutionFactory::factoryOne($this->getSolutionId());
	}
  public function getSolutionId() {
    $this->retriveData();
    return $this->solutionId;
  }
  public function setSolutionId($input) {
    $this->solutionId = (int)$input;
    return $this->solutionIdUpdated = true;
  }

  public function getLogin() {
    $this->retriveData();
    return $this->login;
  }
  public function setLogin($input) {
    $this->login = $input;
    return $this->loginUpdated = true;
  }

  public function getPassword() {
    $this->retriveData();
    return $this->password;
  }
  public function setPassword($input) {
    $this->password = $input;
    return $this->passwordUpdated = true;
  }


	//  # # # # # # # # misc methods # # # # # # # #

  public function delete() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query="DELETE	FROM user
	       WHERE	id='" . $this->getId() . "'";
      
      return ($db->query($query));
    } else {
      return false;
    }
  }

	static public function createNew($solutionId) {
		$solutionId = (int)$solutionId;

		if ($solutionId > 0) {
      $db = Database::instantiate(Database::TYPE_WRITE);
			
			$query = "INSERT INTO   user(
                              solution_id, 
                              login, 
				                      password)
                VALUES(
                              '$solutionId',
                              '',
                              '');";

			if ($db->query($query)) {
				$obj = new User($db->insertId());
				$obj->getSolutionId(); // dummy init
				return $obj;
			}
		}
		return null;
	}

  public function update() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query = "UPDATE	 user
	        SET	 id=id ";

      $query .= $this->generateUpdateQuery();
      $query .= " WHERE	id='" . $this->getId() . "'";

      return $db->query($query);
    } else {
      return false;
    }
  }

  # # # # # # # # private methods # # # # # # # #
  protected function retriveData() {
    if (!$this->isDataRetrived) {
			$db = Database::instantiate(Database::TYPE_READ);	
		
      $query="SELECT  solution_id, 
                     login, 
                     password 
               FROM  user 
               WHERE id='" . $this->getId() . "';";

      if ($result = $db->query($query) AND $foo = $db->fetchObject($result)) {
				$this->assignValues($foo);
				unset($foo);
        $db->freeResult($result);
      }

    }
  }


  protected function assignValues($foo) {
    if (is_object($foo)) {
			$db = Database::instantiate(Database::TYPE_READ);
      $this->solutionId = $foo->solution_id;
      $this->login = $db->dbOut($foo->login);
      $this->password = $db->dbOut($foo->password);

      $this->isDataRetrived = true;
    }
  }

  protected function generateUpdateQuery() {
		$db = Database::instantiate(Database::TYPE_READ);
    $query = "";

    if ($this->solutionIdUpdated) {
      $query.=" ,solution_id='$this->solutionId' ";
      $this->solutionIdUpdated = false;
    }

    if ($this->loginUpdated) {
      $query.=" ,login='" . $db->dbIn($this->login) . "' ";
      $this->loginUpdated=false;
    }

    if ($this->passwordUpdated) {
      $query.=" ,password='" . $db->dbIn($this->password) . "' ";
      $this->passwordUpdated=false;
    }

    return $query;
  }
}
?>