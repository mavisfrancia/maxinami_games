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
	
	if(empty($_POST["password"])){
		$ERR = "Password is Required";
	}
	else{
		$password = test_input($_POST["password"]);
	}
	
        //If fields are empty return to sign in
	if(!empty($ERR)){
		header('Location: signIn.php');
		exit();
	}
	else{
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$con = new mysqli($servername, $serverusername, $serverpassword, "maxinami_games");
		$username = mysqli_real_escape_string($con, $_POST['username']);
		$userpass = $_POST['password'];
		
		$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username';");
		
		//Username is found
		if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                		$user_id = $row['user_id'];
                		$user_status = $row['status'];
                        $password = $row['hashedpass'];//Get hashed password
                        $fullname = $row['fullname'];
                        $address = $row['address'];
                        $phone = $row['phonenumber'];
                }
                
                //If password does not match with database
                if(!password_verify($userpass, $password)){
                        header('Location: signIn.php');
                        exit();
                }
                else{
                        session_regenerate_id();
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['user_status'] = $user_status;
                        $_SESSION['user_name'] = $username;
                        $_SESSION['fullname'] = $fullname;
                        $_SESSION['phone'] = $phone;
                        $_SESSION['address'] = $address;

						load_cart();

                        session_write_close();
                        header('Location: index.php');
                        
                        
                }
		}
		else{//Username is not found
			header('Location: signIn.php');
			exit();
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
	require_once 'databaseConnector.php';
	require_once 'shoppingCartDAO.php';
	$db = new databaseConnector();
	$con = $db->getConnection();
	$cartDAO = new shoppingCartDAO();

	if (!isset($_SESSION['cart'])) { // create cart if not created yet
		$_SESSION['cart'] = [];
	}

	$result = $cartDAO->selectByUser($_SESSION['user_id'],$con);

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$itemid = $row['product_id'];
		$quantity = $row['quantity'];
		$_SESSION['cart'][$itemid] = $quantity;
	}
}

?>