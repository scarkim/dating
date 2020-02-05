<?php
//session start
session_start();
//this is our controller
//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
//require autoload file
require_once('vendor/autoload.php');
require_once('model/validate.php');
//create instance of the base class
$f3 = Base::instance();
//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define arrays
$f3->set('indoors', array('Eating', 'Napping', 'Scratching the couch', 'Playing with yarn',
    'Crying', 'Stepping on owner\'s face', 'Loud Meowing', 'Sunbathing'));

$f3->set('outdoors', array('Scratching Tree', 'Sprinting around', 'Playing with Dog', 'Rolling in grass',
    'Car rides', 'Football', 'Chasing butterflies', 'Partying'));


//define a default route
$f3->route('GET /', function(){
    $view = new Template();
    echo $view->render('views/home.html');
});
$f3->route('GET|POST /personal-info', function($f3){
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Get data from form
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $age  = $_POST['age'];
        $gender  = $_POST['gender'];
        $phone= $_POST['phone'];

        //add data to hive
        $f3->set('firstname', $firstname);
        $f3->set('lastname', $lastname);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('phone', $phone);
        //If data is valid
//        if (validForm()) {
            //Write data to Session
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['age'] = $age;
            $_SESSION['gender'] = $gender;
            $_SESSION['phone'] = $phone;

            //Redirect to Summary
            $f3->reroute('views/personal-info.html');
//        }
    }
        //Display personal info form
        $view = new Template();
        echo $view->render('views/personal-info.html');
});
$f3->route('GET|POST /profile', function($f3){
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Get data from form
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $biography = $_POST['biography'];

        //add data to hive
        $f3->set('email', $email);
        $f3->set('state', $state);
        $f3->set('seeking', $seeking);
        $f3->set('biography', $biography);
//        if (validForm()) {
            //Write data to Session
            $_SESSION['email'] = $email;
            $_SESSION['state'] = $state;
            $_SESSION['seeking'] = $seeking;
            $_SESSION['biography'] = $biography;

            //Redirect to Summary
            $f3->reroute('views/personal-info.html');
//        }
    }
    //Display profile form
    $view = new Template();
    echo $view->render('views/profile.html');
});
$f3->route('GET|POST  /interests', function($f3){


    $selectedIndoors =array();
    if (!empty($_POST['indoors'])){
        $selectedIndoors = $_POST['indoors'];
    }
    $f3->set('selectedIndoors', $selectedIndoors);
    $_SESSION['indoors'] = $selectedIndoors;


    $selectedOutdoors =array();
    if (!empty($_POST['outdoors'])){
        $selectedOutdoors = $_POST['outdoors'];
    }
    $f3->set('selectedOutdoors', $selectedOutdoors);
    $_SESSION['outdoors'] = $selectedOutdoors;


    $view = new Template();
    echo $view->render('views/interests.html');
});
$f3->route('POST /summary', function($f3) {
//    $_SESSION['interests'] = $_POST['interests'];

    $view = new Template();
    echo $view->render('views/summary.html');
    session_destroy ();
});
//run fat free
$f3->run();