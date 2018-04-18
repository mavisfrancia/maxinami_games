<?php

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$ERR="";
	
	$servername = 'localhost';
	$serverusername = 'root';
	$serverpassword = '';
	
	
	
	if(empty($_POST["username"])){
		$ERR = "Username is Required";
	}
	else{
		$username = test_input($_POST["username"]);
	}
        
        if(empty($_POST["name"])){
		$ERR = "Name is Required";
	}
	else{
		$fullname = test_input($_POST["name"]);
	}
	
        if(empty($_POST["address"])){
		$ERR = "Address is Required";
	}
	else{
		$address = test_input($_POST["address"]);
	}
        
	if(empty($_POST["password"])){
		$ERR = "Password is Required";
	}
	else{
		$password = test_input($_POST["password"]);
	}
        
        if(empty($_POST["confirm"])){
		$ERR = "Confirm password is Required";
	}
	else{
		$confirm = test_input($_POST["confirm"]);
	}
        
        //Test if confirm password is the same as password
        if(strcmp($password, $confirm))
        {
            $ERR = "Password and Confirm Password are different!";
        }
	
        //If required fields are empty or passwords are different, return to account create
	if(!empty($ERR)){
		header('Location: account_create.php');
		exit();
	}
	else{
		
		$username = $_POST['username'];
		$password = $_POST['password'];
                $fullname = $_POST['name'];
                $address= $_POST['address'];
                $phone = $_POST['phone'];
                $admin = $_POST[0];
		
		$con = new mysqli($servername, $serverusername, $serverpassword, "maxinami_games");
                
                // Check connection
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                } 
                
		$username = mysqli_real_escape_string($con, $_POST['username']);
		$userpass = $_POST['password'];
		
		$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username';");
		
		
		//If username exist kick back to account create
		if(mysqli_num_rows($result) > 0){
		
                    
                header('Location: account_create.php');
                exit();	
		}
		else{
                    
                    //Encrypt password
                    $userpass = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    
                    session_regenerate_id();
                    $_SESSION['user_name'] = $username;
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['admin'] = $admin;
                    $_SESSION['address'] = $address;

                    //Insert new user into user database
                    $insert = "INSERT INTO users (username, fullname, address, hashedpass, phonenumber, status) VALUES " 
                            ." ('$username','$name' ,'$address','$userpass','$phone','$admin' )";
                    
                    if (!mysqli_query($con,$insert))
                    {
                    die('Error: ' . mysqli_error($con));
                    }

                    session_write_close();
                    header('Location: index.php');
			
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