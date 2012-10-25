<?php
/*
 This legal notice is only available in English.
 
 Taesk CMS is Copyright 2001-2009 PLUSPEOPLE Aps - www.pluspeople.dk
 Taesk CMS is released under the GPLv3 licence, for full information
 regarding the GPLv3 licence see the included licence file.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 If the GPLv3 licence does not fullfill your (commercial) needs then 
 contact PLUSPEOPLE regarding an alternative licence agreement.

 If you have any questions about this legal notice, please contact
 PLUSPEOPLE at the following e-mail address: info@pluspeople.dk
*/
class WebUtility {

	static public function instantiate() {
		global $singletonArray;
		if (!isset($singletonArray["WebUtility"])) {
			$singletonArray["WebUtility"] = new WebUtility();
		}
		return $singletonArray["WebUtility"];
	}


	public function checkSubmit($internal_var) {
	        $postvars = $_POST;
	        $getvars = $_GET;

	        return (
	            isset($GLOBALS[$internal_var]) ||
	            isset($GLOBALS[$internal_var."_x"]) ||
	            isset($GLOBALS[$internal_var."_y"]) ||
	            isset($postvars[$internal_var]) ||
	            isset($postvars[$internal_var."_x"]) ||
	            isset($postvars[$internal_var."_y"]) ||
	            isset($getvars[$internal_var]) ||
	            isset($getvars[$internal_var."_x"]) ||
	            isset($getvars[$internal_var."_y"]));
	}

	public function redirect($destination) {
		$destination = utf8_encode($destination);
		Header("Location: $destination");
	  exit;
	}

	public function closePopup($reload = false) {
	  if ($reload) {
  		print '<html><head><script language="Javascript">window.opener.location=window.opener.location;window.close();</script></head></html>';
	  } else {
	  	print '<html><head><script language="Javascript">window.close();</script></head></html>';
	  }
	}

	public function maxLength($input, $length) {
		if (strlen($input) > $length AND $length > 4) {
			$maxlength = $length - 4;
		        return preg_replace("/(.{0,$maxlength})\s(.*)/s","\\1 ...", $input);
		} else {
			return $input;
		}
	}

	public function safeFilename($input) {
	  $search  = array(" ", "æ", "ø", "å", "Æ", "Ø", "Å");
	  $replace = array("_", "ae", "oe", "aa", "ae", "oe", "aa");
	  return preg_replace("/[^a-zA-Z0-9_\.]/","", str_replace($search, $replace, $input));
	}

	public function getBrowserPlatform() {
		$string = getenv("HTTP_USER_AGENT");
       		$Browser_Platform = "unknown";
        	if(strpos($string, "Windows") !== false || 
      		   strpos($string, "WinNT") !== false || 
		         strpos($string, "Win95") !== false ||
		   strpos($string, "Win") !== false ) {
        	    $Browser_Platform = "Windows";
        	}

        	if(strpos($string, "Mac") !== false) {
        	    $Browser_Platform = "Macintosh";
        	}

        	if(strpos($string, "Linux") !== false) {
        	    $Browser_Platform = "Linux";
        	}
		return $Browser_Platform;
	}

	public function getBrowser() {
		$browser = "Unknown";
		$string = getenv("HTTP_USER_AGENT");
		//echo $string;
		if (strpos($string, "Mozilla/5.0")) {
			$browser = "Mozilla";
		}

		if (strpos($string, "Mozilla/4")) {
			$browser = "Netscape";
		}

		if (strpos($string, "Mozilla/3")) {
			$browser = "Netscape";
		}

		if (strpos($string, "Firefox") || strpos($string, "Firebird")) {
			$browser = "Mozilla";
		}

		if (strpos($string, "MSIE")) {
			$browser = "MSIE";
		}

		if (strpos($string, "Netscape")) {
			$browser = "Netscape";
		}

		if (strpos($string, "Netscape/8")) {
			$browser = "Netscape";
		}

		if (strpos($string, "Camino")) {
			$browser = "Camino";
		}

		if (strpos($string, "Galeon")) {
			$browser = "Galeon";
		}

		if (strpos($string, "Konqueror")) {
			$browser = "Konqueror";
		}

		if (strpos($string, "Safari")) {
			$browser = "Safari";
		}

		if (strpos($string, "OmniWeb")) {
			$browser = "OmniWeb";
		}

		if (strpos($string, "Opera")) {
			$browser = "Opera";
		}
		
		return $browser;

		/*
		$string=getenv("HTTP_USER_AGENT");
        	$Browser_Name = strtok($string, "/");
        	$Browser_Version = strtok(" ");

	        if(ereg("MSIE", $string)) {
	            $Browser_Name = "MSIE";
	            $Browser_Version = strtok("MSIE");
	            $Browser_Version = strtok(" ");
	            $Browser_Version = strtok(";");
	        }

	        if(ereg("Konqueror", $string)) {
	            $Browser_Name = "Konqueror";
	            $Browser_Version = strtok("Konqueror");
	            $Browser_Version = strtok(" ");
	            $Browser_Version = strtok("/");
	            $Browser_Version = strtok(" ");
	        }
		return $Browser_Name;*/
	}

	public function getBrowserLanguage($langarray) {
	  if (count($langarray) > 0) {
	    $temp = split(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	    $returnLanguage = $langarray[count($langarray)-1];
    
	    foreach ($temp as $item) {
	      $confset = 0;
	      $item = trim($item);
	      for ($i = 0; $i < count($langarray); $i++) {
# rfc 2616 dictates that a acept_language element consists of a primary-tag and any number of subtags 
		      $tags = split("-", $item);
		      if ($tags[0] == $langarray[$i]) {
		        $returnLanguage = $langarray[$i];
		        $confset = 1;
		        break;
		      }
	      }

	      if ($confset == 1) {
		      break;
	      }
	    }

	    return $returnLanguage;
	  } else {
	    return "";
	  }					
	}

	public function generatePassword($length = 10, $chars = "abcdefghijkmnopqrstuvwxyz023456789") {
    # Theres a small feature here :)
		# consider security level here.
		#return uniqid("", true);
		
    srand((double)microtime()*1000000);

    $pass = '' ;
		for ($i = 0; $i < $length; $i++) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
    }

    return $pass;		
	}


	/**
		 Validate an email address.
		 Provide email address (raw input)
		 Returns true if the email address has the email 
		 address format and the domain exists.
	*/
	function validateEmail($email) {
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
			$isValid = false;
		} else {
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64) {
				// local part length exceeded
				$isValid = false;
			}	else if ($domainLen < 1 || $domainLen > 255) {
				// domain part length exceeded
				$isValid = false;
			}	else if ($local[0] == '.' || $local[$localLen-1] == '.') {
				// local part starts or ends with '.'
				$isValid = false;
			}	else if (preg_match('/\\.\\./', $local)) {
				// local part has two consecutive dots
				$isValid = false;
			}	else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				// character not valid in domain part
				$isValid = false;
			}	else if (preg_match('/\\.\\./', $domain))	{
				// domain part has two consecutive dots
				$isValid = false;
			}	else if	(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))	{
				// character not valid in local part unless 
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
				// domain not found in DNS
				$isValid = false;
			}
		}
		return $isValid;
	}


}
?>
