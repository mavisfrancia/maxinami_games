<?php

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
            

		
                
                

            $con = new mysqli($servername, $serverusername, $serverpassword, "maxinami_games");

            // Check connection
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            } 

            $username = mysqli_real_escape_string($con, $_SESSION['user_name']);

            $result = mysqli_query($con, "SELECT * FROM users WHERE username='$username';");


            
            if(mysqli_num_rows($result) > 0){
                
                
                //Fill in variables that are recorded in the database
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $username = $row['username'];
                    $fullname = $row['fullname'];
                    $phone = $row['phonenumber'];
                    $address = $row['address'];
                    $userpass = $row['hashedpass'];
                    $admin = $row['status'];
				
				
                }
                
                
                
                
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
                $_SESSION['user_name'] = $username;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['phone'] = $phone;
                $_SESSION['admin'] = $admin;
                $_SESSION['address'] = $address;

                //Update new data into user's database
                $update = "UPDATE users SET fullname = '$fullname', address = '$address', hashedpass = '$userpass', "
                        . "phonenumber = '$phone', status = '$admin' WHERE username = '$username'";

                if (!mysqli_query($con,$update))
                {
                die('Error: ' . mysqli_error($con));
                }

                session_write_close();
                header('Location: index.php');
            
            exit();	
            }
            else{

                
			
		}
	}
}

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>