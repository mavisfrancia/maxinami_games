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
                    header('Location: signIn.php');
                    echo 'login fail';
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