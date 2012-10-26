<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Warning</b>:  date() [<a href='function.date'>function.date</a>]: It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'Europe/Berlin' for 'CEST/2.0/DST' instead in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>93</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Notice</b>:  Undefined variable: body in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>179</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
<br />
<b>Deprecated</b>:  Function split() is deprecated in <b>/Users/kaal/work/2008/taesk1_6/tools/beanbuilder/beanbuilder.php</b> on line <b>72</b><br />
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

class Payment {
  ############### Properties ####################


  protected $id = 0;
  protected $orderId = 0;

  protected $idUpdated = false;
  protected $orderIdUpdated = false;

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


  # # # # # # # # misc methods # # # # # # # #
  public function delete() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query="DELETE	FROM payment
	       WHERE	id='" . $this->getId() . "'";
      
      return ($db->query($query));
    } else {
      return false;
    }
  }

  public function update() {
    if ($this->getId() > 0) {
			$db = Database::instantiate(Database::TYPE_WRITE);

      $query = "UPDATE	 payment
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
		
      $query="SELECT  order_id 
               FROM  payment 
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

    return $query;
  }
}
?>