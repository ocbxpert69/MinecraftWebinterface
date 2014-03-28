<?php
#Config File for Minecraft Webinterface
#Please walktrough





#MySQL Settings
$mserver = "localhost";    #What's your MySQL Server?
$muser   = "root";          #What's the name of your user
$mpass   = "namasu69";      #What's his password?
$mdb     = "mc";      #Where are the tables?


#Server Settings
$ip      = "109.230.231.170";    #What's the IP of your Minecraft server?
$rcon_pw = "1337";     #What is the recon password? Check if it's set and enabled in server.properties
$port    = "25565";        #Port of your Minecraft Server
$ts_ip   = "109.230.231.170";    #Teamspeak IP
$ts_port = "9987";          #Port of your Teamspeak Server

#Page Settings
$title   = "Minecraft Server"; # Set the Title of the Pages
$header  = "MC Server";        # Text in the Navigation Bar
$forum_link = "http://jcoremc.de/forum";
$admins = array("Admin1","Admin2","NowNewStart"); #Set Admins who can access the control panel
$supporters = array("Supporter1","Supporter2"); #Set Supporters, Supporter Control Panel is coming
$log = "/home/mainserver/logs/latest.log"; #Path to your log
$lastlog = "50"; #Set how many lines should be shown as 'last log'
?>