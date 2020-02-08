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
$f3->set('genders', array('male','female'));
$f3->set('seekingArr', array('Female', 'Male'));
$f3->set('states', array('WA','OR','CA'));
$f3->set('indoors', array('Eating', 'Napping', 'Scratching the couch', 'Playing with yarn',
    'Crying', 'Stepping on owner\'s face', 'Loud Meowing', 'Sunbathing'));
$f3->set('outdoors', array('Scratching Tree', 'Sprinting around', 'Playing with Dog', 'Rolling in grass',
    'Car rides', 'Football', 'Chasing butterflies', 'Partying'));


//define a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /personal-info', function($f3){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Get data from form
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];

        //add data to hive
        $f3->set('firstname', $firstname);
        $f3->set('lastname', $lastname);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('phone', $phone);

        //If data is valid
        if (validPersonalInfo()) {
            //Write data to Session
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['age'] = $age;
            $_SESSION['gender'] = $gender;
            $_SESSION['phone'] = $phone;
            //Redirect to Summary
            $f3->reroute('/profile');
        }
    }
        //Display personal info form
        $view = new Template();
        echo $view->render('views/personal-info.html');
});

$f3->route('GET|POST /profile', function($f3){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

        if (validProfile()) {
            //Write data to Session
            $_SESSION['email'] = $email;
            $_SESSION['state'] = $state;
            $_SESSION['seeking'] = $seeking;
            $_SESSION['biography'] = $biography;
            //Redirect to Summary
            $f3->reroute('/interests');
        }}

    //Display profile form
    $view = new Template();
    echo $view->render('views/profile.html');
});

$f3->route('GET|POST /interests', function($f3) {
    $selectedIndoors = array();
    $selectedOutdoors = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['indoors']))
                foreach ($_POST['indoors'] as $indoorVal) {
                    array_push($selectedIndoors, $indoorVal);
                }

            if (!empty($_POST['outdoors']))
                foreach ($_POST['outdoors'] as $outdoorVal) {
                    array_push($selectedOutdoors, $outdoorVal);
                }

            $f3->set('selectedIndoors', $selectedIndoors);
            $f3->set('selectedOutdoors', $selectedOutdoors);

        if (validInterests()) {
            if (empty($selectedIndoors)) {
                $_SESSION['indoors'] = "No indoor interests selected.";
            }
            else {
                $_SESSION['indoors'] = implode(", ", $selectedIndoors);
            }
            if(empty($selectedOutdoors)) {
                $_SESSION['outdoors'] = "No outdoor interests selected.";
            }
            else {
                $_SESSION['outdoors'] = implode(", ", $selectedOutdoors);
            }
            $f3->reroute('/summary');
        }
    }
        $view = new Template();
        echo $view->render('views/interests.html');

});
$f3->route('GET|POST /summary', function() {
    $view = new Template();
    echo $view->render('views/summary.html');
    session_destroy();
});
//run fat free
$f3->run();