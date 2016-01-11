<?php
require("../includes/config.php"); 
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['service']))
	{
		if($_POST['service'] == "GDrive")
		{
			require("../functions/link_GDrive.php");
		}
		else if($_POST['service'] == "Dropbox")
		{
			require("../functions/link_dropbox.php");
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['refer']))
	{
		if($_GET['refer'] == "GDrive")
		{
			require("../functions/link_GDrive.php");
		}
		else if($_GET['refer'] == "Dropbox")
		{
			require("../functions/link_dropbox.php");
		}
	}
	else
	{
		require("404.html");
	}
	refresh_accounts();
?>