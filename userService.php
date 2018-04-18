<?php
    require_once 'databaseConnector.php';
    require_once 'userDAO.php';
    

class userService {
    var $connector;
    var $userAccess;
    public function __construct() {
        $this->connector=new databaseConnector();
        $this->userAccess=new userDAO();
    }
    function addUser($email,$name,$address,$password,$phoneNum,$status){
        try{
            $con= $this->connector->getConnection();
            $result= $this->userAccess->selectByUsername($email, $con);
            if(mysqli_num_rows($result)>0){
                echo "An user with username ".$email." is already in the system";
                return -1;
            }
            else{
                return $this->userAccess->createUser($email, $name, $address, $password, $phoneNum, $status, $con);
            }
        }
        finally {
            mysqli_free_result($result);
            $con->close();
        }
    }
    function login($email,$password){
        try{
            $con= $this->connector->getConnection();
            $result= $this->userAccess->selectByUsername($email, $con);
            if(mysqli_num_rows($result)>0){
                while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)){
                     $hashedpassword=$row["hashedpass"];
                     $id=$row["user_id"];
                 }
                 if(!password_verify($password, $hashedpassword)){
                     return $id;
                 }
            }
            echo "Username-password combination is invalid";
            return -1;
            
        }
        finally {
            mysqli_free_result($result);
            $con->close();
        }
    }
    function getInfo($id){
        try{
            $con= $this->connector->getConnection();
            $result= $this->userAccess->selectByID($id, $con);
            if(mysqli_num_rows($result)>0){
                return mysqli_fetch_array($result,MYSQLI_ASSOC);
                
            }
            return ["status"=>1];
            
        }
        finally {
            mysqli_free_result($result);
            $con->close();
        }
    }
    function updateInfo($id,$email,$name,$address,$password,$phoneNum,$status){
        try{
            $con= $this->connector->getConnection();
            $con->begin_transaction();
            $result= $this->userAccess->updateUser($id, $email, $name, $address, $password, $phoneNum, $status, $con);
            if($result!=1){
                $con->rollback();
                echo "An error has occured while updating your info";
                return false;
            }
            else{
                $con->commit();
                echo "Your information has been updated";
                return true;
            }
            
        }
        finally {
            mysqli_free_result($result);
            $con->close();
        }
    }
    function createAnonymousUser(){
        try{
            $con= $this->connector->getConnection();
            
            return $this->userAccess->createUser("", "", "", null, "", 1, $con);
            
        }
        finally {
            $con->close();
        }
    }
    function deleteAnonymousUser($id){
        if($this->isAnonymous($id))
            try{
                $con= $this->connector->getConnection();
                $con->begin_transaction();
                $this->userAccess->deleteUser($id, $con);
                if($con->affected_rows>1){
                    $con->rollback();
                    return 0;
                }
                $con->commit();
                return $con->affected_rows;
                
                
            }
            finally {
                $con->close();
            }
        return 0;
    }
    function convertAnonymousToKnown($anonymousID,$userID){
        if(!$this->isAnonymous($userID)&&$this->isAnonymous($anonymousID)){
            //move all related items over
            $this->deleteAnonymousUser($anonymousID);
            return true;
        }
        return false;
        
    }
    function isAnonymous($id){
        try{
            $con= $this->connector->getConnection();
            $result=$this->userAccess->selectByID($id, $con);
            if(mysqli_num_rows($result)>0&& mysqli_fetch_array($result,MYSQLI_ASSOC)["hashedpass"]==null){
                return true;
            }
            return false;
        }
        finally {
            mysqli_free_result($result);
            $con->close();
        }
    }
}
