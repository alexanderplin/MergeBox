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
	if ($_POST['path'] == "/")
	{
		$folderid = $service->about->get()->getRootFolderId();
	}
	else
	{
		$folderid = $_POST['path'];
	}

	$file = $service->files->get($folderid);
	$is_dir = $file->getMimeType();
	if($is_dir == "application/vnd.google-apps.folder")
	{
		//$directoryfiles = $service->children->listChildren($rootFolder,[]);
		$return_gdfiles = [];
		$return_gdfiles['content'] = [];
		$return_gdfiles['service_id'] = $_POST['files'];
		$return_gdfiles['type'] = "folder";
		$parameters['q'] = "'$folderid' in parents";
		$directoryfiles = $service->files->listFiles($parameters);
		foreach($directoryfiles->getItems() as $files)
		{
			$temp = [];
			$temp['name'] = $files->getTitle();
			$temp['path'] = $files->getId();
			$temp['kind'] = $files->getMimeType();
			$temp['size'] = $files->getFileSize();

			array_push($return_gdfiles['content'],$temp);
		}

		print(json_encode($return_gdfiles));
	}
	else
	{
		function set_permissions($old_role, $old_type, $old_value, $service, $folderid, $file)
		{
			$permissions = $service->permissions->listPermissions($folderid);
			$newPermission = new Google_Service_Drive_Permission();
			  $newPermission->setValue("default");
			  $newPermission->setType("anyone");
			  $newPermission->setRole("reader");
			  try {
			    $service->permissions->insert($folderid, $newPermission);
			  } catch (Exception $e) {
			    print "An error occurred: " . $e->getMessage();
			  }
			
			$link = array('type' => 'file');
	        $link['service'] = '3';
	        $link['fileid'] = $folderid;
	        $link['reset_permission'] = array('role' => $old_role, 'type' => $old_type, 'value'=> $old_value);
	        $link['permissionid'] = $permissions->getItems();
	        $link['link'] = $file->getWebContentLink();
	        print(json_encode($link));
		}

		try {
		    $old_permission = $service->permissions->get($folderid, "anyone");
		    $old_role = $old_permission->getRole();
			$old_type = $old_permission->getType();
			$old_value = $old_permission->getValue();
			set_permissions($old_role, $old_type, $old_value, $service, $folderid, $file);
		  } catch (Exception $e) {
		    set_permissions("none","none","none", $service, $folderid, $file);
		  }
		
		
		  

        //$permission_number = $service->permissions->getIdForEmail("anyone")->getId();
        //$service->permissions->update($folderid, $permission_number, $old_permission);

        //$reset_permission = $service->permissions->get($folderid, "anyone");
	    //$reset_permission->setRole($old_role);

	    //$service->permissions->update($folderid, "anyone", $reset_permission);

    	//$service->permissions->delete($folderid, "anyone");
    }

?>