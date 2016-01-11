<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        // query database for user
        $rows = query("SELECT * FROM users WHERE username = ?", $_POST["username"]);

        // if we found user, check password
        if (count($rows) == 1)
        {
            $row = $rows[0];
            // compare hashes to see if the same
            if (password_verify($_POST["password"], $row["password"]))
            {
                // store session
                $_SESSION["id"] = $row["id"];
		        $_SESSION["username"] = $row["username"];
                reload_accounts(); 
		          echo true;
            }
        }
        else{echo false;}
    }
?>