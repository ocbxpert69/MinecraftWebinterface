<?php
include 'global.php';
$data = get_data("http://api.iamphoenix.me/players/?server_ip=".$ip.":".$port."&clean=true"); 
$data = json_decode($data, true);    

if(!isset($data["players"])) {
$players = 0;
} elseif(isset($data["players"])) {
$players = $data["players"];
} else {
$players = "Fehler";
} 
include_once 'Websend.php';
?>
<!DOCTYPE html>
<head>
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
<nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px; padding-bottom: 0px;">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="intern.php"><?php echo $header; ?></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li><a href="intern.php?page=Users">Userlist</a></li>
      <li class="dropdown">
          <a href="index.php?page=Ranking" class="dropdown-toggle" data-toggle="dropdown">Ranking <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="intern.php?page=Ranking&screen=Jobs">Jobs</a></li>
            <li><a href="intern.php?page=Ranking&screen=Money">Money</a></li>
            <li><a href="intern.php?page=Ranking&screen=Time">Playtime</a></li>
            <li><a href="intern.php?page=Ranking&screen=HungerGames">Hunger Games</a></li>
          </ul>
        </li>
      <li><a href="intern.php?page=Shop">Shop</a></li>
      <li><a href="intern.php?page=Dynmap">Dynmap</a></li>
      <li><a href="intern.php?page=Support">Support</a></li>
      <?php
      #Simple way to allow more people to access this:
      if(in_array($_SESSION['user'],$admins)) {
      ?>
      <li><a href="acp.php">Control Panel</a></li>
      <?php
      }
      ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="intern.php" style="color: <?php echo $color; ?>"><span style="color:#c0c0c0">Minecraft IP :</span> <?php echo $online. " (".$players." User online)"; ?></a></li>
     <!-- <li><a href="intern.php" style="color: <?php echo $tsc; ?>"><span style="color:#c0c0c0">Teamspeak IP :</span> <?php echo $ton; ?></a></li>-->
      <li><a href="intern.php?page=Logout">Logout</a></li>
    </ul>
  </div>
</nav>
<?php if($page == "Dynmap") {} else { ?>
<img src="img/banner.png" style="width: 100%;"/>
 <?php } ?>

<div class="container" style="margin-top: 10px; padding-top: 10px;">
<?php
if($page == "Dynmap") {
echo "<iframe src='http://".$dynmap_ip."/?worldname=Stadt&mapname=flat&zoom=4&x=27.000000000000014&y=64&z=260' style='width: 100%; height: 500px;'>Dein Browser erlaubt keine iFrames.</iframe>";
}
else
{
if($page == "Users") {
echo "<h1>".$players." Players online</h1>";
$players = get_data("http://api.iamphoenix.me/list/?server_ip=".$ip.":".$port."&clean=true");
$players = json_decode($players,true);
echo "<div class='alert alert-info'>This feature is actually in development.</div>";
?>
<div class="row">
<div class="col-lg-6"> 
<h3>The Team</h3>
<hr>
<div class="row">
<div class="col-lg-8">
Username
</div>
<div class="col-lg-4">
Position
</div>
</div>
<br />
<div class="row">
<div class="col-lg-8">
User
</div>
<div class="col-lg-4" style="color: red;">
Owner
</div>
</div>
</div>

<div class="col-lg-6">
<h3>Registered users</h3>
<hr>
<?php
$query = $sql->query("SELECT * FROM authme");
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'><div class='col-lg-12'>";
echo $row->username;
echo "</div></div>";

}
?>
</div>
</div>
<?php
}
else
{
if($page == "Ranking") {
if($screen == "Jobs") {
?>
<div class="row">
<div class="col-lg-12">
<h1>Jobs</h1>
<hr>
</div>
</div>
<?php
if($job == "Woodcutter") {
?>

<div class="row">
<div class="col-lg-12">
<center><h3>Woodcutter</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Woodcutter' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
</div>
<?php } elseif($job == "Miner") { ?>
<div class="col-lg-12">
<center><h3>Miner</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Miner' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
<?php } elseif($job == "Builder") { ?>
<div class="col-lg-4">
<center><h3>Builder</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Builder' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
<?php } elseif($job == "Digger") { ?>
<div class="row">
<div class="col-lg-12">
<center><h3>Digger</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Digger' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
<?php } elseif($job == "Farmer") { ?>
<div class="col-lg-12">
<center><h3>Farmer</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Farmer' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
<?php } elseif($job == "Hunter") { ?>
<div class="col-lg-12">
<center><h3>Hunter</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Hunter' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
</div>
<?php } elseif($job == "Fisherman") { ?>
<div class='col-lg-12'>
<center><h3>Fisherman</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Fisherman' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
<?php } elseif($job == "Weaponsmith") { ?>
<div class='col-lg-12'>
<center><h3>Weaponsmith</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Weaponsmith' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
<?php } elseif($job == "Brewer") { ?>
<div class="col-lg-12">
<center><h3>Brewer</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Brewer' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
<?php } elseif($job == "Enchanter") { ?>
<div class="col-lg-12">
<center><h3>Enchanter</h3></center>
<hr>
<?php
$query = $sql->query("SELECT * FROM jobs_jobs WHERE job='Enchanter' ORDER BY level DESC LIMIT 25");
echo "<div class='row'>";
echo "<div class='col-lg-9'>User</div>";
echo "<div class='col-lg-3'>Level</div>";
echo "</div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-9'>".$row->username."</div>";
echo "<div class='col-lg-3'>".$row->level."</div>";
echo "</div>";
}
?>
</div>
</div>
<?php
} else {
?>
<div class="col-lg-12">
<center><h3>Job Selection</h3></center>
<!--
This also needs a better solution
-->
<hr>
</div>
<center>
<div class="row">
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Woodcutter'>Woodcutter</a></h3>
</div> 
<div class="col-lg-1"></div>
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Miner'>Miner</a></h3>
</div>
<div class="col-lg-1"></div>
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Builder'>Builder</a></h3>
</div>
<div class="col-lg-1"></div>
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Digger'>Digger</a></h3>
</div>
</div>
<div class="row">
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Farmer'>Farmer</a></h3>
</div> 
<div class="col-lg-1"></div>
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Hunter'>Hunter</a></h3>
</div>
<div class="col-lg-1"></div>
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Fisherman'>Fisherman</a></h3>
</div>
<div class="col-lg-1"></div>
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Weaponsmith'>Weaponsmith</a></h3>
</div>
</div>
<div class="row">
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Brewer'>Brewer</a></h3>
</div>
<div class="col-lg-2">
</div>
<div class="col-lg-2 well">
<h3><a href='intern.php?page=Ranking&screen=Jobs&job=Enchanter'>Enchanter</a></h3>
</div>
</div>
</center>
<?php
}
}
else
{
if($screen == "Money") {
?>
<div class="col-lg-12">
<h1>Players with the most money</h1>
<hr>
<?php
echo "<div class='row'>";
echo "<div class='col-lg-8'>Player</div>";
echo "<div class='col-lg-4'>Money</div>";
echo "</div>";
$query = $sql->query("SELECT * FROM `fe_accounts` ORDER BY `money` DESC LIMIT 0 , 25");
while($row = mysqli_fetch_object($query)) {

echo "<div class='row'>";
echo "<div class='col-lg-8'>".$row->name."</div>";
echo "<div class='col-lg-4'>".$row->money."&euro;</div>";
echo "</div>";
}
?>
</div>
<?php
} elseif($screen == "Time") {
?>
<div class="col-lg-12">
<h1>Player with the longest playtime</h1>
<hr>
<?php
echo "<div class='row'>";
echo "<div class='col-lg-8'>Player</div>";
echo "<div class='col-lg-4'>Playtime</div>";
echo "</div>";
$query = $sql->query("SELECT * FROM `Stats_player` ORDER BY `playtime` DESC LIMIT 0 , 25");
while($row = mysqli_fetch_object($query)) {

$time = round($row->playtime / 3600,2);
echo "<div class='row'>";
echo "<div class='col-lg-8'>".$row->player."</div>";
echo "<div class='col-lg-4'>".$time." Hours</div>";
echo "</div>";
}
?>
</div>
<?php
} elseif($screen == "HungerGames") {
?>
<h1>Hungergames</h1>
<hr>
<?php
$query = $sql->query("SELECT MAX(*) FROM `sg_gamestats` DESC LIMIT 25");
echo "<div class='row'><div class='col-lg-8'>Player</div><div class='col-lg-4'>Games won</div></div>";
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'>";
echo "<div class='col-lg-8'>";
echo $row->winner;
echo "</div>";
echo "<div class='col-lg-4'>";
$winner = $row->winner;
echo mysqli_num_rows($sql->query("SELECT * FROM `sg_gamestats` WHERE winner = '$winner'"));
echo "</div>";
echo "</div>";
}
} else {
?>

<?php
}
}
} else {
if($page == "Shop") {
function element($item,$itemid,$money,$count) {
echo "<form action='intern.php?page=Shop&action=Pay&item=".$itemid."&money=".$money."&count=".$count."' method='POST'>";
?>

<h3><?php echo $item; ?></h3>
<br />
<strong>Pieces:</strong> <?php echo $count; ?><br />
<strong>Price:</strong> <?php echo $money; ?>&euro;<br />
<input type="submit" class="btn btn-info" value="Buy"/>
</form>
<?php
}
if($action == "Pay") {
$item = isset($_GET['item']) ? $_GET['item'] : false;
$player = $_SESSION["user"];
$money = isset($_GET['money']) ? $_GET['money'] : false;
$count = isset($_GET['count']) ? $_GET['count'] : false;
$ws = new Websend($ip, 4445); 

//Replace with password specified in Websend config file
$ws->connect($rcon_pw);

$ws->doCommandAsConsole("give $player $item $count");
$ws->doCommandAsConsole("fe deduct $player $money");
$ws->disconnect();
echo "<div class='alert alert-info'>You bought this thing successfully!</div>";
}
?>
<h1>Shop</h1>
<div class="alert alert-info">Welcome to the Shop.Here you can pay <strong>only</strong> with Ingame-Money. <strong>You have to be online! Otherwhise you don't get your thing!</strong></div>
<!--I will recode this -->
<hr>
<div class="row">
<div class="col-lg-3">
<?php echo element("Wooden Planks","5","50","64"); ?>           
</div>
<div class="col-lg-3">
<?php echo element("Cobblestone","4,","50","64"); ?>
</div>
<div class="col-lg-3">
<?php echo element("Grass","2","5","64"); ?>
</div>
<div class="col-lg-3">
<?php echo element("Dirt","3","5","64"); ?>
</div>
</div>
<div class="row">
<div class="col-lg-3">
<?php echo element("Wood","15","25","64"); ?>
</div>
<div class="col-lg-3">
<?php echo element("Glass","20","100","64"); ?>
</div>                                       
<div class="col-lg-3">
<?php echo element("Wool","35","200","64"); ?>
</div>
<div class="col-lg-3">
<?php echo element("Double Stab","43","250","64"); ?>
</div>
</div>
<div class="row">
<div class="col-lg-3">
<?php echo element("Torch","50","100","64"); ?>
</div>
<div class="col-lg-3">
<?php echo element("Emerald","129","2500","64"); ?>
</div>                                       
<div class="col-lg-3">
<?php echo element("Coal","263","200","64"); ?>
</div>
<div class="col-lg-3">
<?php echo element("Iron","15","500","64"); ?>
</div>
</div>
<center>
<div class="row">
<div class="col-lg-6">
<?php echo element("Gold","14","500","64"); ?>
</div>
<div class="col-lg-6">
<?php echo element("Lapis Lazuli","21","1000","64"); ?>
</div>
</div>
</center>
<?php

} else {

if($page == "Logout") {
unset($_SESSION['user']);
header("Location: index.php");
} else { if($page == "Userlist") {
} else {
if($page == "Support") {
if(empty($screen)) {
?>
<h1>Support</h1>
<div class="alert alert-info">Here you can see a list of written support tickets by you and write a new one.</div>
<hr>
<div class="row">
<div class="col-lg-6">
<h3>Written support tickets:</h3>
<hr>
<div class="row">
<div class="col-lg-6">
Titel
</div>
<div class="col-lg-4">
Datum
</div>
<div class="col-lg-2">
Status
</div>
</div>

<?php

$player = $_SESSION['user'];
$query = $sql->query("SELECT * FROM support WHERE user='$player'");
while($row = mysqli_fetch_object($query)) {
echo '<div class="row">
<div class="col-lg-6">';
echo "<a href='intern.php?page=Support&screen=ViewTicket&id=".$row->supportID."'>".$row->title."</a>";
echo '</div>
<div class="col-lg-4">';
echo $row->timestamp;
echo '</div>
<div class="col-lg-2">';
if($row->status == 0) { echo 'Geschlossen'; }
elseif($row->status == 1) { echo 'Offen'; }
else { echo 'Fehler'; }
echo '</div>';
echo '</div>';
}
?>

</div>
<div class="col-lg-6">
<h3>Write a new support ticket:</h3>
<hr>
<form class="form-horizontal" role="form" action="intern.php?page=Support&screen=Big&action=Send" method="POST">
  <div class="form-group">
    <label for="title" name="user" class="col-sm-2 control-label">Title</label>
    <div class="col-sm-10">
      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
    </div>
  </div>
    <div class="form-group">
    <label for="text" class="col-sm-2 control-label">Content</label>
    <div class="col-sm-10">
       <textarea placeholder="Content" name="text" class="form-control2" style="height: 100px;"></textarea>
    </div>
</div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-default">Send ticket</button>
    </div>
    <div class="col-sm-4">
    <a href="intern.php?page=Support&screen=Big">Big editor</a><br />
    </div>
  </div>
</form>
</div>
<?php
}
elseif($screen == "Big") {
if($action == "Send") {
$title = $sql->real_escape_string($_POST['title']);
$text  = $sql->real_escape_string($_POST['text']);
$status = 1;
$timestamp = date("d.m.Y H:i");
$player = $_SESSION['user'];
if(empty($title) || empty($text)) {
echo "<div class='alert alert-warning'>You have to fill in the complete form!</div>";
} else
{
$sql->query("INSERT INTO `support_tickets` (`title` ,`user` ,`member` ,`text` ,`timestamp` ,`status`,`read`)VALUES ('$title', '$player', 'Keiner', '$text', '$timestamp', '$status', '1')");
echo "<div class='alert alert-info'>Thanks for your support ticket. We will reply soon.</div>";
}
}
?>
<div class="row">
<div class="col-lg-12">
<h1>Write a support ticket</h1>
<hr>
<form class="form-horizontal" role="form" action="intern.php?page=Support&screen=Big&action=Send" method="POST">
  <div class="form-group">
    <label for="title" name="user" class="col-sm-2 control-label">Title</label>
    <div class="col-sm-10">
      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
    </div>
  </div>
    <div class="form-group">
    <label for="text" class="col-sm-2 control-label">Content</label>
    <div class="col-sm-10">
       <textarea placeholder="Content" name="text" class="form-control2" style="height: 150px;"></textarea>
    </div>
</div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-default">Send ticket</button>
    </div>
  </div>
</form>
</div>
</div>
<?php
} elseif($screen == "ViewTicket") {
if($action == "Answer") {
$answer = $sql->real_escape_string($_POST['answer']);
if(empty($answer)) {
echo "<div class='alert alert-warning'>You didn't make an answer.</div>";
} else {
$timestamp = date("d.m.Y H:i");
$member = $_SESSION['user'];
$usera = "";
$id = isset($_GET['id']) ? $_GET['id'] : false;
$sql->query("INSERT INTO `support_answers` (`supportID`, `usera`, `userm`, `text`, `timestamp`) VALUES ('$id', '$member', '', '$answer', '$timestamp');");
$sql->query("UPDATE `support_tickets` SET read = 1 WHERE supportID='$id'");
echo "<div class='alert alert-info'>Answer was successfully sent.</div>";
}
}
$id = isset($_GET['id']) ? $_GET['id'] : false;
$info = mysqli_fetch_object($sql->query("SELECT * FROM support_tickets WHERE supportID='$id'"));
$status = $sql->query("UPDATE support__tickets SET status = 0 WHERE supportID='$id'");
if($status == 0) { $status = "Geschlossen"; } elseif($status == 1) { $status = "Offen"; } else { echo "Unbekannter Status"; }
echo "<h1>Support-Ticket #".$info->supportID.": ".$info->title." | Status: $status</h1>";
echo "by ".$info->user. " am ".$info->timestamp." | Worker: ".$info->member.'<div class="row">';
echo "</div><hr>";
echo "<div class='well'>";
echo nl2br($info->text);
echo "</div><br />";
$query = $sql->query("SELECT * FROM support_answers WHERE supportID='$id'");
while($row = mysqli_fetch_object($query)) {
echo "<div class='well'>";
if($row->usera == "") {
echo "Written by ".$row->userm. " Date: ".$row->timestamp."<hr>";
} elseif($row->userm == "") {
echo "Written by ".$row->usera. " Date: ".$row->timestamp."<hr>";
}
echo nl2br($row->text);
echo "</div>";
}
echo "<div class='well'>";
if($status == 1) { echo "<div class='alert alert-info'>The Ticket was closed.</div>"; } else {
echo'<form action="intern.php?page=Support&screen=ViewTicket&id='.$id.'&action=Answer" method="POST" role="form" class="form-horizontal">'; ?>
  <div class="form-group">
    <div class="col-sm-12">
    <textarea name="answer" id="user" placeholder="Answer" class="form-control2" style="height: 200px;"></textarea>
    </div>
  </div>  
  <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default">Answer</button>
    </div>
  </div>
</form>
<?php
 }
} else {
echo "<h1>404</h1>";
echo "<div class='alert alert-warning'>This page does not exist!</div>";
}
}
else
{
if($page == "ForgetIt") {
echo "<div class='alert alert-warning'>You're not allowed to access this page!</div>";
}
else
{
echo "<h1>Welcome ".$_SESSION['user']."!</h1>";
?>
<div class="row">
<div class="col-lg-5 well">
<h3>Information about you</h3>
<hr>
<?php
$player = $_SESSION['user'];
echo "<strong>Playtime: </strong>";
$time = mysqli_fetch_object($sql->query("SELECT * FROM `Stats_player` WHERE `player` = '$player'"));
$time = round($time->playtime / 3600,2);
echo $time . " Hours<br />";
echo "<strong>Money: </strong>";
$bank = mysqli_fetch_object($sql->query("SELECT * FROM `fe_accounts` WHERE `name` = '$player'"));
echo $bank->money."&euro;";
?>
</div>
<div class="col-lg-2"></div>
<div class="col-lg-5 well">
<h3>Fastnavigation:</h3>
<hr>
<a href="intern.php?page=Support">Write Support Ticket</a><br />
<?php echo "<a href=".$forum_link.">Forum</a>"; ?><br />
<a href="intern.php?page=Settings">Settings</a>


</div>
</div>
<?php
}
}
}
}
}
}
}
}
?>
</div>
<hr>
Minecraft Webinterface made by <a href="http://www.nownewstart.net">NowNewStart</a>.
  <script type="text/javascript" src='js/jquery.js'></script>
    <script type="text/javascript" src='js/bootstrap.min.js'></script>
</body>
</html>
