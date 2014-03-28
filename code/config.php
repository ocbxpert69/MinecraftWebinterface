<?php
#Config File for Minecraft Webinterface
#Please walktrough





#MySQL Settings
$mserver = "localhost";    #What's your MySQL Server?
$muser   = "root";          #What's the name of your user
$mpass   = "root";      #What's his password?
$mdb     = "webi";      #Where are the tables?


#Server Settings
$ip      = "127.0.0.1";    #What's the IP of your Minecraft server?
$rcon_pw = "rconpass";     #What is the recon password? Check if it's set and enabled in server.properties
$port    = "25565";        #Port of your Minecraft Server
$ts_ip   = "127.0.0.1";    #Teamspeak IP
$ts_port = "9987";          #Port of your Teamspeak Server

#Page Settings
$title   = "Minecraft Server"; # Set the Title of the Pages
$header  = "MC Server";        # Text in the Navigation Bar
$forum_link = "http://link.to/forum";
$admins = array("Admin1","Admin2","NowNewStart"); #Set Admins who can access the control panel
?>