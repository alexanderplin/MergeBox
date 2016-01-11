<?php

// configuration
require("../includes/config.php");

// GET response
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // else render form
    render("register_form.php", ["title" => "Register"]);
}

// POST response
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"]))
        apologize("Please Provide a Username");
    else if (empty($_POST["password"]))
        apologize("Please Provide a Password");
    else if (empty($_POST["confirmation"]))
        apologize("Please Confirm Your Password");
    else if (!(strcmp($_POST["confirmation"], $_POST["password"]) == 0))
        apologize("Passwords do not Match");
    
    if (count(query("SELECT * FROM users WHERE username = ?", $_POST["username"])) == 1)
        apologize("Username taken");
    else {
        if (query("INSERT INTO users (username, password) VALUES(?, ?)", $_POST["username"], crypt($_POST["password"])) === false)
            apologize("Could Not Register User");
        else {
            // Remember the session
            if (count(query("SELECT LAST_INSERT_ID() AS id")) == 1) {
                $id = $rows[0]["id"];
                
                $_SESSION["id"] = $id;
                redirect("/");
            }
        }
    }
    
} else {
    // else render form
           render("register_form.php", ["title" => "Register"]);
}
?>
