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

class ProductFactory {
  ############### Properties ####################
  const SELECTLIST = "
SELECT id,
product_category_id,
name,
description,
price,
cost,
orderno,
vat_rate ";

  # # # # # # # # misc methods # # # # # # # #

  static public function factoryOne($id) {
    $db = Database::instantiate(Database::TYPE_READ);
    $id = (int)$id;

	  $query = ProductFactory::SELECTLIST . "
							FROM  product
							WHERE	id = '$id' ";
		
		if ($result = $db->query($query) AND $foo = $db->fetchObject($result)) {
		  $returnval = new Product($foo->id, $foo);
		  $db->freeResult($result);
		  return $returnval;
		}
  }

  static function factoryByCategory($id) {
    $db = Database::instantiate(Database::TYPE_READ);
		$id = (int)$id;
		$tempArray = array();

		if ($id > 0) {
			$query = ProductFactory::SELECTLIST . "
							FROM  product
              WHERE product_category_id='" . $id . "' ";
		
			if ($result = $db->query($query)) {
				while($foo = $db->fetchObject($result)) {
					$tempArray[] = new Product($foo->id, $foo);
				}
				$db->freeResult($result);
			}
		}
		return $tempArray;
  }

  static function factoryAll() {
    $db = Database::instantiate(Database::TYPE_READ);

	  $query = ProductFactory::SELECTLIST . "
							FROM  product ";
		
		$tempArray = array();
		if ($result = $db->query($query)) {
			while($foo = $db->fetchObject($result)) {
				$tempArray[] = new Product($foo->id, $foo);
			}
			$db->freeResult($result);
		}
		return $tempArray;
  }
}
?>