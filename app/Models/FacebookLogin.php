<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookLogin extends Model {

    public function facebookLogin() {
        $fb = new \Facebook\Facebook([
            'app_id' => '425719181652515',
            'app_secret' => 'bcb58a9e5fcc421a9fbdacdc79df4b8f',
            'default_graph_version' => 'v2.10',
                //'default_access_token' => '{access-token}', // optional
        ]);
print_R($fb);exit;
// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();

        try {
// Get the \Facebook\GraphNodes\GraphUser object for the current user.
// If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me', '{access-token}');
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
// When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
// When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $me = $response->getGraphUser();
        echo 'Logged in as ' . $me->getName();
    }

}
