<?php

class FinAppsApi {
	const BASE_URL = "http://finappsapi.bdigital.org/api/2012/";
	const KEY = "3176e5fa38";

	protected $curl = null;

  public function __construct() {
		$this->curl = curl_init();
		//		$this->cookieFile = tmpfile();
  }

	public function createCommerce($login, $pw, $name) {
		$data = array("username" => $login,
									"password" => $pw,
									"firstName" => $name,
									"lastName" => "",
									"publicName" => $name,
									"location" => array(4.12, 2.11)
									);

		$payload = json_encode($data);
		$url = FinAppsApi::BASE_URL . FinAppsApi::KEY . '/access/commerce';
		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($this->curl, CURLOPT_POST, true);
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $payload); 

 		$rawData = curl_exec($this->curl);
		return json_decode($rawData);
	}

	public function login($login, $pw) {
		$url = FinAppsApi::BASE_URL . FinAppsApi::KEY . '/access/login';

		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_USERPWD, $login . ":" . $pw);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($this->curl, CURLOPT_POST, false);

 		$rawData = curl_exec($this->curl);
		return json_decode($rawData);
	}

	//{"status":"OK","msg":"This is your token","token":"c7f-b44e-c6ae088fe7d5"}

	public function getOfficeList($token) {
		$url = FinAppsApi::BASE_URL . FinAppsApi::KEY . '/' . $token . '/operations/office/list';

		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($this->curl, CURLOPT_POST, false);

 		$rawData = curl_exec($this->curl);
		return json_decode($rawData);
	}

	//{"status":"OK","msg":"Ok","data":["508a8988e4b0a7694d240e8d", // office list

	public function createAccount($token, $id) {
		$data = array("office" => $id,
									"currency" => 0
									);

		$payload = json_encode($data);
		$url = FinAppsApi::BASE_URL . FinAppsApi::KEY . '/' . $token . '/operations/account/@me';

		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($this->curl, CURLOPT_POST, true);
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $payload); 

 		$rawData = curl_exec($this->curl);
		return json_decode($rawData);
	}

	/*	
{"status":"OK","msg":"Ok","data":{"id":"508b42d5e4b04a375aa9a052","holders":["508b3af2e4b04a375aa995b7"],"office":"508a8988e4b0a7694d240e8d","accountNumber":"2100 1111 01 0000000210","iban":"ES6521001111010000000210","currency":"EURO","availableBalance":0.0,"retainedBalance":0.0,"actualBalance":0.0}}
	*/

	/*
{"status":"OK","msg":"Ok","data":{"id":"508b3af2e4b04a375aa995b7","holder":{"username":"test@test.com","password":"stuff","firstName":"Uhasibu","lastName":"","address":null},"publicProfile":{"publicName":"Uhasibu","address":null,"location":[4.12,2.11]},"accounts":[],"offers":[]}}
	*/

}

?>