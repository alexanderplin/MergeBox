<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Auth;
class apiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function getAccounts()
    {
        // minimise information sent to client-side
        $thing = Session::get('service_accounts');
        $json = array();
        foreach($thing as $bare)
        {
            $sub['index'] = $bare['index'];
            $sub['service_name'] = $bare['service_name'];
            $sub['capacity'] = $bare['capacity'];
            $sub['service_email'] = $bare['service_email'];
            $json[$bare['index']] = $sub;
        }
        return json_encode($thing);
    }
    public function updateAccounts(){
        $index = 0;
        $accounts = DB::table('service_accounts')
            //->select('service_accounts')
            ->where('user_id', '=', Auth::id())
            ->join('services', 'services.id', '=', 'service_accounts.service')
            ->get();
        $accountsJSON=array();
        foreach ($accounts as $account){
            $push['index'] = $index;
            $push['service_name'] = $account->service_name;
            $push['service'] = $account->service;
            $push['service_email'] = $account->service_email;
            $push['service_id'] = $account->service_id;
            $push['service_accessToken'] = $account->service_accessToken;
            $push['capacity'] = 'TODO';
            // don't need this wtf im retarded
            // $key = $account->service . ":" . $account->service_id;
            $accountsJSON[$index] = $push;
            $index++;
        }
        Session::put('service_accounts', $accountsJSON);
    }
    public function getFiles($index, $service, $service_accessToken, $path = "/")
    {
        switch ($service) {
            case 1:
                return (new DropboxController)->getFilesFromPath($index, $path, $service_accessToken);
                break;
            case 2:
                return (new GoogleDriveController)->test();
                break;
            default:
                return -1;
        }
    }
    public function getAccountFiles(Request $request)
    {
        $account_info = Session::get('service_accounts');
        $indexarray = $request->all();
        $test_array= array();
        foreach ($indexarray as $index)
        {
            $current = $account_info[$index];
            array_push($test_array, $this->getFiles($current['index'], $current['service'], $current['service_accessToken']));
        }
        return $test_array;
    }
}
