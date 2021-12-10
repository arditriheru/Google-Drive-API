<?php
    function auth()
    {
        // required
        include 'apiclient/vendor/autoload.php';
    
        $credentials = 'oauth-credentials.json';
        $token_path = 'refresh-token.json';

        // get token
        if (file_exists($token_path)) {
            $refresh_token = json_decode(file_get_contents($token_path), true);
        } else {
            die ('refresh token not found');
        }

        // make new object
        $client = new Google\Client();

        // set credentials
        $client->setAuthConfig($credentials);

        // make client can access data from your google
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        // set refresh token
        $client->refreshToken($refresh_token);

        return $client;
    }
?>