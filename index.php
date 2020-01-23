<?php
//session start
session_start();
//this is our controller
//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
//require autoload file
require_once('vendor/autoload.php');

//create instance of the base class
$f3 = Base::instance();

//define a default route
$f3->route('GET /', function(){
    $view = new Template();
    echo $view->render('views/home.html');
});
$f3->route('GET /personal-info', function(){
    $view = new Template();
    echo $view->render('views/personal-info.html');
});
$f3->route('POST /profile', function(){
    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['lastname'] = $_POST['lastname'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone'] = $_POST['phone'];
    $view = new Template();
    echo $view->render('views/profile.html');
});
$f3->route('POST /interests', function(){
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];
    $_SESSION['biography'] = $_POST['biography'];
    $view = new Template();
    echo $view->render('views/interests.html');
});
$f3->route('POST /summary', function(){
//    $_SESSION['interests'] = $_POST['interests'];
    if(!empty($_POST['interests'])) {
        foreach($_POST['interests'] as $checked) {
            $_SESSION['interests'] .= $checked . ', ';
        }
    }
    $view = new Template();
    echo $view->render('views/summary.html');
    session_destroy ();
});
//run fat free
$f3->run();