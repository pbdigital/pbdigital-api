<?php
/*
Plugin Name: PB Digital - Mobile App API
Plugin URI: https://pbdigital.com.au
Description: Handles API Stuff In Wordpress For Mobile App
Version: 1.00
Author: PB Digital
Author URI: https://pbdigital.com.au
*/

#error_reporting(E_ALL);
#ini_set('display_errors',1);
//require_once("FFG.php");
require_once('PBDigital.php');
require_once('class-user.php');
require_once('class-dashboard.php');


/*******
Users
*******/

#POST		/users/login
add_action( 'rest_api_init', function () {
  register_rest_route( 'pbd', '/users/login', array(
    'methods' => 'POST',
    'callback' => ['PBDigital\Users','login'],
  ) );
} );

#GET 		/users/:id
add_action( 'rest_api_init', function () {
  register_rest_route( 'pbd', '/users/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => ['PBDigital\Users','get_user'],
  ) );
} );

/*******
Dashboard
*******/

#GET 		/dashboard/:id
add_action( 'rest_api_init', function () {
  register_rest_route( 'pbd', '/dashboard', array(
    'methods' => 'GET',
    'callback' => ['PBDigital\Dashboard','get_data'],
  ) );
} );