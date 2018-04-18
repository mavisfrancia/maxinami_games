<?php
require_once 'userService.php';

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$ERR="";
	
	$servername = 'localhost';
	$serverusername = 'root';
	$serverpassword = '';
	
	
	
	
        
        if(empty($_POST["name"])){
		
	}
	else{
		$username = test_input($_POST["name"]);
	}
        
        if(empty($_POST["phone"])){
		
	}
	else{
		$phone = test_input($_POST["phone"]);
	}
	
        if(empty($_POST["address"])){
		
	}
	else{
		$address = test_input($_POST["address"]);
	}
        
	if(empty($_POST["password"])){
		//Do nothing
	}
	else{
		$password = test_input($_POST["password"]);
	}
        
        if(empty($_POST["confirm"])){
		
	}
	else{
		$confirm = test_input($_POST["confirm"]);
	}
        
        //Test if confirm password is the same as password and the passsword is changed
        if(strcmp($password, $confirm) && !empty($_POST["password"]))
        {
            $ERR = "Password and Confirm Password are different!";
        }
	
        //If required fields are empty or passwords are different, return to account create
	if(!empty($ERR)){
		header('Location: account_create.php');
		exit();
	}
	else{
            
            $userService = new userService();
            
            //Store user info
            $id = $_SESSION['user_id'];
            //Abort if id is not found *This should not happen
            if($id == -1)
            {
                echo 'id not found';
            }
            
            $row = $userService->getInfo($id);
            
            
            
            $user_status = $row['status'];
            $fullname = $row['fullname'];
            $address = $row['address'];
            $phone = $row['phonenumber'];
            $password = $row['hashedpass'];
                
            //Change variables if there is a change
            if(!empty($_POST["name"]))
            {
                $fullname = $_POST['name'];
            }

            if(!empty($_POST["phone"]))
            {
                $phone = $_POST['phone'];
            }


            if(!empty($_POST["address"]))
            {
                $address= $_POST['address'];
            }

            if(!empty($_POST["password"]))
            {   
                $password = $_POST['password'];

                //Encrypt password
                $userpass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }



            session_regenerate_id();
            $_SESSION['user_status'] = $user_status;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['phone'] = $phone;
            $_SESSION['address'] = $address;
            




            session_write_close();
            header('Location: index.php');
            
           
	}
}

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>