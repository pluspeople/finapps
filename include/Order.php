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

class Order {
  //############### Properties ####################
	const AWAITING_PAYMENT = 1;
	const AWAITING_BUSINESS = 2;
	const REFUSED_ORDER = 3;
	const ACCEPTED_ORDER = 4;

  protected $id = 0;
  protected $processStepId = 0;
  protected $createdDate = "";
  protected $totalPrice = "";
  protected $solutionId = 0;
  protected $name = "";
  protected $phone = "";
  protected $email = "";
  protected $address = "";
  protected $tag = "";
  protected $history = "";

  protected $idUpdated = false;
  protected $processStepIdUpdated = false;
  protected $createdDateUpdated = false;
  protected $totalPriceUpdated = false;
  protected $solutionIdUpdated = false;
  protected $nameUpdated = false;
  protected $phoneUpdated = false;
  protected $emailUpdated = false;
  protected $addressUpdated = false;
  protected $tagUpdated = false;
  protected $historyUpdated = false;

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
  public function getProcessStepId() {
    $this->retriveData();
    return $this->processStepId;
  }
  public function setProcessStepId($input) {
    $this->processStepId = (int)$input;
    return $this->processStepIdUpdated = true;
  }

  public function getCreatedDate() {
    $this->retriveData();
    return $this->createdDate;
  }
  public function setCreatedDate($input) {
    $this->createdDate = $input;
    return $this->createdDateUpdated = true;
  }

  public function getTotalPrice() {
    $this->retriveData();
    return $this->totalPrice;
  }
  public function setTotalPrice($input) {
    $this->totalPrice = $input;
    return $this->totalPriceUpdated = true;
  }

  public function getSolutionId() {
    $this->retriveData();
    return $this->solutionId;
  }
  public function setSolutionId($input) {
    $this->solutionId = (int)$input;
    return $this->solutionIdUpdated = true;
  }

  public function getName() {
    $this->retriveData();
    return $this->name;
  }
  public function setName($input) {
    $this->name = $input;
    return $this->nameUpdated = true;
  }

  public function getPhone() {
    $this->retriveData();
    return $this->phone;
  }
  public function setPhone($input) {
    $this->phone = $input;
    return $this->phoneUpdated = true;
  }

  public function getEmail() {
    $this->retriveData();
    return $this->email;
  }
  public function setEmail($input) {
    $this->email = $input;
    return $this->emailUpdated = true;
  }

  public function getAddress() {
    $this->retriveData();
    return $this->address;
  }
  public function setAddress($input) {
    $this->address = $input;
    return $this->addressUpdated = true;
  }

  public function getTag() {
    $this->retriveData();
    return $this->tag;
  }
  public function setTag($input) {
    $this->tag = $input;
    return $this->tagUpdated = true;
  }

  public function getHistory() {
    $this->retriveData();
    return $this->history;
  }
  public function setHistory($input) {
    $this->history = $input;
    return $this->historyUpdated = true;
  }


  # # # # # # # # misc methods # # # # # # # #
  public function delete() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query="DELETE	FROM order
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
			
			$query = "INSERT INTO   orders(
                              process_step_id, 
                              created_date, 
                              total_price, 
                              solution_id, 
                              name, 
                              phone, 
                              email, 
                              address, 
                              tag, 
                              history)
                VALUES(
                              '1',
                              NOW(),
                              0,
                              '$solutionId',
                              '',
                              '',
                              '',
                              '',
                              '',
                              '');";

			if ($db->query($query)) {
				$obj = new Order($db->insertId());
				$obj->getSolutionId(); // dummy init
				return $obj;
			}
		}
		return null;
	}

  public function update() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query = "UPDATE	 orders
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
		
      $query="SELECT  process_step_id, 
                     UNIX_TIMESTAMP(created_date) AS created_date, 
                     total_price, 
                     solution_id, 
                     name, 
                     phone, 
                     email, 
                     address, 
                     tag, 
                     history 
               FROM  orders
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
      $this->processStepId = $foo->process_step_id;
      $this->createdDate = $foo->created_date;
      $this->totalPrice = $foo->total_price;
      $this->solutionId = $foo->solution_id;
      $this->name = $db->dbOut($foo->name);
      $this->phone = $db->dbOut($foo->phone);
      $this->email = $db->dbOut($foo->email);
      $this->address = $db->dbOut($foo->address);
      $this->tag = $db->dbOut($foo->tag);
      $this->history = $db->dbOut($foo->history);

      $this->isDataRetrived = true;
    }
  }

  protected function generateUpdateQuery() {
		$db = Database::instantiate(Database::TYPE_READ);
    $query = "";

    if ($this->processStepIdUpdated) {
      $query.=" ,process_step_id='$this->processStepId' ";
      $this->processStepIdUpdated = false;
    }

    if ($this->createdDateUpdated) {
      $query.=" ,created_date=FROM_UNIXTIME('$this->createdDate') ";
      $this->createdDateUpdated = false;
    }

    if ($this->totalPriceUpdated) {
      $query.=" ,total_price='$this->totalPrice' ";
      $this->totalPriceUpdated = false;
    }

    if ($this->solutionIdUpdated) {
      $query.=" ,solution_id='$this->solutionId' ";
      $this->solutionIdUpdated = false;
    }

    if ($this->nameUpdated) {
      $query.=" ,name='" . $db->dbIn($this->name) . "' ";
      $this->nameUpdated=false;
    }

    if ($this->phoneUpdated) {
      $query.=" ,phone='" . $db->dbIn($this->phone) . "' ";
      $this->phoneUpdated=false;
    }

    if ($this->emailUpdated) {
      $query.=" ,email='" . $db->dbIn($this->email) . "' ";
      $this->emailUpdated=false;
    }

    if ($this->addressUpdated) {
      $query.=" ,address='" . $db->dbIn($this->address) . "' ";
      $this->addressUpdated=false;
    }

    if ($this->tagUpdated) {
      $query.=" ,tag='" . $db->dbIn($this->tag) . "' ";
      $this->tagUpdated=false;
    }

    if ($this->historyUpdated) {
      $query.=" ,history='" . $db->dbIn($this->history) . "' ";
      $this->historyUpdated=false;
    }

    return $query;
  }
}
?>