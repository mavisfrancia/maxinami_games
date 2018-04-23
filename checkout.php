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

    <!-- Icon set -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    <link href="css/cart.css" rel="stylesheet">
    <link href="css/account.css" rel="stylesheet">

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
            <li class="nav-item active">
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
              <h1>Checkout</h1>
              <hr>

              <form>
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" aria-describedby="address">
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="address" class="form-control" id="address" aria-describedby="address">
                </div>
                <div class="form-group">
                  <label for="city">City</label>
                  <input type="address" class="form-control" id="city" aria-describedby="city">
                </div>
                <div class="form-group">
                  <label for="state">State</label>
                  <input type="address" class="form-control" id="state" aria-describedby="state">
                </div>
                <div class="form-group">
                  <label for="zip-code">Zip Code</label>
                  <input type="address" class="form-control" id="zip-code" aria-describedby="zipCode">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" aria-describedby="address">
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="tel" class="form-control" id="phone" aria-describedby="address">
                </div>
                <div class="form-group">
                  <label for="credit-card">Credit Card</label>
                  <input type="credit-card" class="form-control" id="credit-card" aria-describedby="createAccount">
                </div>
                <div <?php echo (isset($_GET['user_id'] ? "hidden" : "") ?>class="form-group">
                  <label for="create-account-check">Create Account</label>
                  <input type="checkbox" class="form-control" id="create-account-check" aria-describedby="createAccount">
                </div>
                <div class="form-group hidden" id="password-input-group">
                  <label for="password">Create a password</label>
                  <input type="password" class="form-control" id="password" aria-describedby="address">
                </div>
                
                <div class="container subtotal">
                  <h2 id="subtotal-label">Subtotal:</h2>
                  <p id="subtotal-value">$99.97</p>
                </div>

                <button type="submit" class="btn btn-primary">Checkout</button>
              </form>
            </div>

          </div>
          <!-- /.card -->

          
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
    
    <script src="scripts/checkout.js"></script>

  </body>

</html>
