<?php
/**
 * Created by PhpStorm.
 * User: scarlett
 * Date: 1/29/2020
 * Time: 11:31 AM
 */

/**
   Return a value indicating if the param is a valid food
   Valid foods are not empty and do not contain numbers
   @param String $food
   @return boolean
*/
class Validate
{
//    function validPersonalInfo($firstname, $lastname, $age, $gender, $phone)
//    {
//        global $f3;
//        $isValid = true;//flag
//
//        if (!validFirstName($firstname)) {
//            $isValid = false;
//            $f3->set("errors['firstname']", "Please enter first name");
//        }
//
//        if (!validLastName($lastname)) {
//            $isValid = false;
//            $f3->set("errors['lastname']", "Please enter last name");
//        }
//
//        if (!validAge($age)) { //get the value of the passed key age is key
//            $isValid = false;
//            $f3->set("errors['age']", "Please enter valid age between 18 to 118 ");
//        }
//
//        if (!validPhone($phone)) {
//            $isValid = false;
//            $f3->set("errors['phone']", "Please enter valid 10 digit phone number ");
//        }
//
//        if (!validGender($gender)) {
//            $isValid = false;
//            $f3->set("errors['gender']", "Please select a gender ");
//        }
//        return $isValid;
//    }

//    function validProfile()
//    {
//        global $f3;
//        $valid = true;//flag
//        if (!validEmail($f3->get('email'))) {
//            $valid = false;
//            $f3->set("errors['email']", "Please enter valid email address ");
//        }
//        if (!validSeeking($f3->get('seeking'))) {
//            $valid = false;
//            $f3->set("errors['seeking']", "Please select an option");
//        }
//        return $valid;
//    }
//
//    function validInterests()
//    {
//        global $f3;
//        $validInterest = true;
//        if (!validIndoors($f3->get('indoors'))) {
//            $validInterest = false;
//            $f3->set("errors['indoor']", "NOTE: Please select all valid values
//for indoor interests!");
//        }
//        if (!validOutdoors($f3->get('outdoors'))) {
//            $validInterest = false;
//            $f3->set("errors['outdoor']", "NOTE: Please select all
//valid values for outdoor interests!");
//        }
//        return $validInterest;
//    }

    /**
     * @param $firstname
     * @return bool
     */
    function validFirstName($firstname)
    {
        return !empty($firstname) && ctype_alpha($firstname);
    }

    /**
     * @param $lastname
     * @return bool
     */
    function validLastName($lastname)
    {
        return !empty($lastname) && ctype_alpha($lastname);
    }

    /**
     * @param $age
     * @return bool
     */
    function validAge($age)
    {
        return (!empty($age) && ctype_digit($age) && ($age >= 18 && $age <= 118));
    }

    /**
     * @param $phone
     * @return bool
     */
    function validPhone($phone)
    {
        return (strlen($phone) == 10 && !empty($phone) && ctype_digit($phone));
    }

    /**
     * @param $gender
     * @return bool
     */
    function validGender($gender)
    {
        global $f3;

        if (isset($_POST["gender"]) AND in_array($gender, $f3->get('genders'))) {
            return true;
        } else if (!isset($_POST["gender"])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $seeking
     * @return bool
     */
    function validSeeking($seeking)
    {
        global $f3;
        if (isset($_POST['seeking']) AND in_array($seeking, $f3->get('seekingArr'))) {
            return true;
        } else if (!isset($_POST["seeking"])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $indoorArr
     * @return bool
     */
    function validIndoors($indoorArr)
    {
        global $f3;
        $validCheck = false;
        if (empty($indoorArr)) {
            $validCheck = true;
            return $validCheck;
        }
        foreach ($indoorArr as $item2) {
            if (in_array($item2, $f3->get('indoors'))) {
                $validCheck = true;
            } else {
                $validCheck = false;
                return $validCheck;
            }
        }
        return $validCheck;
    }

    /**
     * @param $outdoorArr
     * @return bool
     */
    function validOutdoors($outdoorArr)
    {
        global $f3;
        $validCheck = false;
        if (empty($outdoorArr)) {
            $validCheck = true;
            return $validCheck;
        }
        foreach ($outdoorArr as $item2) {
            if (in_array($item2, $f3->get('outdoors'))) {
                $validCheck = true;
            } else {
                $validCheck = false;
                return $validCheck;
            }
        }
        return $validCheck;
    }

    /**
     * @param $email
     * @return bool
     */
    function validEmail($email)
    {
        $emailResult = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
            $emailResult = true;
        }
        return $emailResult;
    }
}