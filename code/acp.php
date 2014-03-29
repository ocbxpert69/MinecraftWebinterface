<?php
include 'global.php';
$webinterface_version = "013";
$data = get_data("http://api.iamphoenix.me/players/?server_ip=".$ip.":".$port."&clean=true"); 
$data = json_decode($data, true);  
isset($data["players"]) ? $data["players"] : false;   
if(!isset($data["players"])) { $data["players"] = 0; }
include_once 'Websend.php';
      #Simple way to allow more people to access this:
      #if($_SESSION['user'] == "User") is the main line
      #if($_SESSION['user'] == "User" || $_SESSION['user'] == "User2") would be for two users
      #if($_SESSION['user'] == "User" || $_SESSION['user'] == "User2" || $_SESSION['user'] == "User"3) would be for three users
      #Extend this how you want. I'll add a better possibility later. Sorry for that.
      if(in_array($_SESSION['user'],$admins)) {
?>
<!DOCTYPE html>
<head>
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
var iframe;
window.onload = function()
{
  iframe = document.getElementById("logFrame");
  window.setInterval("RefreshIFrame()", 20000); // 60000 ms = 60 Sek.
}
function RefreshIFrame()
{
  iframe.location.reload();
}
</script>
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
    <a class="navbar-brand" href="acp.php"><?php echo $header; ?></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li><a href="acp.php?page=Console">Console</a></li>
      <li><a href="acp.php?page=Users">Usermanagement</a></li>
      <li><a href="acp.php?page=News">News</a></li>
      <li><a href="acp.php?page=Support">Support</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="intern.php"><strong><?php echo $data['players']." User online"; ?></strong></a></li>
      <li><a href="intern.php">Back</a></li>
    </ul>
  </div>
</nav>

<div class="container" style="margin-top: 10px; padding-top: 10px;">
<?php
if($page == "Console") {
if($action == "Exec") {
$command = $_POST['command'];
if(empty($command)) {
echo "<div class='alert alert-danger'>You have to insert a command.</div>";
} else {
$ws = new Websend($ip, 4445); 

//Replace with password specified in Websend config file
$ws->connect($rcon_pw);

$ws->doCommandAsConsole("$command");
$ws->disconnect();
echo "<div class='alert alert-info'>Command succesfully performed.</div>";
}
}
?>
<form action="acp.php?page=Console&action=Exec" method="POST" class="form-horizontal" role="form">
  <div class="form-group">
    <label for="command"  class="col-sm-2 control-label">Command</label>
    <div class="col-sm-10">
      <input type="text" name="command" class="form-control" id="user" placeholder="Command" />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Send</button>
    </div>
  </div>
</form>
<?php
echo "<h2>Log</h2>";
echo "<div class='well'>";
echo "<iframe src='log.php' id='logFrame' width='100%' height='400px;' style='border: none;'>Your browser does not allow iFrames.</iframe>";
echo "</div>";
}
else
{
if($page == "Users") {
?>
<h1>Usermanagement</h1>
<hr>
<?php
function ban($bannuser) {
$ws = new Websend($ip, 4445); 
                   
//Replace with password specified in Websend config file
$ws->connect($rcon_pw);

$ws->doCommandAsConsole("ban $bannuser");
$ws->disconnect();
echo "<div class='alert alert-info'>$bannuser was banned.</div>";
}
function tban($bannuser,$time) {
$ws = new Websend($ip, 4445); 
$time = $time * 3600;
//Replace with password specified in Websend config file
$ws->connect($rcon_pw);
$h = $time / 3600;
$ws->doCommandAsConsole("tempban $bannuser $time");
$ws->disconnect();
echo "<div class='alert alert-info'>$bannuser was banned for $h Hours.</div>";
}
function unban($bannuser) {
$ws = new Websend($ip, 4445); 
//Replace with password specified in Websend config file
$ws->connect($rcon_pw);

$ws->doCommandAsConsole("unban $bannuser");
$ws->disconnect();
echo "<div class='alert alert-info'>$bannuser was unbanned.</div>";
}
if($action == "Ban") {
$a = isset($_GET['user']) ? $_GET['user'] : false;
ban($a);
}
if($action == "TBann") {
$a = isset($_GET['user']) ? $_GET['user'] : false;
?>
<h1>TempBan</h1>
<p>How long do you want to ban <?php echo $a; ?>?</p>
<?php
echo '<form action="acp.php?page=Users&action=RTBann&user='.$a.'" method="POST">';
?>
  <div class="form-group">
    <label for="post"  class="col-sm-2 control-label">Time (in hours):</label>
    <div class="col-sm-10">
    <input type="number" step="1" name="time" id="time" placeholder="Time (in hours)" class="form-control2" />
    </div>
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-primary">TempBan</button>
  </div>
<?php
}
if($action == "RTBann") {
$a = isset($_GET['user']) ? $_GET['user'] : false;
$t = $_POST['time'];
tban($a,$t);
}
if($action == "Unban") {
$a = isset($_GET['user']) ? $_GET['user'] : false;
unban($a);
}
$var = $status->online;
if($var == 0) {} else {
?>
<div class="row">
<div class='col-lg-6'>User</div>
<div class='col-lg-2'>Ban</div>
<div class="col-lg-2">Tempban</div>
<div class="col-lg-2">Unban</div>
</div>
<br />
<?php
$query = $sql->query("SELECT * FROM authme");
while($row = mysqli_fetch_object($query)) {
echo "<div class='row'><div class='col-lg-6'>";
echo $row->username;
echo "</div>";
echo "<div class='col-lg-2'>";
echo "<a href='acp.php?page=Users&action=Ban&user=".$row->username."'>Ban</a>";
echo "</div>";
echo "<div class='col-lg-2'>";
echo "<a href='acp.php?page=Users&action=TBann&user=".$row->username."'>TempBan</a>";
echo "</div>";
echo "<div class='col-lg-2'>";
echo "<a href='acp.php?page=Users&action=Unban&user=".$row->username."'>Unban</a>";
echo "</div>";
echo "</div>";

}
}
}
else
{
if($page == "News") {
if($action == "Perform") {
$post = $sql->real_escape_string($_POST['post']);
if(empty($post)) {
echo "<div class='alert alert-danger'>You didn't enter something</div>";
} else {
$timestamp = date("d.m.Y H:i");
$user = $_SESSION['user'];
$sql->query("INSERT INTO `news` (`poster` ,`text` ,`timestamp` )VALUES ('$user', '$post', '$timestamp');");
echo "<div class='alert alert-info'>You successfully sent a news article.</div>";
}
}
?>
<h1>News posten</h1>
<hr>
<form action="acp.php?page=News&action=Perform" method="POST" role="form" class="form-horizontal">
  <div class="form-group">
    <label for="post"  class="col-sm-2 control-label">Post News:</label>
    <div class="col-sm-10">
    <textarea name="post" id="user" placeholder="Post news" class="form-control2" style="height: 200px;"></textarea>
    </div>
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-primary">Post news</button>
  </div>
</form>
<?php
}
else
{
if($page == "Support") {
if($screen == "ViewMessage") {
if($action == "SetWorker") {
$id = isset($_GET['id']) ? $_GET['id'] : false;
$member = $_SESSION['user'];
$sql->query("UPDATE `mc`.`support_tickets` SET member = '$member' WHERE supportID='$id'");
echo "<div class='alert alert-info'>You're now the worker of this ticket.</div>";
}
if($action == "SetClosed") {
$id = isset($_GET['id']) ? $_GET['id'] : false;
$sql->query("UPDATE support_tickets SET status = 0 WHERE supportID='$id'");
echo "<div class='alert alert-info'>You closed this ticket.</div>";
}
if($action == "Answer") {
$answer = $sql->real_escape_string($_POST['answer']);
if(empty($answer)) {
echo "<div class='alert alert-warning'>You didn't enter an answer.</div>";
} else {
$timestamp = date("d.m.Y H:i");
$member = $_SESSION['user'];
$usera = "";
$id = isset($_GET['id']) ? $_GET['id'] : false;
$sql->query("INSERT INTO `support_answers` (`supportID`, `usera`, `userm`, `text`, `timestamp`) VALUES ('$id', '', '$member', '$answer', '$timestamp');");
$sql->query("UPDATE `support_tickets` SET read = 0 WHERE supportID='$id'");
echo "<div class='alert alert-info'>Your answer was sent.</div>";
}
}
?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : false;
$info = mysqli_fetch_object($sql->query("SELECT * FROM support_tickets WHERE supportID='$id' ORDER BY supportID ASC"));
$status = $info->status;
if($status == 0) { $status = "Geschlossen"; } elseif($status == 1) { $status = "Offen"; } else { echo "Unbekannter Status"; }
echo "<h1>Support-Ticket #".$info->supportID.": ".$info->title." | Status: ".$status."</h1>";
echo "by ".$info->user. " Date: ".$info->timestamp." |Worker: ".$info->member.'<div class="row">';
if($info->member == "Nobody") {
?>

<div class="col-lg-2">
<?php echo '<form action="acp.php?page=Support&screen=ViewMessage&id='.$id.'&action=SetWorker" method="POST">'; ?>
  <div class="form-group">
      <button type="submit" class="btn btn-primary">Set yourself as Worker</button>
  </div>
</form>
</div>
<?php
}
if($status == 1) { ?>
<div class="col-lg-2">
<?php echo'<form action="acp.php?page=Support&screen=ViewMessage&id='.$id.'&action=SetClosed" method="POST">'; ?>
  <div class="form-group">
      <button type="submit" class="btn btn-primary">Close Ticket</button>
  </div>
</form>
</div>

<?php
}
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
?>
<?php echo'<form action="acp.php?page=Support&screen=ViewMessage&id='.$id.'&action=Answer" method="POST" role="form" class="form-horizontal">'; ?>
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
else
{
?>
<h1>Support-Bereich</h1>
<div class="alert alert-info">You can answer support tickets written by user here.</div>
<hr>
<div class="row">

<div class="col-lg-12">
<h3>Open Support-Tickets</h3>
<hr>
<div class="row">
<div class="col-lg-6">
Title
</div>
<div class="col-lg-3">
User</div>
<div class="col-lg-3">
Worker
</div>
</div>
<?php
$query = $sql->query("SELECT * FROM support_tickets WHERE status=1");
while($row = mysqli_fetch_object($query)) {
echo '<div class="row">
<div class="col-lg-6"><a href="acp.php?page=Support&screen=ViewMessage&id='.$row->supportID.'">'.$row->title."</a>";
echo '</div>
<div class="col-lg-3">';
echo $row->user;
echo '</div>
<div class="col-lg-3">';
echo $row->member;
echo '</div>
</div>';
}
?>
</div>


</div>
<?php
}
}
else
{
?>
<h1>Welcome <?php echo $_SESSION['user']; ?></h1>
<div class="row">
<?php
$wv = get_data("http://www.nownewstart.net/mc/check.php?version=".$webinterface_version);
if(empty($wv)) {

}
else
{
echo "<div class='alert alert-info'>A new version of the Webinterface is out. Check it out <a href='https://github.com/NowNewStart/MinecraftWebinterface/releases'>here</a></div>";
}
?>
<div class="col-lg-6">
<h4>Server-Information:</h4>  <hr>
<?php
$v = get_data("http://api.iamphoenix.me/software/?server_ip=".$ip); 
$v = json_decode($v, true);
error_reporting(E_ALL ^ E_NOTICE);
if(empty($v['software'])) { $version = "Unknown"; } else { $version = $v['software']; }
echo "<strong>Server Version: </strong>".$version."<br />";  
?>
<strong>Installed Plugins: </strong>
<a href="#" data-toggle="modal" data-target="#pluginModal">Open List</a><br />
<?php
$mv = get_data("http://api.iamphoenix.me/version/?server_ip=".$ip); 
$mv = json_decode($mv, true);
$mmv = $mv["version"];
if(empty($mvv)) {
$mmv = "Unknown";
}
echo "<strong>Minecraft Version: </strong> $mmv<br />";

$s = get_data("http://api.iamphoenix.me/status/?server_ip=".$ip);
$s = json_decode($s, true);
$s = $s["status"];
if($s == "true") {
echo "<strong>Server Status: </strong> Online<br />";
} elseif($s == "false") {
echo "<strong>Server Status: </strong> Offline<br />";
} else {
echo "<strong> Server Status: </strong> Unknown<br />";
}
$p = get_data("http://api.iamphoenix.me/players/?server_ip=".$ip);
$p = json_decode($p, true);
$p = $p["players"];
if($p == 0 || empty($p))
{
$p = 0;
}
echo "<strong>Players: </strong> $p Players are online!";
?>


<div class="modal fade" id="pluginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Plugin List</h4>
      </div>
      <div class="modal-body">
        <?php
          $v = get_data("http://api.iamphoenix.me/plugins/?server_ip=".$ip); 
          $v = json_decode($v, true);
          $v2 = $v["plugins"];
          $p = explode(",",$v2);
          for($i=1;$i<count($p);$i++) {
          echo $p[$i]."<br />";
          }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
<div class="col-lg-6">
<h4>Quick Settings</h4> 
<hr>
<?php
if($action == "Start") {
#ToDo
} elseif($action == "Stop") {
$ws = new Websend($ip, 4445); 

//Replace with password specified in Websend config file
$ws->connect($rcon_pw);

$ws->doCommandAsConsole("stop");
$ws->disconnect();
echo "<div class='alert alert-info'>Server stops....</div>";
} elseif($action == "Reload") {
$ws = new Websend($ip, 4445); 

//Replace with password specified in Websend config file
$ws->connect($rcon_pw);

$ws->doCommandAsConsole("reload");
$ws->disconnect();
echo "<div class='alert alert-info'>Reloading....</div>";
}
?>
<form action="acp.php?page=Console&action=Exec" method="POST" class="form-horizontal" role="form">
  <div class="form-group">
    <label for="command"  class="col-sm-2 control-label">Send Command:</label>
    <div class="col-sm-10">
      <input type="text" name="command" class="form-control" id="user" placeholder="Command" />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Send Command</button>
    </div>
  </div>
</form>
<br>
<?php
if($s == "true") {
?>
<div class="row">
<center>
<form action="acp.php?action=Stop" method="POST" class="col-lg-6">
  <div class="form-group">
      <button type="submit" class="btn btn-danger">Stop Server</button>
  </div>
</form>
<form action="acp.php?action=Reload" method="POST" class="col-lg-6">
  <div class="form-group">
      <button type="submit" class="btn btn-primary">Reload Server</button>
  </div>
</form> 
</center>
</div>
<?php 
} elseif($s == "false") {
?>
<form action="acp.php?action=Start" method="POST">
  <div class="form-group">
      <button type="submit" class="btn btn-success">Start Server</button>
  </div>
</form>

<?php 
} else {}
?>
</div>
</div>
<?php
}
}
}
}
?>
</div>
<br><br><br><br>
<hr>
<center>
Minecraft Webinterface made by <a href="http://www.nownewstart.net">NowNewStart</a>.
</center>
  <script type="text/javascript" src='js/jquery.js'></script>
    <script type="text/javascript" src='js/bootstrap.min.js'></script>
</body>
</html>
<?php
} else {
echo $_SESSION['user'];
} 
?>