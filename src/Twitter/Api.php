<?php

namespace Twitter;
use GuzzleHttp\Client;

class Api
{

    protected $apiUrlBase;
    protected $oAuthTokenPath;
    protected $timelinePath;

    protected $token;
    protected $httpClient;

    public function __construct(){
        $this->init();
    }

    /**
     * Initialize vairables and HTTP client
     */
    protected function init(){
        $this->apiUrlBase = 'https://api.twitter.com';
        $this->oAuthTokenPath = '/oauth2/token';

        $this->timelinePath = '/1.1/statuses/user_timeline.json';

        $this->initHttpClient();
    }

    /**
     * Initialize the http client (guzzle) object,
     * and retrieve an oauth bearer token
     * @see https://dev.twitter.com/oauth/application-only
     */
    protected function initHttpClient(){
        //First get the token, given the access key pair:
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

        //If the token is set, make sure to send the token with every request
        if( isset($this->token) && !empty($this->token) ){
            $requestParams['headers'] = array(
                'Authorization' => "Bearer {$this->token}",
            );
        }

        //TODO - handle the token expiring / being invalid
        $response = $this->httpClient->request($httpMethod, $path, $requestParams);
        $responseBodyJson = $response->getBody();
        $responseBody = json_decode($responseBodyJson, true);
        return $responseBody;
    }

    /**
     * Retrieve an OAuth 2 Bearer Token using consumer & secret keys.
     * The token can then be used to make API requests.
     * @see https://dev.twitter.com/oauth/application-only
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

        $response = $this->makeHttpRequest('POST', $this->oAuthTokenPath, $requestParams);
        return $response['access_token'];
    }

    /**
     * Get the latest x tweets for a user
     * @see https://dev.twitter.com/rest/public/timelines
     * @see https://dev.twitter.com/rest/reference/get/statuses/user_timeline
     * @param $screenname Twitter screen name
     * @param $numTweets Number of tweets to return
     */
    public function getLatestTweets($screenname, $numTweets){
        //$apiUrl = $this->apiUrlBase . $this->timelinePath;

        $requestParams = [
            'query' => ['screen_name' => $screenname, 'count' => $numTweets]
        ];

        $response = $this->makeHttpRequest('GET', $this->timelinePath, $requestParams);
        return $response;

    }

    public function search(){
        return array( array('title' => 'hello world 2', 'body' => 'This is #helloworld 2!') );
    }

    /**
     * For my own debugging purposes. Use with care - may contain sensitive info.
     * @return array
     */
    public function debug(){
        return array('token' => $this->token);
    }

}