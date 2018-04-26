<?php
require_once 'userService.php';

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$ERR="";
	
	$servername = 'localhost';
	$serverusername = 'root';
	$serverpassword = '';
	
	
	
	
        
        if(empty($_POST["name"])){
		//Do nothing
	}
	else{
		$username = test_input($_POST["name"]);
	}
        
        if(empty($_POST["phone"])){
		//Do nothing
	}
	else{
		$phone = test_input($_POST["phone"]);
	}
	
        if(empty($_POST["address"])){
		//Do nothing
	}
	else{
		$address = test_input($_POST["address"]);
	}
        
	if(empty($_POST["password"])){
		//Do nothing
	}
	else{
		$password = test_input($_POST["password"]);
                
                if(empty($_POST["confirm"])){
		
                }
                else{
                    
                    $confirm = test_input($_POST["confirm"]);
                    
                    //Test if confirm password is the same as password and the passsword is changed
                    if(strcmp($password, $confirm))
                    {
                        $ERR = "Password and Confirm Password are different!";
                    }
                }
	}
        
        
        
        
	
        //If required fields are empty or passwords are different, return to account create
	if(!empty($ERR)){
		header('Location: account_edit.php');
		exit();
	}
	else{
            //Gain access to userService.php
            $userService = new userService();
            
            //Store user info
            $id = $_SESSION['user_id'];
            //Abort if id is not found *This should not happen
            if($id == -1)
            {
                echo 'id not found';
            }
            else 
            {
                $row = $userService->getInfo($id);



                $username = $row["username"];
                $fullname = $row['fullname'];
                $address = $row['address'];
                $phone = $row['phonenumber'];
                $password = $row['hashedpass'];
                $status = $row['status'];



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
                    //Encrypt password
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                }

                echo $username, $fullname, $password, $address, $phone, $status ."<br />";

                //Update user info
                $update = $userService->updateInfo($id, $username, $fullname, $address, $password, $phone, $status);

                //If update did not succeed, give error
                if(!$update)
                {
                    echo "Fatal Error: Update did not complete";
                }
                else
                {
                    session_regenerate_id();
                    $_SESSION['user_name'] = $username;
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['user_status'] = $status;
                    $_SESSION['address'] = $address;
                    $_SESSION['user_id'] = $id;



                    session_write_close();
                    header('Location: index.php');
                }
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