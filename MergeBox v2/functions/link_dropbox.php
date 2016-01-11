<?php
    // configuration
    require("../includes/config.php"); 
    // if form was submitted
    use Dropbox as dbx;
    #dumps the access code and user id of user to mysql table
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['state']) && isset($_GET['code']))
    {
		require_once "../lib/Dropbox/autoload.php";
		function getWebAuth()
		{
		    $appInfo = dbx\AppInfo::loadFromJsonFile("../lib/Dropbox/app-info.json");
		    $clientIdentifier = "my-app/1.0";
	            $redirectUri = "http://localhost/link_accounts.php?refer=Dropbox";
	            $csrfTokenStore = new dbx\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
	            return new dbx\WebAuth($appInfo, $clientIdentifier, $redirectUri, $csrfTokenStore, "en");
		}
		#finishes authentication with access code and user id
		list($accessToken, $userId) = getWebAuth()->finish($_GET);
		#generates a client object which we can grab information with by calling getAccountInfo()
	        $client = new dbx\Client($accessToken, "PHP");
		$accountInfo = $client->getAccountInfo();
		$email = $accountInfo['email'];
		#input acess information to mysql table.
		print_r($_SESSION['id']);
		query("INSERT INTO service_accounts (user_id, service_name, service_email, service_id, service_accessToken) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE service_accessToken = ?", $_SESSION["id"], "1", $email, $userId, serialize($accessToken),serialize($accessToken));
		redirect("link.php?link=success&service=Dropbox");
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        require_once "../lib/Dropbox/autoload.php";
	#function will get a WebAuth object that will generate a url which the client authenticates the app.
	function getWebAuth()
	{
	    $appInfo = dbx\AppInfo::loadFromJsonFile("../lib/Dropbox/app-info.json");
	    $clientIdentifier = "my-app/1.0";
            $redirectUri = "http://localhost/link_accounts.php?refer=Dropbox";
            $csrfTokenStore = new dbx\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
            return new dbx\WebAuth($appInfo, $clientIdentifier, $redirectUri, $csrfTokenStore, "en");
	}
	$authorizeUrl = getWebAuth()->start();
	#redirects to dropbox authentication
	header("Location: $authorizeUrl");
    }
?>
