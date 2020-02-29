<?php
require_once("config-dating.php");

/**
 * Class Database
 */

/**
 * Class Database
 *
    CREATE TABLE member  (
    member_id int NOT NULL AUTO_INCREMENT,
    fname varchar(255) NOT NULL,
    lname varchar(255) NOT NULL,
    age varchar(255) NOT NULL,
    gender varchar(255) NOT NULL,
    phone varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    state varchar(255) NOT NULL,
    seeking varchar(255),
    bio varchar(255),
    premium tinyint NOT NULL,
    image varchar(255),
    PRIMARY KEY (member_id)
    );

    CREATE TABLE interests (
    interest_id int NOT NULL AUTO_INCREMENT,
    interest varchar(255),
    type varchar(255),
    PRIMARY KEY (interest_id)
    );

    THIS IS WRONG
    CREATE TABLE member_interest (
    member_id int NOT NULL,
    interest_id int NOT NULL,
    FOREIGN KEY (member_id) REFERENCES member(member_id),
    FOREIGN KEY (interest_id) REFERENCES interest(interest_id)
    );

 */
class Database
{
    /**
     * @var PDO
     */
    private $_dbh;

    /**
     * Database constructor.
     */
    function __construct()
    {
        try {
         //CREATING A NEW PDO CONNECTION
         $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
//         echo "Connected!";
         //if there is an error, print error message
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function connect(){

    }

    function insertMember($member){
        //1. define the query
        $sql = "INSERT INTO member(member_id, fname, lname, age, gender, phone, email, state, 
                seeking, bio, premium, image)
                VALUES(default, :fname, :lname , :age, :gender, :phone, :email, :state,
                :seeking, :bio, :premium, :image)";
//        :premium,
        //2. prepare the statement (passing the sql statement to database)
        $statement = $this->_dbh->prepare($sql);
        //3. bind the parameters
        $statement->bindParam(':fname', $member->getFName());
        $statement->bindParam(':lname', $member->getLName());
        $statement->bindParam(':age', $member->getAge());
        $statement->bindParam(':gender', $member->getGender());
        $statement->bindParam(':phone', $member->getPhone());
        $statement->bindParam(':email', $member->getEmail());
        $statement->bindParam(':state', $member->getState());
        $statement->bindParam(':seeking', $member->getSeeking());
        $statement->bindParam(':bio', $member->getBio());
        $statement->bindParam(':premium', $member->isPremium());
        if($member instanceof PremiumMember) {
            if(isset($_SESSION['profileImage'])) {
                $statement->bindParam(':image', $member->getImage());
            }
            else {
                $statement->bindParam(':image', $member->getDefaultImage());
            }
        }
        else {
            $statement->bindParam(':image', $member->getDefaultImage());
        }

//        else {
//            $statement->bindParam(':premium', $member->setPremiumm());
//            $statement->bindParam(':image', $member->getImage());
//        }
        //4. execute statement
        $statement->execute();
        //5. get the result
//        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //get the primary key of the last inserted row (in this case it is sid)
//        $id = $this->_dbh->lastInsertId();
    }
    function getMembers(){
        //1. define the query
        //GRAB ALL MEMBERS FROM MEMBER TABLE. SORT THEM BY LAST NAME AND THEN FIRST
        $sql = "SELECT * FROM  member
                ORDER BY last, first";
        //2. prepare the statement
        $statement = $this->_dbh->prepare($sql);
        //3. bind the parameters
        //4. execute statement
        $statement->execute();
        //5. get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function getMember($member_id){

    }
    function getInterests($member_id){
        //1. define the query
//        $sql = "SELECT interest? FROM student, advisor
//                WHERE student.advisor = advisor.advisor_id
//                AND sid = :sid";
//        //2. prepare the statement
//        $statement = $this->_dbh->prepare($sql);
//        //3. bind the parameters
//        //name and value im putting into :sid
//        $statement->bindParam(':sid', $sid);
//        //4. execute statement
//        $statement->execute();
//        //5. get the result
//        $result = $statement->fetch(PDO::FETCH_ASSOC);
//        return $result;
    }
    public function insertInterests($member) {
        $sql = "SELECT member_id FROM  member";
        $statement = $this->_dbh->prepare($sql);
        $memb_id=0;
        $statement->bindParam(':indoor', $member->getIndoorInterests());
        $statement->bindParam(':outdoor', $member->getOutdoorInterests());
        $indoor=implode("','",$member->getIndoorInterests());
        $outdoor=implode("','",$member->getOutdoorInterests());
        if (!empty($indoorInterests)) {
            foreach ($indoorInterests AS $interest ) {
                $sql = "SELECT interestID FROM interest WHERE interest = '$interest'";
                $statement = $this->_cnxn->prepare($sql);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
            }
        }

        if (!empty($outdoorInterests)) {
            foreach ($outdoorInterests AS $interest ) {
                $sql = "SELECT interestID FROM interest WHERE interest = '$interest'";
                $statement = $this->_cnxn->prepare($sql);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
            }
        }
    }

    public function insertInterest($interest, $id) {

        $sql = "SELECT interestID FROM interest WHERE interest = '$interest'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $interestID = $result['interestID'];

        $sql2 = "INSERT INTO memberInterest (memberID, interestID) 
                 VALUES ('$id', '$interestID')";
        $statement2 = $this->_cnxn->prepare($sql2);
        $statement2->execute();
        $result2 = $statement2->fetch(PDO::FETCH_ASSOC);
    }
}