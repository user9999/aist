<?
class Browser {
	var $headerLines = Array();
	var $postData = Array();
	var $authUser = "";
	var $authPass = "";
	var $port;
	var $lastResponse = Array();
	var $debug = false;
	function Browser() {
		$this->resetHeaderLines();
		$this->resetPort();
	}
	function addHeaderLine($name, $value) {
		$this->headerLines[$name] = $value;
	}
	function resetHeaderLines() {
		$this->headerLines = Array();
		$this->headerLines["User-Agent"] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
	}
	function addPostData($name, $value) {
		$this->postData[$name] = $value;
	}
	function resetPostData() {
		$this->postData = Array();
	}
	function setAuth($user, $pass) {
		$this->authUser = $user;
		$this->authPass = $pass;
	}
	function setPort($portNumber) {
		$this->port = $portNumber;
	}
	function resetPort() {
		$this->port = 80;
	}
	function fopen($url) {
		$this->lastResponse = Array();
		preg_match("~([a-z]*://)?([^:^/]*)(:([0-9]{1,5}))?(/.*)?~i", $url, $matches);
		$protocol = $matches[1];
		$server = $matches[2];
		$port = $matches[4];
		$path = $matches[5];
		if ($port!="") {
			$this->setPort($port);
		}
		if ($path=="") $path = "/";
		$socket = false;
		$socket = fsockopen($server, $this->port);
		if ($socket) {
			$this->headerLines["Host"] = $server;
			if ($this->authUser!="" && $this->authPass!="") {
				$this->headerLines["Authorization"] = "Basic ".base64_encode($this->authUser.":".$this->authPass);
			}
			
			if (count($this->postData)==0) {
				$request = "GET $path HTTP/1.0\r\n";
			} else {
				$request = "POST $path HTTP/1.0\r\n";
			}
			
			if ($this->debug) echo $request;
		    fputs ($socket, $request);
			
			if (count($this->postData)>0) {
				$PostStringArray = Array();
				foreach ($this->postData AS $key=>$value) {
					$PostStringArray[] = "$key=$value";
				}
				$PostString = join("&", $PostStringArray);
				$this->headerLines["Content-Length"] = strlen($PostString);
			}
			
			foreach ($this->headerLines AS $key=>$value) {
				if ($this->debug) echo "$key: $value\n";
			    fputs($socket, "$key: $value\r\n");
			}
			if ($this->debug) echo "\n";
			fputs($socket, "\r\n");
			if (count($this->postData)>0) {
				if ($this->debug) echo "$PostString";
				fputs($socket, $PostString."\r\n");
			}
		}
		if ($this->debug) echo "\n";
		if ($socket) {
			$line = fgets($socket, 1000);
			if ($this->debug) echo $line;
			$this->lastResponse[] = $line;
			$status = substr($line,9,3);
			while (trim($line = fgets($socket, 1000)) != ""){
				if ($this->debug) echo "$line";
				$this->lastResponse[] = $line;
				if ($status=="401" AND strpos($line,"WWW-Authenticate: Basic realm=\"")===0) {
					fclose($socket);
					return FALSE;
				}
			}
		}
		return $socket;
	}
	function file($url) {
		$file = Array();
		$socket = $this->fopen($url);
		if ($socket) {
			$file = Array();
			while (!feof($socket)) {
				$file[] = fgets($socket, 10000);
			}
		} else {
			return FALSE;
		}
		return $file;
	}
	function getLastResponseHeaders() {
		return $this->lastResponse;
	}
}
?>