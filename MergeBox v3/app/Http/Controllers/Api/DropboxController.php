<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dropbox as dbx;
use App\Api;
use Auth;

class DropboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getWebAuth()
    {
        session_start();
        $appInfo = dbx\AppInfo::loadFromJsonFile("../resources/assets/app-info.json");
        $clientIdentifier = "my-app/1.0";
        $redirectUri = "http://localhost/api/link/dropbox";
        $csrfTokenStore = new dbx\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
        return new dbx\WebAuth($appInfo, $clientIdentifier, $redirectUri, $csrfTokenStore, "en");
    }

    public function linkAccountPost()
    {
        #function will get a WebAuth object that will generate a url which the client authenticates the app.
        $authorizeUrl = $this->getWebAuth()->start();
        #redirects to dropbox authentication
        return $authorizeUrl;
    }
    public function linkAccountGet()
    {
        #finishes authentication with access code and user id
        list($accessToken, $userId) = $this->getWebAuth()->finish($_GET);
        #generates a client object which we can grab information with by calling getAccountInfo()
        $client = new dbx\Client($accessToken, "PHP");
        $accountInfo = $client->getAccountInfo();
        #input access information to mysql table.
        $table = Api::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'service' => 1,
                'service_email' => $accountInfo['email'],
                'service_id' => $userId,
            ],
            [
                'service_accessToken' => $accessToken
            ]
        );
        $table->save();
        $updatetable = new apiController();
        $updatetable->updateAccounts();
        return redirect('/');
    }
    public function getFilesFromPath($index, $path, $access_token)
    {
        $client  = new dbx\Client($access_token, "PHP");
        #get file information from current path;
        $data    = $client->getMetadataWithChildren("$path");
        #if the file has 'content' (directory) print out the information like normal
        if (array_key_exists('contents', $data) && ($data['is_dir'] == 1)) {
            $return_dropfiles = array('type' => 'folder');
            $return_dropfiles['content'] = [];
            $return_dropfiles['service'] = 1;
            $return_dropfiles['index'] = $index;
            foreach ($data['contents'] as $file) {
                $temp = [];
                $path = $file['path'];
                //parsing out the filename from the path
                $namefile = explode('/',$path);
                $num = count($namefile) - 1;
                $temp['name'] = $namefile[$num];
                $temp['size'] = $file['size'];
                $temp['kind'] = $file['icon'];
                $temp['path'] = $path;
                array_push($return_dropfiles['content'], $temp);
            }
            return $return_dropfiles;
        }
        else
        {
            $link = array('type' => 'file');
            $link['service'] = '1';
            $link['link'] = $client->createTemporaryDirectLink($data['path']);
            return $link;
        }
    }
    public function test(){
        return "Dropbox working!";
    }
}