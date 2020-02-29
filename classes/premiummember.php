<?php

/**
 * Class PremiumMember
 */
class PremiumMember Extends Member
{
    /**
     * @var inDoorInterests
     */
    private  $_inDoorInterests;
    private $_image;
    /**
     * @var outDoorInterests
     */
    private $_outDoorInterests;
    //Parameterized constructor
    /**
     * PremiumMember constructor.
     * @param $fname
     * @param $lname
     * @param $age
     * @param $gender
     * @param $phone
     */
    function __construct($fname, $lname, $age, $gender, $phone, $isPre)
    {
        parent::__construct($fname, $lname, $age, $gender, $phone, $isPre);
    }

    /**
     * @param $inDoorInterests
     */
    function setIndoorInterests($inDoorInterests){
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * @param $outDoorInterests
     */
    function setOutdoorInterests($outDoorInterests){
        $this->_outDoorInterests = $outDoorInterests;
    }

    /**
     * @return mixed
     */
    function getIndoors(){
        return $this->_inDoorInterests;
    }

    /**
     * @return mixed
     */
    function getOutdoors(){
        return $this->_outDoorInterests;
    }
    function setImage($image){
        $this->_image = $image;
    }
    function getImage(){
        return $this->_image;
    }
}