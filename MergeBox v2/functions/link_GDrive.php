<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once realpath(dirname(__FILE__) . '/../lib/google-api-php-client-master/autoload.php');
/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/fileupload.php
 ************************************************/
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
$client->setApprovalPrompt("force");
$service = new Google_Service_Drive($client);


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['code']))
{
  $client->authenticate($_GET['code']);
  $token = $client->getAccessToken();
  $refresh = $client->getRefreshToken();
  $permissionId = $service->about->get()->getUser()->getpermissionId();
  $email = $service->about->get()->getUser()->getemailAddress();

    query("INSERT INTO service_accounts(user_id, service_name, service_email, service_id, service_accessToken) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE service_accessToken = ?", $_SESSION["id"], "3", $email, $permissionId, serialize($token), serialize($token));

  redirect("link.php?link=success&service=GDrive");
}
else
{
  $authUrl = $client->createAuthUrl();
  redirect("$authUrl");
}

?>
