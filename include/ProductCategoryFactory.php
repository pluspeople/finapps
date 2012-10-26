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

class ProductCategoryFactory {
  ############### Properties ####################
  const SELECTLIST = "
SELECT id,
solution_id,
name,
orderno,
description ";

  # # # # # # # # misc methods # # # # # # # #

  static public function factoryOne($id) {
    $db = Database::instantiate(Database::TYPE_READ);
    $id = (int)$id;

	  $query = ProductCategoryFactory::SELECTLIST . "
							FROM  product_category
							WHERE	id = '$id' ";
		
		if ($result = $db->query($query) AND $foo = $db->fetchObject($result)) {
		  $returnval = new ProductCategory($foo->id, $foo);
		  $db->freeResult($result);
		  return $returnval;
		}
  }

  static function factoryAll() {
    $db = Database::instantiate(Database::TYPE_READ);

	  $query = ProductCategoryFactory::SELECTLIST . "
							FROM  product_category ";
		
		$tempArray = array();
		if ($result = $db->query($query)) {
			while($foo = $db->fetchObject($result)) {
				$tempArray[] = new ProductCategory($foo->id, $foo);
			}
			$db->freeResult($result);
		}
		return $tempArray;
  }


  static function factoryBySolution($id) {
    $db = Database::instantiate(Database::TYPE_READ);
		$id = (int)$id;
		$tempArray = array();

		if ($id > 0) {
			$query = ProductCategoryFactory::SELECTLIST . "
							FROM  product_category 
              WHERE solution_id='" . $id . "'";

			if ($result = $db->query($query)) {
				while($foo = $db->fetchObject($result)) {
					$tempArray[] = new ProductCategory($foo->id, $foo);
				}
				$db->freeResult($result);
			}
		}
		return $tempArray;
  }

}
?>