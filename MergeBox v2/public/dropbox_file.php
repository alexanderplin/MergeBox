<?php
	require_once "../lib/Dropbox/autoload.php";	
	use \Dropbox as dbx;
    $client  = new dbx\Client($_SESSION['accounts'][$thing]['token'], "PHP");
    #get file information from current path;
    $path = $_POST['path'];
    $data    = $client->getMetadataWithChildren("$path");
    #if the file has 'content' (directory) print out the information like normal
    if (array_key_exists('contents', $data) && ($data['is_dir'] == 1)) {
    	$return_dropfiles = array('type' => 'folder');
    	$return_dropfiles['content'] = [];
    	$return_dropfiles['service_id'] = $_POST['files'];
        $return_dropfiles['service'] = "1";
        foreach ($data['contents'] as $file) {
        	$temp = [];
            $path     = $file['path'];
        	//parsing out the filename from the path
	        $namefile = explode('/',$path);
	        $num = count($namefile) - 1;
	        $temp['name'] = $namefile[$num];
            $temp['size']     = $file['size'];
            $temp['kind']     = $file['icon'];
            $temp['path'] = $path;
            array_push($return_dropfiles['content'], $temp);
        }
        print(json_encode($return_dropfiles));
    }
    else
    {
        $link = array('type' => 'file');
        $link['service'] = '1';
        $link['link'] = $client->createTemporaryDirectLink($data['path']);
        print(json_encode($link));
    }
?>