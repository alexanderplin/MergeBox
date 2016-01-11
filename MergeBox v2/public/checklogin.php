<?php
require("../includes/config.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        // query database for user
        $rows = query("SELECT * FROM users WHERE username = ?", $_POST["username"]);

        // if we found user, check password
        if (count($rows) == 1)
        {
            $row = $rows[0];
            // compare hashes to see if the same
            if (crypt($_POST["password"], $row["password"]) == $row["password"])
            {
		
		        $_SESSION["accounts"] = [];
                // store session
                $_SESSION["id"] = $row["id"];
		        $_SESSION["username"] = $row["username"];

		    $accounts = query("SELECT * FROM service_accounts WHERE user_id = ?", $_SESSION["id"]);
		    foreach ($accounts as $account) {
		    $tmp = array_fill_keys(array('account_id','name', 'email', 'token'), '');
		    #using each of OAuth tokens, get root folder data
            $accountid = $account["account_id"];
        	//$client = new dbx\Client($account["service_accessToken"], "PHP");
		    $tmp["email"]  = $account["service_email"];
		    $tmp["name"] = $account["service_name"];
		    //$tmp["token"] = serialize($client);
		    $tmp['account_id'] = $accountid;
		
		    $_SESSION["accounts"]["$accountid"] = $tmp; 
            }
		      echo true;
            }
        }
        else{echo false;}
    }
?>