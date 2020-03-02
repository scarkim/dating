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