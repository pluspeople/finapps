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

class Product {
  ############### Properties ####################


  protected $id = 0;
  protected $productCategoryId = 0;
  protected $name = "";
  protected $description = "";
  protected $price = "";
  protected $cost = "";
  protected $orderno = 0;
	protected $vatRate = 0;

  protected $idUpdated = false;
  protected $productCategoryIdUpdated = false;
  protected $nameUpdated = false;
  protected $descriptionUpdated = false;
  protected $priceUpdated = false;
  protected $costUpdated = false;
  protected $ordernoUpdated = false;
	protected $vatRateUpdated = false;

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
  public function getProductCategoryId() {
    $this->retriveData();
    return $this->productCategoryId;
  }
  public function setProductCategoryId($input) {
    $this->productCategoryId = (int)$input;
    return $this->productCategoryIdUpdated = true;
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

  public function getOrderno() {
    $this->retriveData();
    return $this->orderno;
  }
  public function setOrderno($input) {
    $this->orderno = (int)$input;
    return $this->ordernoUpdated = true;
  }

  public function getVatRate() {
    $this->retriveData();
    return $this->vatRate;
  }
  public function setVatRate($input) {
    $this->vatRate = $input;
    return $this->vatRateUpdated = true;
  }

  # # # # # # # # misc methods # # # # # # # #
  public function delete() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query="DELETE	FROM product
	       WHERE	id='" . $this->getId() . "'";
      
      return ($db->query($query));
    } else {
      return false;
    }
  }

  public function update() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query = "UPDATE	 product
	        SET	 id=id ";

      $query .= $this->generateUpdateQuery();
      $query .= " WHERE	id='" . $this->getId() . "'";

      return $db->query($query);
    } else {
      return false;
    }
  }

	//  # # # # # # # # private methods # # # # # # # #
	public function getTotalPrice() {
		return $this->getPrice() * (1 + $this->getVatRate() / 100);
		return number_format($price/100, 2, '.', ',');
	}
	public function getFormatedTotalPrice() {
		$price = $this->getTotalPrice();
		return number_format($price/100, 2, '.', ',');
	}

  protected function retriveData() {
    if (!$this->isDataRetrived) {
			$db = Database::instantiate(Database::TYPE_READ);	
		
      $query="SELECT  product_category_id, 
                     name, 
                     description, 
                     price, 
                     cost, 
                     orderno,
                     vat_rate
               FROM  product 
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
      $this->productCategoryId = $foo->product_category_id;
      $this->name = $db->dbOut($foo->name);
      $this->description = $db->dbOut($foo->description);
      $this->price = $foo->price;
      $this->cost = $foo->cost;
      $this->orderno = $foo->orderno;
			$this->vatRate = $foo->vat_rate;

      $this->isDataRetrived = true;
    }
  }

  protected function generateUpdateQuery() {
		$db = Database::instantiate(Database::TYPE_READ);
    $query = "";

    if ($this->productCategoryIdUpdated) {
      $query.=" ,product_category_id='$this->productCategoryId' ";
      $this->productCategoryIdUpdated = false;
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

    if ($this->ordernoUpdated) {
      $query.=" ,orderno='$this->orderno' ";
      $this->ordernoUpdated = false;
    }

    if ($this->vatRateUpdated) {
      $query.=" ,vat_rate='$this->vatRate' ";
      $this->vatRateUpdated = false;
    }

    return $query;
  }
}
?>