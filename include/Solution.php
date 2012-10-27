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

class Solution {
  ############### Properties ####################


  protected $id = 0;
  protected $name = "";
  protected $domain = "";
  protected $logo = "";
  protected $logoType = "";
  protected $mainColor = "";
  protected $secondaryColor = "";
	protected $email = "";
	protected $account = "";

  protected $idUpdated = false;
  protected $nameUpdated = false;
  protected $domainUpdated = false;
  protected $logoUpdated = false;
  protected $logoTypeUpdated = false;
  protected $mainColorUpdated = false;
  protected $secondaryColorUpdated = false;
	protected $emailUpdated = false;
	protected $accountUpdated = false;

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
  public function getName() {
    $this->retriveData();
    return $this->name;
  }
  public function setName($input) {
    $this->name = $input;
    return $this->nameUpdated = true;
  }

  public function getDomain() {
    $this->retriveData();
    return $this->domain;
  }
  public function setDomain($input) {
    $this->domain = $input;
    return $this->domainUpdated = true;
  }

  public function getLogo() {
    $this->retriveData();
    return $this->logo;
  }
  public function setLogo($input) {
    $this->logo = $input;
    return $this->logoUpdated = true;
  }

  public function getLogoType() {
    $this->retriveData();
    return $this->logoType;
  }
  public function setLogoType($input) {
    $this->logoType = $input;
    return $this->logoTypeUpdated = true;
  }

  public function getMainColor() {
    $this->retriveData();
    return $this->mainColor;
  }
  public function setMainColor($input) {
    $this->mainColor = $input;
    return $this->mainColorUpdated = true;
  }

  public function getSecondaryColor() {
    $this->retriveData();
    return $this->secondaryColor;
  }
  public function setSecondaryColor($input) {
    $this->secondaryColor = $input;
    return $this->secondaryColorUpdated = true;
  }

  public function getEmail() {
    $this->retriveData();
    return $this->email;
  }
  public function setEmail($input) {
    $this->email = $input;
    return $this->emailUpdated = true;
  }

  public function getAccount() {
    $this->retriveData();
    return $this->account;
  }
  public function setAccount($input) {
    $this->account = $input;
    return $this->accountUpdated = true;
  }


  # # # # # # # # misc methods # # # # # # # #
  public function delete() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query="DELETE	FROM solution
	       WHERE	id='" . $this->getId() . "'";
      
      return ($db->query($query));
    } else {
      return false;
    }
  }

	static public function createNew($domain) {
		if ($domain != "") {
      $db = Database::instantiate(Database::TYPE_WRITE);
			
			$query = "INSERT INTO   solution(
                              name, 
                              domain, 
                              logo, 
                              logo_type, 
                              main_color, 
                              secondary_color,
                              email,
                              account)
                VALUES(
                              '',
                              '" . $db->dbIn($domain) . "',
                              '',
                              '',
                              '',
                              '',
                              '',
                              '');";

			if ($db->query($query)) {
				$obj = new Solution($db->insertId());
				$obj->getDomain(); // dummy init
				return $obj;
			}
		}
		return null;
	}

  public function update() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query = "UPDATE	 solution
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
		
      $query="SELECT  name, 
                     domain, 
                     logo, 
                     logo_type, 
                     main_color, 
                     secondary_color,
                     email,
                     account
               FROM  solution 
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
      $this->name = $db->dbOut($foo->name);
      $this->domain = $db->dbOut($foo->domain);
      $this->logo = $foo->logo;
      $this->logoType = $db->dbOut($foo->logo_type);
      $this->mainColor = $db->dbOut($foo->main_color);
      $this->secondaryColor = $db->dbOut($foo->secondary_color);
      $this->email = $db->dbOut($foo->email);
      $this->account = $db->dbOut($foo->account);

      $this->isDataRetrived = true;
    }
  }

  protected function generateUpdateQuery() {
		$db = Database::instantiate(Database::TYPE_READ);
    $query = "";

    if ($this->nameUpdated) {
      $query.=" ,name='" . $db->dbIn($this->name) . "' ";
      $this->nameUpdated=false;
    }

    if ($this->domainUpdated) {
      $query.=" ,domain='" . $db->dbIn($this->domain) . "' ";
      $this->domainUpdated=false;
    }

    if ($this->logoUpdated) {
      $query.=" ,logo='$this->logo' ";
      $this->logoUpdated = false;
    }

    if ($this->logoTypeUpdated) {
      $query.=" ,logo_type='" . $db->dbIn($this->logoType) . "' ";
      $this->logoTypeUpdated=false;
    }

    if ($this->mainColorUpdated) {
      $query.=" ,main_color='" . $db->dbIn($this->mainColor) . "' ";
      $this->mainColorUpdated=false;
    }

    if ($this->secondaryColorUpdated) {
      $query.=" ,secondary_color='" . $db->dbIn($this->secondaryColor) . "' ";
      $this->secondaryColorUpdated=false;
    }

    if ($this->emailUpdated) {
      $query.=" ,email='" . $db->dbIn($this->email) . "' ";
      $this->emailUpdated=false;
    }

    if ($this->accountUpdated) {
      $query.=" ,account='" . $db->dbIn($this->account) . "' ";
      $this->accountUpdated=false;
    }

    return $query;
  }
}
?>