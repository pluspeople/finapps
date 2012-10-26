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

class ProductCategory {
  ############### Properties ####################


  protected $id = 0;
  protected $solutionId = 0;
  protected $name = "";
  protected $orderno = 0;
	protected $description = "";

  protected $idUpdated = false;
  protected $solutionIdUpdated = false;
  protected $nameUpdated = false;
  protected $ordernoUpdated = false;
	protected $descriptionUpdated = false;

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

  public function getName() {
    $this->retriveData();
    return $this->name;
  }
  public function setName($input) {
    $this->name = $input;
    return $this->nameUpdated = true;
  }

  public function getOrderno() {
    $this->retriveData();
    return $this->orderno;
  }
  public function setOrderno($input) {
    $this->orderno = (int)$input;
    return $this->ordernoUpdated = true;
  }

  public function getFormatedDescription() {
		return nl2br($this->getDescription());
	}
  public function getDescription() {
    $this->retriveData();
    return $this->description;
  }
  public function setDescription($input) {
    $this->description = $input;
    return $this->descriptionUpdated = true;
  }

  //# # # # # # # # misc methods # # # # # # # #

	public function getProducts() {
		return ProductFactory::factoryByCategory($this->getId());
	}

  public function delete() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query="DELETE	FROM product_category
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
			
			$query = "SELECT	 max(orderno) as nextid
			          FROM	   product_category";

			if ($result = $db->query($query) AND $foo = $db->fetchObject($result)) {
				$nextId = $foo->nextid + 1;

				$query = "INSERT INTO   product_category(
                                solution_id, 
                                name, 
                                orderno,
                                description)
                VALUES(
                              '$solutionId',
                              '',
                              '$nextId',
                              '');";

				if ($db->query($query)) {
					$obj = new ProductCategory($db->insertId());
					$obj->getSolutionId(); // dummy init
					return $obj;
				}
			}
		}
		return null;
	}

  public function update() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query = "UPDATE	 product_category
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
                     name, 
                     orderno,
                     description
               FROM  product_category 
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
      $this->name = $db->dbOut($foo->name);
      $this->orderno = $foo->orderno;
			$this->description = $foo->description;

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

    if ($this->nameUpdated) {
      $query.=" ,name='" . $db->dbIn($this->name) . "' ";
      $this->nameUpdated=false;
    }

    if ($this->ordernoUpdated) {
      $query.=" ,orderno='$this->orderno' ";
      $this->ordernoUpdated = false;
    }

    if ($this->descriptionUpdated) {
      $query.=" ,description='" . $db->dbIn($this->description) . "' ";
      $this->descriptionUpdated=false;
    }

    return $query;
  }
}
?>