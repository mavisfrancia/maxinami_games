//This script stops new users from creating an account if either 
//all required fields are not entered or password and confirm password is mismatched
$(document).ready(function(){

    //Create boolean vars for password and phone
    var phoneCorrect = true;
    var passCorrect = true;

   //For number relation teet
   var isNumber = /^[0-9]+$/;

   //For phone field
   $("#phone").keyup(function(){
       var phoneText = "";
       var phone = document.getElementById("phone").value;

       //If phone field is empty, phoneCorrect is true
       if($(this).val() === '')
       {
           //Empty text
           phoneText = "";
           $("#phoneerror").css({"color": "green"});
           document.getElementById("phoneerror").innerHTML = phoneText;
           phoneCorrect = true;               

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
               phoneCorrect = false;                    
           }
           else//phoneCorrect is true
           {
               //Empty text
               phoneText = "";
               $("#phoneerror").css({"color": "green"});
               document.getElementById("phoneerror").innerHTML = phoneText;
               phoneCorrect = true;
           }
       }

       //Check to see if both password and phone are correct and enable user to edit if so
       if(phoneCorrect && passCorrect)
       {
           $("#userSubmit").prop("disabled", false);
       }
       else
       {
           $("#userSubmit").prop("disabled", true);
       }
   });

   //For the password field
   $("#password").keyup(function(){
       //For password error
       var text = "";
       var pass = document.getElementById("password").value;
       var confirm = document.getElementById("confirm").value;
       var passverify = "";

       //Contains the text for password strength
       var passverify = "";
       //Determines the strength of the password by checking for special character or number
       var numberTest = /\d+/;
       var specialTest = /[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/;
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
           passverify = "Password is meduim";
           $("#passverification").css({"color": "orange"});
           document.getElementById("passverification").innerHTML = passverify;
       }
       else
       {
           passverify = "Password is weak";
           $("#passverification").css({"color": "red"});
           document.getElementById("passverification").innerHTML = passverify;
       }

       if (pass === "")
       {
           //Empty Text
           passverify = "";
           $("#passverification").css({"color": "red"});
           document.getElementById("passverification").innerHTML = passverify;
       }


       //If password and confirm are empty passCorrect is true
       if($(this).val() === '' && confirm === "")
       {
           text = "";
           document.getElementById("test").innerHTML = text;
           passCorrect = true;
       }
       else
       {
           //If both password and confirm are filled check for match and
           //change password filled to true if so or show error text if not
           //Test if confirm password is the same as password
           if(pass === confirm)
           {
               text = "";
               document.getElementById("test").innerHTML = text;
               passwordFilled = true;
              passCorrect = true;
           }
           else
           {
               text = "Password and Confirm Password are different!";
               $("#test").css({"color": "red"});
               document.getElementById("test").innerHTML = text;
               passCorrect = false;
           }
       }

       //Check to see if both password and phone are correct and enable user to edit if so
       if(phoneCorrect && passCorrect)
       {
           $("#userSubmit").prop("disabled", false);
       }
       else
       {
           $("#userSubmit").prop("disabled", true);
       }
   }); 

   $("#confirm").keyup(function(){
       var text = "";
       var pass = document.getElementById("password").value;
       var confirm = document.getElementById("confirm").value;

       //If both password and confirm are filled check for match and
       //change password filled to true if so or show error text if not
       if($(this).val() === '' && pass === "")
       {
           text = "";
           document.getElementById("test").innerHTML = text;
           passCorrect = true
       }
       else
       {
           //Test if confirm password is the same as password
           if(pass === confirm)
           {
               text = "";
               document.getElementById("test").innerHTML = text;
               passCorrect = true;
           }
           else
           {
               text = "Password and Confirm Password are different!";
               $("#test").css({"color": "red"});
               document.getElementById("test").innerHTML = text;
               passCorrect = false;
           }
       }

       //Check to see if both password and phone are correct and enable user to edit if so
       if(phoneCorrect && passCorrect)
       {
           $("#userSubmit").prop("disabled", false);
       }
       else
       {
           $("#userSubmit").prop("disabled", true);
       }
   });


});