<?php 
require("../includes/config.php");
	if(isset($_GET["link"]) && $_GET['link'] =="success")
	{
		render("link_form.php",["link" => "success", "service" => $_GET['service']]);
	}
	else
	{
		render("link_form.php");
	}
?>