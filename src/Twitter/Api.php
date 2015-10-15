<?php

namespace Twitter;
use GuzzleHttp\Client;

class Api
{

    protected $oAuthTokenUrl;

    public function __construct(){

        $this->oAuthTokenUrl = 'https://api.twitter.com/oauth2/token';

    }

    /**
     * Retrieve an OAuth 2 Bearer Token using consumer & secret keys. The token can then be used to make API requests.
     * @return mixed
     */
    protected function getToken(){
        $consumerKey = getenv('OAUTH_CONSUMER_KEY');
        $consumerSecret = getenv('OAUTH_CONSUMER_SECRET');

        if( empty($consumerKey) || empty($consumerSecret) ){
            throw new \Exception('Please make sure consumer key and secret are set');
        }

        $client = new Client([
    	// Base URI is used with relative requests
    	'base_uri' => 'https://api.twitter.com',
   
		]);

        $requestParams = [ 'auth' => [ $consumerKey , $consumerSecret ],
                           'form_params' => [ 'grant_type' => 'client_credentials' ] ];

        $response = $client->request('POST', '/oauth2/token', $requestParams);
        $responseBodyJson = $response->getBody();
        $responseBody = json_decode($responseBodyJson, true);


        return $responseBody['access_token'];
    }

    public function search(){

        $token = $this->getToken();

        return array( array('token' => $token, 'title' => 'hello world 2', 'body' => 'This is #helloworld 2!') );
    }

}