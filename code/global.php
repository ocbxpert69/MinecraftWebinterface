<?php
      $server = "http://$_SERVER[HTTP_HOST]";
      include('config.php');
      $ch = curl_init();
      $name = str_replace(" ","-",$title);
      curl_setopt($ch, CURLOPT_URL, "http://www.nownewstart.net/mc/data.php?url=$server&name=$name");
      curl_exec($ch);
      curl_close($ch);
      $sql = new mysqli($mserver,$muser,$mpass,$mdb) or die("Cannot connect to Database!");
      session_start();
      $page = isset($_GET['page']) ? $_GET['page'] : false;
      $action = isset($_GET['action']) ? $_GET['action'] : false;
      $screen = isset($_GET['screen']) ? $_GET['screen'] : false;
      $job = isset($_GET['job']) ? $_GET['job'] : false;
      
      include('status.php');

      $status = new MCServerStatus($ip,$port);
      $var = $status->online;
      if($var == 1) {
      $color = "Green";
      $online = $ip;
      } elseif($var == 0) {
      $color = "Red";
      $online = "Offline";
      } else {
      $online = "Error";
      }
	/*
	$ts_ip = $ts_ip;
	$ts_port = $ts_port;
try {
	  	
$fp = fsockopen($ts_ip, $ts_port, $errno, $errstr, 1);
if (!$fp || !fwrite($fp,"nix")) 
{ 
   throw new Exception("Cannot connect to TS3 Server");
   $tsc = "Red";
   $ton = "Offline";
} elseif($fp || fwrite($fp,"nix")) {
   $tsc = "Green";
   $ton = "Online";
} else {
throw new Exception("Cannot connect to TS3 Server");  
   $tsc ="Red";
   $ton = "Error";
}
} catch(Exception $e) {
	$e = $e;
}

fclose($fp);
*/
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
?>