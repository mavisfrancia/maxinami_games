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

               //Check if username already exists
               $.ajax({
                   url: "check_if_username_available.php",
                   type: "post",
                   data: encodeURI("username=" + $("#username").val()),
                   success: function(data) {
                   
                   if(data === "false") //If username exists prevent the user from entering the data and inform them
                   {
                       emailText = "Email already exists";
                       $("#usernameerror").css({"color": "red"});
                       document.getElementById("usernameerror").innerHTML = emailText;
                       usernameFilled = false;
                   } 
                   else //If username is new, give the user an ok message
                   {
                       emailText = "Username is OK";
                       $("#usernameerror").css({"color": "green"});
                       document.getElementById("usernameerror").innerHTML = emailText;
                       usernameFilled = true;
                   }
                   },
                   error: function(data) {
                           alert("error! " + data);
                   }

                   });
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
       //Determines the strength of the password by checking for special character or number
       var numberTest = /\d+/;
       var specialTest = /[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/;
       
       //Test password for either a number or special character
       var hasNumber = numberTest.test(pass);
       var hasSpecial = specialTest.test(pass);
       var hasLength = false;

       //Check for password length
       if (pass.length >= 8)//Check for length
       {
           hasLength = true;
       }
       else
       {
           hasLength = false;
       }

       //Show password strength
       //If password is long and contains either a special character or number
       if((hasSpecial || hasNumber) && hasLength)
       {
           passverify = "Password is strong";
           $("#passverification").css({"color": "green"});
           document.getElementById("passverification").innerHTML = passverify;
       }
       else if(hasLength)//If password is long
       {
           passverify = "Password is medium";
           $("#passverification").css({"color": "orange"});
           document.getElementById("passverification").innerHTML = passverify;
       }
       else//If neither
       {
           passverify = "Password is weak";
           $("#passverification").css({"color": "red"});
           document.getElementById("passverification").innerHTML = passverify;
       }

       //If password is empty, clear text
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

    //For confirm
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