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

class OrderLine {
  ############### Properties ####################


  protected $id = 0;
  protected $orderId = 0;
  protected $productId = 0;
  protected $name = "";
  protected $description = "";
  protected $price = "";
  protected $cost = "";
	protected $amount = 0;

  protected $idUpdated = false;
  protected $orderIdUpdated = false;
  protected $productIdUpdated = false;
  protected $nameUpdated = false;
  protected $descriptionUpdated = false;
  protected $priceUpdated = false;
  protected $costUpdated = false;
	protected $amountUpdated = false;

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
  public function getOrderId() {
    $this->retriveData();
    return $this->orderId;
  }
  public function setOrderId($input) {
    $this->orderId = (int)$input;
    return $this->orderIdUpdated = true;
  }

  public function getProductId() {
    $this->retriveData();
    return $this->productId;
  }
  public function setProductId($input) {
    $this->productId = (int)$input;
    return $this->productIdUpdated = true;
  }

  public function getName() {
    $this->retriveData();
    return $this->name;
  }
  public function setName($input) {
    $this->name = $input;
    return $this->nameUpdated = true;
  }

  public function getDescription() {
    $this->retriveData();
    return $this->description;
  }
  public function setDescription($input) {
    $this->description = $input;
    return $this->descriptionUpdated = true;
  }

  public function getPrice() {
    $this->retriveData();
    return $this->price;
  }
  public function setPrice($input) {
    $this->price = $input;
    return $this->priceUpdated = true;
  }

  public function getCost() {
    $this->retriveData();
    return $this->cost;
  }
  public function setCost($input) {
    $this->cost = $input;
    return $this->costUpdated = true;
  }

  public function getAmount() {
    $this->retriveData();
    return $this->amount;
  }
  public function setAmount($input) {
    $this->amount = $input;
    return $this->amountUpdated = true;
  }

  # # # # # # # # misc methods # # # # # # # #
  public function delete() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query="DELETE	FROM order_line
	       WHERE	id='" . $this->getId() . "'";
      
      return ($db->query($query));
    } else {
      return false;
    }
  }

	static public function createNew($orderId) {
		$orderId = (int)$orderId;

		if ($orderId > 0) {
      $db = Database::instantiate(Database::TYPE_WRITE);
			
			$query = "INSERT INTO   order_line(
                              order_id, 
                              product_id, 
                              name, 
                              description, 
                              price, 
                              cost,
                              amount)
                VALUES(
                              '$orderId',
                              NULL,
                              '',
                              '',
                              0,
                              0,
                              0);";

			if ($db->query($query)) {
				$obj = new OrderLine($db->insertId());
				$obj->getOrderId(); // dummy init
				return $obj;
			}
		}
		return null;
	}

  public function update() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query = "UPDATE	 order_line
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
		
      $query="SELECT  order_id, 
                     product_id, 
                     name, 
                     description, 
                     price, 
                     cost,
                     amount 
               FROM  order_line 
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
      $this->orderId = $foo->order_id;
      $this->productId = $foo->product_id;
      $this->name = $db->dbOut($foo->name);
      $this->description = $db->dbOut($foo->description);
      $this->price = $foo->price;
      $this->cost = $foo->cost;
			$this->amount = $foo->amount;

      $this->isDataRetrived = true;
    }
  }

  protected function generateUpdateQuery() {
		$db = Database::instantiate(Database::TYPE_READ);
    $query = "";

    if ($this->orderIdUpdated) {
      $query.=" ,order_id='$this->orderId' ";
      $this->orderIdUpdated = false;
    }

    if ($this->productIdUpdated) {
      $query.=" ,product_id='$this->productId' ";
      $this->productIdUpdated = false;
    }

    if ($this->nameUpdated) {
      $query.=" ,name='" . $db->dbIn($this->name) . "' ";
      $this->nameUpdated=false;
    }

    if ($this->descriptionUpdated) {
      $query.=" ,description='" . $db->dbIn($this->description) . "' ";
      $this->descriptionUpdated=false;
    }

    if ($this->priceUpdated) {
      $query.=" ,price='$this->price' ";
      $this->priceUpdated = false;
    }

    if ($this->costUpdated) {
      $query.=" ,cost='$this->cost' ";
      $this->costUpdated = false;
    }

    if ($this->amountUpdated) {
      $query.=" ,amount='$this->amount' ";
      $this->amountUpdated = false;
    }

    return $query;
  }
}
?>