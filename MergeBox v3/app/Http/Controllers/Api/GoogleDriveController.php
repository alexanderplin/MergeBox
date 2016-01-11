<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Google_Client;
use Google_Service_Drive;
use App\Api;
use Auth;
class GoogleDriveController extends Controller
{
    protected $authInfo;

    public function __construct()
    {
        $this->middleware('auth');
        $client_id = '897620548575-vvoqcl312q1bh02mnp62uo9ae97ae9l6@developer.gserviceaccount.com';
        $client_secret = 'VsiFzxOiNnklKdmtTnmeKEem';
        $redirect_uri = 'http://localhost/api/link/google_drive';
        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setAccessType('offline');
        $client->setScopes('https://www.googleapis.com/auth/drive');
        $client->setAccessType('offline');
        $client->setApprovalPrompt("force");
        $service = new Google_Service_Drive($client);
        $array['client'] = $client;
        $array['service'] = $service;
        $this->authInfo = $array;
    }
    public function linkAccountPost()
    {
        $client  = $this->authInfo['client'];
        $authUrl = $client->createAuthUrl();
        return $authUrl;
    }
    public function linkAccountGet()
    {
        $client  = $this->authInfo['client'];
        $service = $this->authInfo['service'];
        $client->authenticate($_GET['code']);
        $token = $client->getAccessToken();
        $refresh = $client->getRefreshToken();
        $permissionId = $service->about->get()->getUser()->getpermissionId();
        $email = $service->about->get()->getUser()->getemailAddress();

        $table = Api::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'service' => 2,
                'service_email' => $email,
                'service_id' => $permissionId,
            ],
            [
                'service_accessToken' => $token
            ]
        );
        $table->save();
        $updatetable = new apiController();
        $updatetable->updateAccounts();
        return redirect('/');
    }
    public function test()
    {
        return "Google Drive working!";
    }
}
