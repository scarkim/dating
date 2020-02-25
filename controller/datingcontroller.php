<?php
/**
 * Class DatingController
 * @author Scarlett Kim
 */
class DatingController
{
    /**
     * @var f3
     */
    private $_f3; //Router
    /**
     * @var Validate
     */
    private $_val; //Validation

    /**
     * DatingController constructor.
     * @param $f3
     */
    public function __construct($f3)
    {
        $this->_f3 = $f3;
        $this->_val = new Validate();
    }

    /**
     * displays initial home page
     */
    public function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * renders form1.html
     */
    public function personalInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get data from form
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $premium = $_POST['premium'];
            //add data to hive
            $this->_f3->set('firstname', $firstname);
            $this->_f3->set('lastname', $lastname);
            $this->_f3->set('age', $age);
            $this->_f3->set('gender', $gender);
            $this->_f3->set('phone', $phone);
            $this->_f3->set('premium', $premium);
//IF PREMIUM MEMBER ->SET TO NEW PREMIUM ELSE JUST MEMBER
            //If data is valid
            $valid=true;
            //check if first name valid
            if ($this->_val->validFirstName($firstname)) {
                $_SESSION["firstname"] = $_POST["firstname"];
            } else {
                $this->_f3->set("errors['firstname']", "Please enter first name");
                $valid=false;
            }

            //check if last name valid
            if ($this->_val->validLastName($_POST["lastname"])) {
                $_SESSION["lastname"] = $_POST["lastname"];
            } else {
                $this->_f3->set("errors['lastname']", "Please enter last name");
                $valid=false;
            }
            //check if age name valid
            if ($this->_val->validAge($_POST["age"])) {
                $_SESSION["age"] = $_POST["age"];
            } else {
                $this->_f3->set("errors['age']", "Please enter valid age between 18 to 118 ");
                $valid=false;
            }

            //check if phone name valid
            if ($this->_val->validPhone($_POST["phone"])) {
                $_SESSION["phone"] = $_POST["phone"];
            } else {
                $this->_f3->set("errors['phone']", "Please enter valid 10 digit phone number ");
                $valid=false;
            }
            //check if gender valid
            if ($this->_val->validGender($_POST["gender"])) {
                $_SESSION["gender"] = $_POST["gender"];
            } else {
                $this->_f3->set("errors['gender']", "Please select a gender ");
                $valid=false;
            }
            if ($valid) {
                if (isset($_POST['premium'])) {
                    if (!isset($gender)) {
                        $gender = "n/a";
                    }
                    //create new instance of member object w/ gender value being n/a
                    $member = new PremiumMember($firstname, $lastname, $age, $gender, $phone);
                    $_SESSION['member'] = $member;
                } //          keep in account optional field gender
                else {
                    if (!isset($gender)) {
                        //create new instance of member object w/ gender value being n/a
                        $gender = "n/a";
                    }

                    $member = new Member($firstname, $lastname, $age, $gender, $phone);
                    $_SESSION['member'] = $member;
                }
                //Redirect to profile
                $this->_f3->reroute('/profile');
            }
        }
        //Display personal info form
        $view = new Template();
        echo $view->render('views/personal-info.html');
    }

    /**
     * renders form2.html
     */
    public function profile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get data from form
            $email = $_POST['email'];
            $state = $_POST['state'];
            $seeking = $_POST['seeking'];
            $biography = $_POST['biography'];
            //add data to hive
            $this->_f3->set('email', $email);
            $this->_f3->set('state', $state);
            $this->_f3->set('seeking', $seeking);
            $this->_f3->set('biography', $biography);
            $isValid = true;
            if ($this->_val->validEmail($_POST['email'])) {
                $_SESSION["email"] = $_POST["email"];
            } else {
                $this->_f3->set("errors['email']", "Please enter valid email address ");
                $isValid = false;
            }

            if ($this->_val->validSeeking($_POST['seeking'])) {
                $_SESSION["seeking"] = $_POST["seeking"];
            } else {
                $this->_f3->set("errors['seeking']", "Please select an option");
                $isValid = false;
            }
            if ($isValid) {
                //Write data to Session
                $_SESSION['email'] = $email;
                $_SESSION['member']->setEmail($_SESSION['email']);
                $_SESSION['state'] = $state;
                $_SESSION['member']->setState($_SESSION['state']);
                $_SESSION['seeking'] = $seeking;
                $_SESSION['member']->setSeeking($_SESSION['seeking']);
                $_SESSION['biography'] = $biography;
                $_SESSION['member']->setBio($_SESSION['biography']);
                //Redirect to Summary
                if ($_SESSION['member'] instanceof PremiumMember) {
                    $this->_f3->reroute('/interests');
                }
                else {   //IF NOT A PREMIUM MEMBER, SKIP THE INTERESTS PAGE
                    $this->_f3->reroute('/summary');
                }
            }
        }
        //Display profile form
        $view = new Template();
        echo $view->render('views/profile.html');
    }

    /**
     * renders interests page IF user is premium
     */
    public function interests()
    {
        $selectedIndoors = array();
        $selectedOutdoors = array();
        $validInterest = true;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['indoors'])) {
                foreach ($_POST['indoors'] as $indoorVal) {
                    array_push($selectedIndoors, $indoorVal);
                }
            }
            if (!empty($_POST['outdoors'])) {
                foreach ($_POST['outdoors'] as $outdoorVal) {
                    array_push($selectedOutdoors, $outdoorVal);
                }
            }
            $this->_f3->set('selectedIndoors', $selectedIndoors);
            $this->_f3->set('selectedOutdoors', $selectedOutdoors);

                if ($this->_val->validIndoors($selectedIndoors)) {
                    if (empty($selectedIndoors)) {
                        $_SESSION['indoors'] = "No indoor interests selected.";
                    }
                    else {
                        $_SESSION['indoors'] = implode(", ", $selectedIndoors);
                        $_SESSION['member']->setIndoorInterests($_SESSION['indoors']);
                    }
                }
                else {
                    $this->_f3->set("errors['indoor']", "NOTE: Please select all valid values for indoor interests!");
                    $validInterest = false;
                }
            if ($this->_val->validOutdoors($selectedOutdoors)) {
                if (empty($selectedOutdoors)) {
                    $_SESSION['outdoors'] = "No outdoor interests selected.";
                } else {
                    $_SESSION['outdoors'] = implode(", ", $selectedOutdoors);
                    $_SESSION['member']->setOutdoorInterests($_SESSION['outdoors']);
                }
            }
            else {

                $this->_f3->set("errors['outdoor']", "NOTE: Please select all valid values for outdoor interests!");
                $validInterest = false;
            }
            if($validInterest) {
                $this->_f3->reroute('/profilePic');
            }
    }
            $view = new Template();
            echo $view->render('views/interests.html');

    }

    /**
     * render profile pic page IF user is premium
     */
    public function profilePic()
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,
            PATHINFO_EXTENSION));
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"]) AND !empty($_FILES["fileToUpload"]["tmp_name"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $this->_f3->set("errors['notImage']",
                        "File is not an image!");
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $this->_f3->set("errors['uploadType']",
                        "Sorry, only JPG, JPEG, & PNG files are allowed.");
                    $uploadOk = 0;
                }
                if ($uploadOk) {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $_SESSION["profileImage"] = $target_file;
                        $this->_f3->set("profileImage", $target_file);
                        $this->_f3->reroute('/summary');
                    } else {
                        $this->_f3->set("errors['uploadError']",
                            "Sorry, there was an error uploading your file.");
                    }
                }
            }
            else {
                $this->_f3->set("errors['fileError']", "No file.");
            }
        }
        $view = new Template();
        echo $view->render("views/profilePic.html");
    }


    /**
     * renders results.html
     */
    public function summary()
    {
        $view = new Template();
        echo $view->render('views/summary.html');
        session_destroy();
    }


}