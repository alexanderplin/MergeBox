<?php
require_once realpath(dirname(__FILE__) . '/../lib/google-api-php-client-master/autoload.php');
$client_id = '897620548575-vvoqcl312q1bh02mnp62uo9ae97ae9l6@developer.gserviceaccount.com';
$client_secret = 'VsiFzxOiNnklKdmtTnmeKEem';
$redirect_uri = 'http://localhost/link_accounts.php?refer=GDrive';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setAccessType('offline');
$client->setScopes('https://www.googleapis.com/auth/drive');
$client->setAccessType('offline');
$service = new Google_Service_Drive($client);

$client->setAccessToken($_SESSION['accounts'][$thing]['token']);
if($client->isAccessTokenExpired())
{
	$refreshT = $client->getRefreshToken();
	$client->getAuth()->refreshToken($refreshT);
	$newaccesstoken = $client->getAccessToken();
	query("UPDATE service_accounts SET service_accessToken = ? WHERE id = ?" ,serialize($newaccesstoken), $thing);
	reload_accounts();
}
$folderid = $_POST['path'];
if($_POST['oldrole'] == "none" && $_POST['oldtype'] == "none" && $_POST['oldvalue'] == "none")
{
	$service->permissions->delete($_POST['fileid'], "anyone");
	print "anyone didnt exist";
}
else
{
	print "previous permissions existed";
	$permission = $service->permissions->get($folderid, "anyone");
    $permission->setRole($_POST['oldrole']);
    $permission->setType($_POST['oldtype']);
    $permission->setValue($_POST['oldvalue']);
}
?>