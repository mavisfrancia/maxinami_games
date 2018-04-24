<?php 
session_start();
require_once 'userService.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	require_once 'purchaseService.php';
    $purchaseService = new purchaseService();

	var_dump($_POST);

	// Check out as user
	if (isset($_SESSION['user_name'])) {
		$result = $purchaseService->userPurchase($_SESSION['user_id']);
		if ($result) {
			unset($_SESSION['cart']);
		}
	}

	// Create new account, then check out as guest
	else if(isset($_POST['create-check'])) {
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
            $phone = '';
            if (isset($_POST['phone']))
            	$phone = $_POST['phone'];


            //Encrypt password
            $userpass = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $add = new userService();

            $id = $add->addUser($username,$fullname,$address,$userpass,$phone,1);

            if($id != -1)
            {
                 session_regenerate_id();
                $_SESSION['user_name'] = $username;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['phone'] = $phone;
                $_SESSION['user_status'] = 1;
                $_SESSION['address'] = $address;
                $_SESSION['user_id'] = $id;

                session_write_close();

                $result = $purchaseService->userPurchase($_SESSION['user_id']);
	            if ($result) {
					unset($_SESSION['cart']);
				}
            }
            else
            {
                header('Location: account_create.php');
                exit();
            }

            
		}
	}

	// Checkout as guest
	else {
		$result = $purchaseService->anonymousPurchase($_SESSION['cart']);
		if ($result) {
			unset($_SESSION['cart']);
		}
	}
		
} else {
	header('Location: index.php');
}

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}



?>