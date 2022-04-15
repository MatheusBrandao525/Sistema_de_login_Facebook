<?php

    session_start();

    include ('facebook-php-sdk/autoload.php');
    use Facebook\Facebook;
    use Facebook\Exceptions\FacebookResponseException;
    use Facebook\Exceptions\FacebookSDKException;

    $appId = '';
    $appSecret = '';
    $redirectUrl = 'http://localhost/Sistema_de_login_Facebook/';
    $fbPermission = array('email');

    $fb = new Facebook(array(
        'app_id' => $appId,
        'app_secret' => $appSecret,
        'default_graph_version' => 'v13.0'
    ));

    $helper = $fb->getRedirectLoginHelper();

    try{
        if(isset($_SESSION['facebook_access_token'])){
            $accessToken = $_SESSION['facebook_access_token'];       
        }else{
            $accessToken = $helper->getAccessToken();
        }
    }catch(FacebookResponseException $e){

    }

?>