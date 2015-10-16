<?php

require('../vendor/autoload.php');

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twitter\Api;


$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers
$app->get('/', function() use($app) {
    $api = new Api();
    $tweets = $api->getLatestTweets( getenv('TWITTER_SCREENNAME'), 10);
	$twigVars = array( 'screenname' =>  getenv('TWITTER_SCREENNAME'), 'tweets' => $tweets );
	
	return $app['twig']->render('index.twig', $twigVars);
});


/*
$app->get('/', function() use($app) {
  //$app['monolog']->addDebug('logging output.');
  return str_repeat('Hello', getenv('TIMES'));
});
*/

$app->get('/list', function() use($app) {
    //$tweets = array( array('title' => 'hello world', 'body' => 'This is #helloworld!') );

    try {
        $api = new Api();
        $tweets = $api->getLatestTweets( getenv('TWITTER_SCREENNAME'), 10);
    } catch (\Exception $e) {
        $tweets = array( 'error' => $e->getMessage() );
    }

    return new JsonResponse($tweets);

});

$app->run();
