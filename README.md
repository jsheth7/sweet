## Overview

sweet is a REST API to list &amp; search through tweets &amp; includes an accompanying client web application.
The web application connects to the REST API, and allows you to view a list of tweets, or search through them.

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
  You can get these by going to https://apps.twitter.com/ and creating an application.

    export OAUTH_CONSUMER_KEY=abcd
    export OAUTH_CONSUMER_SECRET=dfgh

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



