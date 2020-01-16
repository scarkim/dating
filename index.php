<!--
Scarlett Kim
1/10/20
Dating controller
-->
<?php
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
//run fat free
$f3->run();