<?php
require_once("config-dating.php");

/**
 * Class Database
 */

/**
 *
     Class DatabaseCREATE TABLE member  (
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
    SELECT member_id
    FROM member;

    SELECT interest_id
    FROM interests;
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
                VALUES(:sid, :last, :first, :birthdate, :gpa, :advisor)";
        //2. prepare the statement (passing the sql statement to database)
        $statement = $this->_dbh->prepare($sql);

        //3. bind the parameters
        $statement->bindParam(':fname', $member->getSid());
        $statement->bindParam(':lname', $member->getFirst());
        $statement->bindParam(':age', $member->getLast());
        $statement->bindParam(':gender', $member->getBirthdate());
        $statement->bindParam(':phone', $member->getGpa());
        $statement->bindParam(':email', $member->getAdvisor());
        $statement->bindParam(':state', $member->getAdvisor());
        $statement->bindParam(':seeking', $member->getAdvisor());
        $statement->bindParam(':bio', $member->getBio());
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



//    function getStudents()
//    {
//        //1. define the query
//        $sql = "SELECT * FROM student
//                ORDER BY last, first";
//        //2. prepare the statement
//        $statement = $this->_dbh->prepare($sql);
//        //3. bind the parameters
//        //4. execute statement
//        $statement->execute();
//        //5. get the result
//        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
//        return $result;
//    }
//
//    /**
//     *
//     */
//    function getAdvisors()
//    {
//    //1. define the query
//    $sql = "SELECT * FROM advisor
//                ORDER BY  advisor_last, advisor_first ";
//    //2. prepare the statement
//    $statement = $this->_dbh->prepare($sql);
//    //3. bind the parameters
//    //4. execute statement
//    $statement->execute();
//    //5. get the result
//    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
//    return $result;
//}
//    function getDetails($sid)
//    {
//        //1. define the query
//        $sql = "SELECT * FROM student, advisor
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
//    }
//    function writeStudent($student){
////        var_dump($student);
//        //1. define the query
//        $sql = "INSERT INTO student(sid, last, first, birthdate, gpa, advisor)
//                VALUES(:sid, :last, :first, :birthdate, :gpa, :advisor)";
//        //2. prepare the statement (passing the sql statement to database)
//        $statement = $this->_dbh->prepare($sql);
//        //3. bind the parameters
//        $statement->bindParam(':sid', $student->getSid());
//        $statement->bindParam(':first', $student->getFirst());
//        $statement->bindParam(':last', $student->getLast());
//        $statement->bindParam(':birthdate', $student->getBirthdate());
//        $statement->bindParam(':gpa', $student->getGpa());
//        $statement->bindParam(':advisor', $student->getAdvisor());
//        //4. execute statement
//        $statement->execute();
//        //5. get the result
////        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
//
//        //get the primary key of the last inserted row (in this case it is sid)
////        $id = $this->_dbh->lastInsertId();
//    }
}