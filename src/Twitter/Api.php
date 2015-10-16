<?php

namespace Twitter;
use GuzzleHttp\Client;

class Api
{

    protected $oAuthTokenUrl;

    protected $token;
    protected $httpClient;

    public function __construct(){
        $this->init();
    }

    protected function init(){
        $this->apiUrlBase = 'https://api.twitter.com';
        $this->oAuthTokenPath = '/oauth2/token';
        $this->timelinePath = '/1.1/statuses/user_timeline.json';

        $this->httpClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->apiUrlBase,

        ]);
        $this->token = $this->getToken();
    }

    /**
     * Make an API request to Twitter's end-point
     * @param $httpMethod - GET / POST
     * @param $path /path/to/method
     * @param $requestParams array('key' => 'value')
     * @return string
     */
    protected function makeHttpRequest($httpMethod, $path, $requestParams ){
        $response = $this->httpClient->request($httpMethod, $path, $requestParams);
        $responseBodyJson = $response->getBody();
        $responseBody = json_decode($responseBodyJson, true);
        return $responseBody;
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

        $requestParams = [ 'auth' => [ $consumerKey , $consumerSecret ],
                           'form_params' => [ 'grant_type' => 'client_credentials' ] ];

        $responseBody = $this->makeHttpRequest('POST', $this->oAuthTokenPath, $requestParams);
        return $responseBody['access_token'];
    }

    /**
     * Get the latest x tweets for a user
     * @see https://dev.twitter.com/rest/public/timelines
     * @see https://dev.twitter.com/rest/reference/get/statuses/user_timeline
     * @param $username
     */
    public function getLatestTweets($username, $numTweets){
        //$apiUrl = $this->apiUrlBase . $this->timelinePath;

    }

    public function search(){
        return array( array('token' => $this->token, 'title' => 'hello world 2', 'body' => 'This is #helloworld 2!') );
    }

}