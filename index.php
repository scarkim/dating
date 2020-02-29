<?php
//this is our controller
//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
//require autoload file
require_once('vendor/autoload.php');
require_once('model/validate.php');
//session start
session_start();
//create instance of the base class
$f3 = Base::instance();
//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define arrays
$f3->set('genders', array('Male','Female'));
$f3->set('seekingArr', array('Female', 'Male'));
$f3->set('states', array('WA','OR','CA'));
$f3->set('indoors', array('Eating', 'Napping', 'Card games', 'Cleaning',
    'Crying', 'Cooking', 'Singing', 'Knitting'));
$f3->set('outdoors', array('Running', 'Shopping', 'Playing with Dog', 'Going to the beach',
    'Long drives', 'Concerts', 'Sports', 'Partying'));
$db = new Database();
$controller = new DatingController($f3);
//define a default route
$f3->route('GET /', function () {
    global $controller;
    $controller->home();
});

$f3->route('GET|POST /personal-info', function($f3){
    global $controller;
    $controller->personalInfo();
});

$f3->route('GET|POST /profile', function($f3){
    global $controller;
    $controller->profile();
});

$f3->route('GET|POST /interests', function($f3) {
    global $controller;
    $controller->interests();

});
$f3->route("GET|POST /profilePic", function () {
    global $controller;
    $controller->profilePic();
});
$f3->route('GET|POST /summary', function() {
    global $controller;
    $controller->summary();
});
//run fat free
$f3->run();