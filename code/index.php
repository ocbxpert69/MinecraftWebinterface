<?php
include 'global.php';
$data = get_data("http://api.iamphoenix.me/players/?server_ip=".$ip.":".$port."&clean=true"); 
$data = json_decode($data, true); 
if(!isset($data["players"])) {
$players = 0;
} elseif(isset($data["players"])) {
$players = $data["players"];
} else {
$players = "Error";
}
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
    <a class="navbar-brand" href="index.php"><?php echo $header; ?></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li><a href="index.php?page=Login">Login</a></li>
      <li><a href="index.php?page=Register">Register</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="index.php" style="color: <?php echo $color; ?>"><span style="color:#c0c0c0">Minecraft IP :</span> <?php echo $online. " (".$players." User online)"; ?></a></li>
      <!--<li><a href="index.php" style="color: <?php echo $tsc; ?>"><span style="color:#c0c0c0">Teamspeak IP :</span> <?php echo $ton; ?></a></li>-->
    </ul>
  </div>
</nav>

<img src="img/banner.png" style="width: 100%;"/>


<div class="container" style="margin-top: 10px; padding-top: 10px;">
<?php
if($page == "Login") {
?>
<div class="col-lg-12">
<h1>Login</h1>
<?php
 if($action == "Perform") {
     $user = $sql->real_escape_string($_POST['user']);
     $pass = $sql->real_escape_string($_POST['pass']);
   if(empty($user) || empty($pass)) 
   {
      echo '<div class="alert alert-danger"><strong>Error:</strong> You have to fill in the complete form.</div>';   
   }
    else 
    {
        $num = mysqli_num_rows($sql->query("SELECT username FROM authme WHERE username = '$user'"));
        if($num == 0) 
        {
            echo "<div class='alert alert-danger'><strong>Error:</strong> There's no account matching this username.</div>";
        } 
        else 
        {
            $pw = hash('sha512',$pass);
            if($pw == $sql->query("SELECT password FROM authme WHERE username='$user'")) {
            echo "<div class='alert alert-danger'><strong>Error:</strong> Wrong password.</div>";
            } else 
            {
            
            $_SESSION['user'] = $user;
            header('Location: intern.php');
            
            }
      }
   }
 }
?>
<form class="form-horizontal" role="form" action="index.php?page=Login&action=Perform" method="POST">
  <div class="form-group">
    <label for="user" name="user" class="col-sm-2 control-label">Username</label>
    <div class="col-sm-10">
      <input type="text" name="user" class="form-control" id="user" placeholder="Username">
    </div>
  </div>
  <div class="form-group">
    <label for="pass" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" name="pass" class="form-control" id="pass" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Login</button>
    </div>
  </div>
</form>
</div>
<?php
}
elseif($page == "Register") {
?>
<div class="col-lg-12">
<h1>Registrieren</h1>
<div class='alert alert-info'>Please register ingame. An account will be created directly when you register yourself ingame.</div>
</div>
<?php
}
else
{
?>
<div class="col-lg-12">
<?php
$query = $sql->query("SELECT * FROM news ORDER BY newsID DESC LIMIT 5");
while($row = mysqli_fetch_object($query)) {
echo "<div class='well'>";
echo "Written by ".$row->poster." Date: ".$row->timestamp." <hr>";
echo nl2br($row->text)."<br />";
echo "</div>";
}
?>

</div>
<?php } ?>
</div>
<hr>
Minecraft Webinterface made by <a href="http://www.nownewstart.net">NowNewStart</a>.
  <script type="text/javascript" src='js/jquery.js'></script>                      
    <script type="text/javascript" src='js/bootstrap.min.js'></script>
</body>
</html>