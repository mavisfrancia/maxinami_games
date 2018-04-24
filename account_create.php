<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Maxinami Games</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    
    <script type='text/javascript' src='http://code.jquery.com/jquery.min.js'></script>
    <script type="text/javascript">
     //This script stops new users from creating an account if either 
     //all required fields are not entered or password and confirm password is mismatched
     $(document).ready(function(){
         
        //Create boolean variables
        var usernameFilled = false;
        var nameFilled = false;
        var addressFilled = false;
        var passwordFilled = false;
        //This text contains the error of passwords mismatch
        var text = "";
        
        //For number relation teet
        var isNumber = /^[0-9]+$/;
        
        //For the username(email) field
        $("#username").keyup(function(){
            //Store email error message
            var emailText = "";
                     
            //If the field is empty
            if($(this).val() === '')
            {
                //Empty text
                emailText = "";
                $("#usernameerror").css({"color": "green"});
                document.getElementById("usernameerror").innerHTML = emailText;
                usernameFilled = false;
            }
            else
            {
                //Check to see if email is valid
                var email = document.getElementById("username").value;
                var isEmail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                var isCorrect = isEmail.test(email);
                
                //If email is invalid, stop user from entering data
                if(!isCorrect)
                {
                    emailText = "Username must be an email";
                    $("#usernameerror").css({"color": "red"});
                    document.getElementById("usernameerror").innerHTML = emailText;
                    usernameFilled = false;
                }
                else//If email is valid, pass the usernameFilled check
                {
                    //Empty text
                    emailText = "";
                    $("#usernameerror").css({"color": "green"});
                    document.getElementById("usernameerror").innerHTML = emailText;
                    
                    usernameFilled = true;
                }
            }
            
            //Check it all required fields are filled and enable/disable button if they
            //are or are not respectively
            if(usernameFilled && nameFilled && addressFilled && passwordFilled)
            {
                $("#userSubmit").prop("disabled", false);
            }
            else
            {
                $("#userSubmit").prop("disabled", true);
            }
        });  
        
        //For the name field
        $("#name").keyup(function(){
            
            if($(this).val() === '')
            {
                nameFilled = false;
            }
            else
            {
                nameFilled = true;
            }
            
            //Check it all required fields are filled and enable/disable button if they
            //are or are not respectively
            if(usernameFilled && nameFilled && addressFilled && passwordFilled)
            {
                $("#userSubmit").prop("disabled", false);
            }
            else
            {
                $("#userSubmit").prop("disabled", true);
            }
        });
        
        //For the address field
        $("#address").keyup(function(){
            
            if($(this).val() === '')
            {
                addressFilled = false;
            }
            else
            {
                addressFilled = true;
            }
            
            //Check it all required fields are filled and enable/disable button if they
            //are or are not respectively
            if(usernameFilled && nameFilled && addressFilled && passwordFilled)
            {
                $("#userSubmit").prop("disabled", false);
            }
            else
            {
                $("#userSubmit").prop("disabled", true);
            }            
        }); 
        
        //For phone field
        $("#phone").keyup(function(){
            var phoneText = "";
            var phone = document.getElementById("phone").value;
            
            //If phone field is empty check to see if all other required fields are filled
            if($(this).val() === '')
            {
                //Empty text
                phoneText = "";
                $("#phoneerror").css({"color": "green"});
                document.getElementById("phoneerror").innerHTML = phoneText;
                
                //Check it all required fields are filled and enable/disable button if they
                //are or are not respectively
                if(usernameFilled && nameFilled && addressFilled && passwordFilled)
                {
                    $("#userSubmit").prop("disabled", false);
                }
                else
                {
                    $("#userSubmit").prop("disabled", true);
                } 
            }
            else//If phone is filled, check to see if the entry is valid
            {
                var isCorrect = isNumber.test(phone);
                
                //If phone number is invalid stop user from entering data
                if(!isCorrect)
                {
                    phoneText = "Phone number can only consist of numbers";
                    $("#phoneerror").css({"color": "red"});
                    document.getElementById("phoneerror").innerHTML = phoneText;
                    $("#userSubmit").prop("disabled", true);
                }
                else//Check to see if all required fields are filled
                {
                    //Empty text
                    phoneText = "";
                    $("#phoneerror").css({"color": "green"});
                    document.getElementById("phoneerror").innerHTML = phoneText;
                    
                    //Check it all required fields are filled and enable/disable button if they
                    //are or are not respectively
                    if(usernameFilled && nameFilled && addressFilled && passwordFilled)
                    {
                        $("#userSubmit").prop("disabled", false);
                    }
                    else
                    {
                        $("#userSubmit").prop("disabled", true);
                    } 
                }
            }
        });
        
        //For the password field
        $("#password").keyup(function(){
            //Get strings for both confirm and password
            var pass = document.getElementById("password").value;
            var confirm = document.getElementById("confirm").value;
            //Contains the text for password strength
            var passverify = "";
            //Determines the strength of the password
            var passStrength = 0;
            var hasNumber = false;
            var hasLetter = false;
            var hasSpecial = false;
            var hasLength = false;
            
            //Create test variables
            if(pass.search(/^[0-9]*$/))//Check For numbers
            {
                hasNumber = true;
            }
            else
            {
                hasNumber = false;
            }
            if(pass.search(/^[a-z]*$/i))//Check for lower case
            {
                hasLetter = true;
            }
            else
            {
                hasLetter = false;
            }
            if(pass.search(/^[!@#\$%\^&\*]*$/)) //check for special characters
            {
                hasSpecial = true;
            }
            else
            {
                hasSpecial = false;
            }
            if (pass.length >= 5)//Check for length
            {
                hasLength = true;
            }
            else
            {
                hasLength = false;
            }
            if(hasLetter)
                passStrength += 1;
            else
                passStrength -= 1;
            if(hasNumber)
                passStrength += 1;
            else
                passStrength -= 1;
            if(hasSpecial)
                passStrength += 1;
            else
                passStrength -= 1;
            if(hasLength)
                passStrength += 1;
            else
                passStrength -= 1;
            
            //Show password strength
            if(passStrength <= 2)
            {
                passverify = "Password is weak";
                $("#passverification").css({"color": "red"});
                document.getElementById("passverification").innerHTML = passverify;
            }
            else
            {
                passverify = "Password is strong";
                $("#passverification").css({"color": "green"});
                document.getElementById("passverification").innerHTML = passverify;
            }
            
            if (pass === "")
            {
                //Empty Text
                passverify = "";
                $("#passverification").css({"color": "red"});
                document.getElementById("passverification").innerHTML = passverify;
            }
            
            
            //If both password and confirm are filled check for match and
            //change password filled to true if so or show error text if not
            if(pass === "" || confirm === "")
            {
                passwordFilled = false;
                
                
            }
            else
            {
                //Test if confirm password is the same as password
                if(pass === confirm)
                {
                    text = "";
                    document.getElementById("test").innerHTML = text;
                    passwordFilled = true;
                }
                else
                {
                    text = "Password and Confirm Password are different!";
                    $("#test").css({"color": "red"});
                    document.getElementById("test").innerHTML = text;
                                       
                }
            }
            
            //Check it all required fields are filled and enable/disable button if they
            //are or are not respectively
            if(usernameFilled && nameFilled && addressFilled && passwordFilled)
            {
                $("#userSubmit").prop("disabled", false);
            }
            else
            {
                $("#userSubmit").prop("disabled", true);
            }

            
        }); 
        
        $("#confirm").keyup(function(){
            var pass = document.getElementById("password").value;
            var confirm = document.getElementById("confirm").value;
            
            //If both password and confirm are filled check for match and
            //change password filled to true if so or show error text if not
            if($(this).val() === '' || pass === "")
            {
                passwordFilled = false;
            }
            else
            {
                //Test if confirm password is the same as password
                if(pass === confirm)
                {
                    text = "";
                    document.getElementById("test").innerHTML = text;
                    passwordFilled = true;
                }
                else
                {
                    text = "Password and Confirm Password are different!";
                    $("#test").css({"color": "red"});
                    document.getElementById("test").innerHTML = text;
                    passwordFilled = false;
                }
            }
            
            //Check it all required fields are filled and enable/disable button if they
            //are or are not respectively
            if(usernameFilled && nameFilled && addressFilled && passwordFilled)
            {
                $("#userSubmit").prop("disabled", false);
            }
            else
            {
                $("#userSubmit").prop("disabled", true);
            }
        });
            
        
     });
    </script>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Maxinami Games</a>
        
            <form class="form-inline" method ="get" action="search.php">
                <input class="form-control mr-sm-2" id="search-bar" placeholder="Search" aria-label="Search" name="search item">
                <button class="btn btn-outline-secondary my-2 my-sm-2" id="button" type="submit">Search</button>
            </form>
        
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
           
            <li class="nav-item">
                <?php
                    if (isset($_SESSION['user_name']))
                        echo "<a class=\"nav-link\" href=\"account.php\">Your Account</a>";
                    else
                        echo "<a class=\"nav-link\" href=\"signIn.php\">Sign In</a>";
                ?>
              
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php">Cart</a>
            </li>
            <li class="nav-item">
                <?php      
                    if (isset($_SESSION['user_name']))
                        echo "<a class=\"nav-link\" href=\"logout.php\">Log Out</a>";
                ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-3">

          <h1 class="my-4">Maxinami Games</h1>
          <div class="list-group">
            <a href="search.php?search+item=%boardgame" class="list-group-item" name="board games">Board Games</a>
            <a href="search.php?search+item=%25cardgame" class="list-group-item" name="card games">Card Games</a>
            <a href="search.php?search+item=%videogame" class="list-group-item" name="video games">Video Games</a>
            <a href="search.php?search+item=%giftcard" class="list-group-item" name="gift cards">Gift Cards</a>
          </div>

        </div>
        <!-- /.col-lg-3 -->
        
        <div class="col-lg-9">

            <div class="card mt-4">
                <div class="card-body">
                    <!--Create fields-->
                    <form id="user_info" method="post" action="validate_create.php">
                        <div class="container">
                            <div>
                                    <label for="username">*Username</label>
                                    <input type="text" id="username" name="username">
                                    <p id="usernameerror"></p>
                            </div>
                            <div>
                                    <label for="name">*Name</label>
                                    <input type="text" id="name" name="name">
                            </div>
                            <div>
                                    <label for="name">*Address</label>
                                    <input type="text" id="address" name="address">
                            </div>
                            <div>
                                    <label for="name">Phone Number</label>
                                    <input type="text" id="phone" name="phone">
                                    <p id="phoneerror"></p>
                            </div>
                            <div>
                                    <label for="password">*Password</label>
                                    <input type="Password" id="password" name="password">
                                    <p id="passverification"></p>
                            </div>
                            <div>
                                    <label for="password">*Confirm Password</label>
                                    <input type="Password" id="confirm" name="confirm">
                            </div>
                            <div id="user_submit">
                                <button class="btn btn-primary" type="submit" id="userSubmit" class="enableSubmit" disabled="diabled">Create Account</button>
                            </div>

                            <div id="message">
                                <p>*Required fields</p>
                                <p id="test"></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!-- /.col-lg-9 -->



      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-4 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Maxinami Games 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
