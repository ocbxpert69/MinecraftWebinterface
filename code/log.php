<!DOCTYPE html>
<html>
<head>
<title>Log</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
</head>
<body>
<?php
include 'config.php';
$file = file($log);
$lastlog = "-".$lastlog;
$last = array_slice($file,$lastlog);
foreach($last as $line) {
    echo $line."<br/>\n";
}
?>
</body>
</html>