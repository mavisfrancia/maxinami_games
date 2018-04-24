<?php 
session_start();
require_once 'userService.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	require_once 'purchaseService.php';
    $purchaseService = new purchaseService();

	// Check out as user
	if (isset($_SESSION['user_name'])) {
		$result = $purchaseService->userPurchase($_SESSION['user_id']);
		if ($result) {
			unset($_SESSION['cart']);
			session_write_close();
			header('Location: confirmation.php');
		} else {
			die("Something went wrong");
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

                load_cart();
                
                $result = $purchaseService->userPurchase($_SESSION['user_id']);
	            if ($result) {
					unset($_SESSION['cart']);
					header('Location: confirmation.php');
				} else {
					die("Something went wrong");
				}
				session_write_close();
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
			session_write_close();
			header('Location: confirmation.php');
		} else {
			die("Something went wrong");
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

function load_cart() {
	// Load cart from database
	require_once 'cartService.php';
	$cartService = new cartService();

	if (!isset($_SESSION['cart'])) { // create cart if not created yet
		$_SESSION['cart'] = [];
	}

	$cartService->moveCartToUser($_SESSION['user_id'],$_SESSION['cart']);

	$result = $cartService->getCart($_SESSION['user_id']);

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$itemid = $row['product_id'];
		$quantity = $row['quantity'];
		$_SESSION['cart'][$itemid] = $quantity;
	}
}



?>