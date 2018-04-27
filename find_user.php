<?php
require_once 'userService.php';

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
	
	if(empty($_POST["password"])){
		$ERR = "Password is Required";
	}
	else{
		$password = test_input($_POST["password"]);
	}
	
        //If fields are empty return to sign in
	if(!empty($ERR)){
            $_SESSION['errorMessage'] = "Username/password is empty.";
            header('Location: signIn.php');
            exit();
	}
	else{
		
		$username = $_POST['username'];
            $password = $_POST['password'];

            $login = new userService();

            $id = $login->login($username,$password);

            //If user is found in database
            if($id != -1){
                
                $row = $login->getInfo($id);
                
                $user_status = $row['status'];
                $fullname = $row['fullname'];
                $address = $row['address'];
                $phone = $row['phonenumber'];
                
                
                session_regenerate_id();
                $_SESSION['user_id'] = $id;
                $_SESSION['user_status'] = $user_status;
                $_SESSION['user_name'] = $username;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['phone'] = $phone;
                $_SESSION['address'] = $address;

                load_cart();
                session_write_close();
                header('Location: index.php');
                echo 'login success';
            }
            else{
<<<<<<< HEAD
                    header('Location: signIn.php?login=f');
                    
                   exit();
=======
                $_SESSION['errorMessage'] = "Username/password is invalid.";
                header('Location: signIn.php');

                exit();
>>>>>>> b875bbc208bc2318ad723d264eceed8dd52d5919
            }
	}
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