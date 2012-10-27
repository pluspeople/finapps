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

class OrderLineFactory {
  ############### Properties ####################
  const SELECTLIST = "
SELECT id,
order_id,
product_id,
name,
description,
price,
cost,
amount ";

  # # # # # # # # misc methods # # # # # # # #

  static public function factoryOne($id) {
    $db = Database::instantiate(Database::TYPE_READ);
    $id = (int)$id;

	  $query = OrderLineFactory::SELECTLIST . "
							FROM  order_line
							WHERE	id = '$id' ";
		
		if ($result = $db->query($query) AND $foo = $db->fetchObject($result)) {
		  $returnval = new OrderLine($foo->id, $foo);
		  $db->freeResult($result);
		  return $returnval;
		}
  }

  static function factoryAll() {
    $db = Database::instantiate(Database::TYPE_READ);

	  $query = OrderLineFactory::SELECTLIST . "
							FROM  order_line ";
		
		$tempArray = array();
		if ($result = $db->query($query)) {
			while($foo = $db->fetchObject($result)) {
				$tempArray[] = new OrderLine($foo->id, $foo);
			}
			$db->freeResult($result);
		}
		return $tempArray;
  }

  static function factoryByOrder($orderId) {
    $db = Database::instantiate(Database::TYPE_READ);
		$orderId = (int)$orderId;
		$tempArray = array();

		if ($orderId > 0) {
			$query = OrderLineFactory::SELECTLIST . "
							FROM  order_line
              WHERE order_id = '" . $orderId . "' ";

			if ($result = $db->query($query)) {
				while($foo = $db->fetchObject($result)) {
					$tempArray[] = new OrderLine($foo->id, $foo);
				}
				$db->freeResult($result);
			}
		}
		return $tempArray;
  }
}
?>