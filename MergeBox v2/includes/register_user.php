<?php
require("../includes/config.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password']))
    {
    	query("INSERT INTO users (first_name, last_name, username, password) VALUES(?, ?, ?, ?)", $_POST["first_name"],$_POST["last_name"],$_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT))
    }
?>