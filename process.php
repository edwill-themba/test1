<?php
/**
 * Programmer: ME Themba
 * The purpose of the file is to make sure that correct user details are stored on the database
 */

 // gets the connection file
 require_once 'secure/connection.php';

 // chects is submit button is checked
 if(isset($_POST['submit'])){
    // gets data from user inputs
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $idno = $_POST['idno'];
    $dob = $_POST['dob'];

    // checks if date of birth is valid
    $date_of_birth = isValidDate($dob);
   
    // make sure that user enters accurate data
    validateUserData($name,$surname,$idno,$date_of_birth);
    // checks if user exist
    $isUserFound = getUser($idno);
    if($isUserFound == true){
       echo 'the user you are trying to save exists';
       exit;
    }else{
        try{
         $connection = getConnection();
         $insert_query = "INSERT INTO users(name,surname,idno,date_of_birth) VALUES(?,?,?,?)";
         $statement = $connection->prepare($insert_query);
         $user = $statement->execute([$name,$surname,$idno,$dob]);
         echo 'data was saved successfully'.' '.$name;
        }catch(PDOException $ex){
           echo $ex->getMessage();
           exit;
        }
    }
    
 }

 
 /**
  * make sure that data entered by the user is valid if not, an error
  * messages displayed
  * @param $name, $surname,$idno,$date_of_birth
  */
 function validateUserData($name,$surname,$idno,$date_of_birth){
     // check if user inputs are not empty
     if(empty($name) || empty($surname) || empty($idno) || empty($date_of_birth)){
         echo 'please make sure that all fields on the form are filled';
         exit;
     }
     // check if name contain special charactes or numbers
     if((preg_match('/[\'^£$%&*()}{@#~?.:;""!`><>,|=_+¬-]/', $name)) || (preg_match('~[0-9]+~', $name))){
        echo 'the name must not contain special characters or numbers';
        exit;   
    }
     // check if name contain special charactes or numbers
     if((preg_match('/[\'^£$%&*()}{@#~?.:;""!`><>,|=_+¬-]/', $surname)) || (preg_match('~[0-9]+~', $surname))){
        echo 'the surname must not contain special characters or numbers';
        exit;   
    }
     // check if name is length is greater than one
     if(strlen($name) <= 1){
        echo 'the name must not be a single character';
        exit;   
     }
     // check if surname is length is greater than one
     if(strlen($surname) <= 1){
        echo 'the surname must not be a single character';
        exit;   
     }
     // check id number that is not equal 13
     if(strlen($idno) !== 13){
        echo 'the id number must be 13 numbers';
        exit;   
     }
     // check if idno contain special charactes or letters
     if((preg_match('/[\'^£$%&*()}{@#~?.:;""!`><>,|=_+¬-]/', $idno)) || (preg_match('~[a-zA-Z]+~', $idno)) ){
        echo 'the idno must not contain special characters or numbers';
        exit;   
     }
     // checks if date is is greater than 1900 and less than today
     $today_date =  Date('Y-m-d');
     $start_date = Date('1900-01-01');
     if(($date_of_birth < $start_date) || ($date_of_birth > $today_date)){
         echo 'the date of birth must be between 1900-01-01 and todays date';
         exit;
     }
     // checks if date of birth matches with id number
     $date_of_birth_year = substr($date_of_birth,2,2);
     $date_of_birth_month = substr($date_of_birth,5,2);
     $date_of_birth_day = substr($date_of_birth,8,2);

     $idno_year = substr($idno,0,2);
     $idno_month = substr($idno,2,2);
     $idno_day = substr($idno,4,2);
     // checks the date of birth day that  correspond with idno day
     if ($date_of_birth_year !== $idno_year){
         echo 'invalid year the year on the date of birth does not match the year on the id number';
         exit;
     }
     // checks the date of birth month that  correspond with idno month
    if ($date_of_birth_month !== $idno_month){
        echo 'invalid month the month on the date of birth does not match the month on the id number';
        exit;
    }
    // checks the date of birth day that  correspond with idno day
    if ($date_of_birth_day !== $idno_day){
        echo 'invalid day the day on the date of birth does not match the day on the id number';
        exit;
    }
    
 }

 /**
  * checks if the user exist on the data base
  * @param idno
  * @return boolean
  */
 function getUser($idno){
    $found = false;
    $connection = getConnection();
    try{
        $query = "SELECT * FROM users where idno = ?";
        $statement = $connection->prepare($query);
        $statement->execute([$idno]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
       if($user){
            $found = true;
        }else{
            $found = false;
        }

    }catch(PDOException $ex){
        echo $ex->getMessage();
        exit;
    }
    return $found;
 }

 /**
  * checks if date entered is valid
  */
 function isValidDate($date_of_birth){
    $date_of_birth_year = substr($date_of_birth,6,4);
    $date_of_birth_month = substr($date_of_birth,3,2);
    $date_of_birth_day = substr($date_of_birth,0,2);
    
    if(!checkdate($date_of_birth_month,$date_of_birth_day,$date_of_birth_year)){
       echo "The date you entered is invalid <br/>";
       exit;
    }
   return Date("$date_of_birth_year-$date_of_birth_month-$date_of_birth_day");
 }
  


