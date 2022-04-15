<?php

include ('config.php');
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Facebook;
use Facebook\FacebookRequest;



    if(isset($accessToken)){

        if(isset($_SESSION['facebook_access_token'])){
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

        } else{
            $_SESSION['facebook_access_token'] = (string)$accessToken;
            $oAuth2Client = $fb->getOAuth2Client();
            $longLiveAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
            $_SESSION['facebook_access_token'] = (string)$longLiveAccessToken;
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }

    if(isset($_GET['code'])){
        header('Location: ./');
    }

    try{
        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
        $fbUserProfile = $profileRequest->getGraphNode()->asArray();
    }catch(FacebookResponseException $e){

    }

    $fbUserData = [
        'oauth_provider' => 'facebbok',
        'oauth_uid' => $$fbUserProfile['id'],
        'first_name' => $fbUserProfile['first_name'],
        'last_name' => $fbUserProfile['last_name']
    ];

    $userData = $fbUserData;

    $_SESSION['userData'] = $fbUserData;

    $logoutUrl = $helper->getLogoutUrl($accessToken, $redirectUrl.'logout.php');


    if(!empty($userData)){
        $output = '';
        $output.= "Nome: $userData[first_name]";
        $output.= "Sobrenome: $userData[last_name]";
        $output.= '<br /><a href="'.$logoutUrl.'">logout</a>';
    } else{
        $output = '<h1 style="color:red;">Ocorreu um erro!</h1>';
    }

    }else{
        $loginUrl = $helper->getAccessToken($redirectUrl,$fbPermission);
        $output = '<a href="'.$loginUrl.'">Fazer login com facebook PHP</a>';
    }

    echo $output;

?>