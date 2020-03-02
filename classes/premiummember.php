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
    /**
     * @var
     */
    private $_image;
    /**
     * @var outDoorInterests
     */
    private $_outDoorInterests;

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
     * returns outdoor interests
     * @return mixed
     */
    function getOutdoors(){
        return $this->_outDoorInterests;
    }

    /**
     * sets the member's image
     * @param $image
     */
    function setImage($image){
        $this->_image = $image;
    }

    /**
     * returns the member's image uploaded or default picture
     * @return mixed
     */
    function getImage(){
        return $this->_image;
    }
}