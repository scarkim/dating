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
INSERT INTO `interests` (`interest_id`, `interest`, `type`) VALUES
(DEFAULT, 'Eating', 'indoor'),
(DEFAULT, 'Napping', 'indoor'),
(DEFAULT, 'Card games', 'indoor'),
(DEFAULT, 'Cleaning', 'indoor'),
(DEFAULT, 'Crying', 'indoor'),
(DEFAULT, 'Cooking', 'indoor'),
(DEFAULT, 'Singing', 'indoor'),
(DEFAULT, 'Knitting', 'indoor'),
(DEFAULT, 'Running', 'outdoor'),
(DEFAULT, 'Shopping', 'outdoor'),
(DEFAULT, 'Playing with Dog', 'outdoor'),
(DEFAULT, 'Going to the beach', 'outdoor'),
(DEFAULT, 'Long drives', 'outdoor'),
(DEFAULT, 'Concerts', 'outdoor'),
(DEFAULT, 'Sports', 'outdoor'),
(DEFAULT, 'Partying', 'outdoor');

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
     * Calls connect() function
     */
    function __construct()
    {
        $this->connect();
    }

    /**
     * creates a new pdo connection and connects to database
     */
    function connect(){
        try {
            //CREATING A NEW PDO CONNECTION
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
//         echo "Connected!";
            //if there is an error, print error message
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * given $member param value, inserts into member table
     * @param $member
     * @return array
     */
    function insertMember($member){
        //1. define the query
        $sql = "INSERT INTO member(member_id, fname, lname, age, gender, phone, email, state, 
                seeking, bio, premium, image)
                VALUES(default, :fname, :lname , :age, :gender, :phone, :email, :state,
                :seeking, :bio, :premium, :image)";

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

        //4. execute statement
        $statement->execute();
        //5. get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * returns array of all members in member table
     * orders by last name, first name
     * @return array
     */
    function getMembers(){
        //1. define the query
        //GRAB ALL MEMBERS FROM MEMBER TABLE. SORT THEM BY LAST NAME AND THEN FIRST
        $sql = "SELECT * FROM  member
                ORDER BY lname, fname";
        //2. prepare the statement
        $statement = $this->_dbh->prepare($sql);
        //4. execute statement
        $statement->execute();
        //5. get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * returns the member given the specified member id
     * @param $member_id
     * @return array
     */
    function getMember($member_id){
        $sql = "SELECT * FROM member WHERE member_id = :member_id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(":member_id", $member_id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param $member_id
     */
    function getInterests($member_id){

    }
//    public function insertIndoorInterests($member) {
//        $indoorInterests = $member->getIndoors();
//                $sql = "INSERT INTO interests (interest_id, interest, type)
//                 VALUES (default, :interest, :type)";
//                $statement = $this->_dbh->prepare($sql);
//                $statement->bindParam(":interest", $indoorInterests);
//                $intType = "Indoors";
//                $statement->bindParam(":type", $intType);
//                $statement->execute();
//                $result = $statement->fetch(PDO::FETCH_ASSOC);
//                $interestID = $result['interestID'];
//            }
//    public function insertOutdoorInterests($member) {
//        $outdoorInterests = $member->getOutdoors();
//                $sql = "INSERT INTO interests (interest_id, interest, type)
//                 VALUES (default, :interest, :type)";
//                $statement = $this->_dbh->prepare($sql);
//                $intType = "Outdoors";
//                $statement->bindParam(":type", $intType);
//                $statement->bindParam(":interest", $outdoorInterests);
//                $statement->execute();
//                $result = $statement->fetch(PDO::FETCH_ASSOC);
//                $interestID = $result['interestID'];
//    }

}