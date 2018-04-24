<?php

/**
 * Description of userDAO
 *
 * @author Nathan
 */
class userDAO {
    private $createSQL="INSERT INTO users (username,fullname,address,hashedpass,phonenumber,status) VALUES (?,?,?,?,?,?)";
    private $selectByIdSQL="SELECT * FROM users WHERE user_id=?";
    private $selectByUsernameSQL="SELECT user_id, username, hashedpass FROM users WHERE username=?";
    private $updateSQL="UPDATE users SET username=?, fullname=?, address=?, hashedpass=?, phonenumber=?, status=? WHERE user_id=?";
    private $deleteSQL="DELETE FROM users WHERE user_id=?";
    function createUser($email,$name,$address,$password,$phoneNum,$status,$con) {
        $statement=mysqli_prepare($con, $this->createSQL);
        $statement->bind_param("sssssi", $email,$name,$address,$password,$phoneNum,$status);
        $statement->execute();
        $id=$statement->insert_id;
        $statement->close();
        return $id;
    }
    function selectByUsername($username,$con){
        $statement= mysqli_prepare($con, $this->selectByUsernameSQL);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        return $result;
        
    }
    function selectByID($id,$con){
        $statement= mysqli_prepare($con, $this->selectByIdSQL);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        return $result;
        
    }
    function deleteUser($id,$con){
        $statement= mysqli_prepare($con, $this->deleteSQL);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
        
    }
    
    function updateUser($id,$email,$name,$address,$password,$phoneNum,$status,$con) {
        $statement=mysqli_prepare($con, $this->updateSQL);
        $statement->bind_param("sssssii", $email,$name,$address,$password,$phoneNum,$status,$id);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
    }
}
