<?php
require("../includes/config.php");
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['action']))
{
	if($_POST['action'] == "register")
	{
		print_r(query("INSERT INTO users (first_name, last_name, username, password) VALUES(?, ?, ?, ?)", $_POST["first_name"],$_POST["last_name"],$_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT)));
		echo "yay";
	}
	else if($_POST['action'] == "login")
	{
		$_SESSION["sidebar_collapse"] = FALSE;
		require("../includes/checklogin.php");
	}
	else if($_POST['action'] == "request_files")
	{
		/*
		$requested = json_decode($_POST['files']);
		$requested = array_filter($requested);
		foreach($requested as $temp)
		{
			foreach($temp as $serviceids)
			{
				print_r($_SESSION['accounts'][$serviceids]);
			}
		}*/
		$thing = $_POST['files'];
		if($_SESSION['accounts'][$thing]['service_name'] == 1)
		{
			require("dropbox_file.php");
		}
		else if($_SESSION['accounts'][$thing]['service_name'] == 3)
		{
			require("gdrive_file.php");
		}
	}
	else if($_POST['action'] == "collapse_sidebar")
	{
		$_SESSION["sidebar_collapse"]  = !($_SESSION["sidebar_collapse"]);
	}
	else if($_POST['action'] == "Gdrive_reset_permissions")
	{
		$thing = $_POST['files'];
		require("gdrive_permission.php");
	}
}
?>