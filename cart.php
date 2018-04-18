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

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Maxinami Games</a>
        
            <form class="form-inline" method ="post" action="search.php">
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
            <a href="search.php" class="list-group-item" name="board games">Board Games</a>
            <a href="search.php" class="list-group-item" name="card games">Card Games</a>
            <a href="search.php" class="list-group-item" name="video games">Video Games</a>
            <a href="search.php" class="list-group-item" name="gift cards">Gift Cards</a>
          </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">
          <div class="card mt-4">
            <div class="card-body">
              <h1>Shopping Cart</h1>

              <?php
              if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)  { 
              // if cart exists and is not empty, display contents
              ?>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                  require_once 'databaseConnector.php';
                  require_once 'itemDAO.php';
                  $db = new databaseConnector();
                  $con = $db->getConnection();
                  $item_dao = new itemDAO();

                  $subtotal = 0.0;
                  
                  foreach($_SESSION['cart'] as $itemid => $qty) {
                    $items = $item_dao->selectByID($itemid, $con);
                    if (count($items) == 1) {
                      $product_name = $items[0]->name;
                      $product_description = $items[0]->description;;
                      $product_price = "$" . $items[0]->price;
                      ?>

                      <tr>
                        <td class="itemid" hidden><?php echo $itemid ?></td>
                        <td><?php echo $product_name; ?></td>
                        <td><input type="text" class="form-control qty-input" value="<?php echo $qty; ?>"></td>
                        <td><?php echo $product_price; ?></td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i></button></td>
                      </tr>

                      <?php
                      $subtotal += doubleval($items[0]->price) * (int)$qty;
                    }
                  }

                  ?>
                </tbody>
              </table>
              <div class="container subtotal">
                <h2 id="subtotal-label">Subtotal:</h2>
                <p id="subtotal-value">$<?php echo $subtotal; ?></p>
              </div>
              <button type="button" class="btn btn-success btn-block">Checkout</button>
              
              <?php

              } // end if
              else {
                // No items in cart!
                echo 'No items in cart.';
              }

              ?>
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
    <script src="scripts/cart.js"></script>

  </body>

</html>
