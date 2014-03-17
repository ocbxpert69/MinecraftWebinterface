<?php
      include('config.php');
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
$fp = fsockopen($ts_ip, $ts_port, $errno, $errstr, 1) or die("Cannot connect to Teamspeak Server!");
if (!$fp || !fwrite($fp,"nix")) 
{ 
   $tsc = "Red";
   $ton = "Offline";
} elseif($fp || fwrite($fp,"nix")) {
   $tsc = "Green";
   $ton = $ts_ip;
} else {
   $tsc ="Red";
   $ton = "Error";
}
fclose($fp) or die("Cannot connect to Teamspeak Server!");
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