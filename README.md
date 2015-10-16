## Project Overview

sweet is a REST API to list &amp; search through tweets &amp; includes an accompanying client web application.
The web application connects to the REST API, and allows you to view a list of tweets, or search through them.

Demo site: https://sweet-tweets.herokuapp.com/

## Design Overview

This project uses the Silex micro-framework, which is built on Symfony2 components. Silex uses a quasi-MVC design, which helps to build maintainable software.

It uses composer to load in Silex components, as well as the guzzle PHP library (to make HTTP requests).

The front controller is located at web/index.php. This script bootstraps Silex and provides two entry points:

* / - The main page showing a formatted list of tweets (HTML / CSS)
* /list - A REST API endpoint showing the same list of tweets in JSON format.

Each controller action is defined within web/index.php.

Templates (Views) are defined within web/views. Templates use the twig templating library, which is also used in Symfony 2.

It uses PSR-0 autoloading built into composer to load the Twitter API class (src/Twitter/Api.php).

The Api.php class implements retrieving an oauth 2 bearer token from Twitter using application-based authentication. It POSTs the access & secret key pair to Twitter and receives an oauth token in response.

The methods in Api.php are short, and documented using phpdoc syntax.
Note the use of public and protected methods.

It is designed to be a 12-factor app (see: http://12factor.net/).
Configuration values are set via environment variables, and this application can easily be deployed to Heroku, or another similar platform-as-a-service.

I only spent 5 hours on this project, so some things remain to be done. Please see the "TODO" section below.

The project currently provides useful functionality, and hopefully allows me to share my thoughts on the design and vision I have for it.

To see how the project evolved, please look through the commits. This will give you insight into how I thought through the problem, and adapted the code as I encountered new insights.

Please visit the demo site: https://sweet-tweets.herokuapp.com/

## TODO

* Load tweets on front page using jQuery (which will call the /list end-point)
* Auto-refresh the tweets every 1 minute
* Add a REST API end-point to search for tweets (/search)
* Provide client-side search functionality using jQuery, HTML & CSS
* Add phpunit tests for Api class

## Quickstart

## Requirements 

PHP 5.5 or higher

## Clone files

    mkdir ~/Sites
    cd ~/Sites
    git clone git@github.com:jsheth7/sweet.git
    cd ./sweet

### Install components

This will install the needed components and the Silex micro-framework.

    composer install

### Set configuration values

  You will need an oauth consumer key and secret.
  Also, choose a twitter screenname whose tweets will be shown.

  You can get these by going to https://apps.twitter.com/ and creating an application.

    export OAUTH_CONSUMER_KEY=abcd
    export OAUTH_CONSUMER_SECRET=dfgh
    export TWITTER_SCREENNAME=salesforce

### Run local web server

This will allow you to preview the application locally:

    php -S localhost:8080 -t web

Then go to http://localhost:8080/list

## Deploy to heroku

### Install heroku toolbelt

    https://toolbelt.heroku.com/

### Create heroku application

    cd ~/Sites/sweet
    heroku create

### Configure heroku application

Set the oauth key and secret (see "Set configuration values" section above).

    heroku config:set OAUTH_CONSUMER_KEY=abcd
    heroku config:set OAUTH_CONSUMER_SECRET=dfgh
    heroku config:set TWITTER_SCREENNAME=salesforce

### Deploy to heroku

    git push origin heroku




