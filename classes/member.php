<?php

class Member
{
    private $_id;
    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;
    private $_isPre;
    private $_defImage;

    //Parameterized constructor
    function __construct($fname, $lname, $age, $gender, $phone, $isPre)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
        $this->_isPre = $isPre;
    }
    function setID($id){
        $this->_id = $id;
    }
    function getID(){
        return $this->_id;
    }
    function getFName(){
        return $this->_fname;
    }
    function getLName(){
        return $this->_lname;
    }
    function getAge(){
        return $this->_age;
    }
    function getGender(){
        return $this->_gender;
    }
    function getPhone(){
        return $this->_phone;
    }
    function getEmail(){
        return $this->_email;
    }
    function getState(){
        return $this->_state;
    }
    function getSeeking(){
        return $this->_seeking;
    }
    function getBio(){
        return $this->_bio;
    }
    function setFName($fname){
         $this->_fname = $fname;
    }
    function setLName($lname){
         $this->_lname = $lname;
    }
    function setAge($age){
         $this->_age = $age;
    }
    function setGender($gender){
        $this->_gender = $gender;
    }
    function setPhone($phone){
         $this->_phone = $phone;
    }
    function setEmail($email){
         $this->_email = $email;
    }
    function setState($state){
       $this->_state  = $state;
    }
    function setSeeking($seeking){
         $this->_seeking = $seeking;
    }
    function setDefaultImage($image){
        $this->_defImage = $image;
    }
    function getDefaultImage(){
        return $this->_defImage;
    }

    function setBio($bio){
         $this->_bio = $bio;
    }
    function isPremium()
    {
        return $this->_isPre;
    }
}