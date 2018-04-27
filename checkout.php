<?php session_start();

$signedIn = isset($_SESSION['user_id']);

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
  header("Location: index.php");
}

?>
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
    <link href="css/checkout.css" rel="stylesheet">

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

              <form id="checkout-form" method="post" action="checkoutitems.php">
                <div class="form-group">
                  <label for="name">*Name</label>
                  <input name="name" type="text" class="form-control" id="name" aria-describedby="name" value="<?php echo ($signedIn ? $_SESSION['fullname'] : ''); ?>">
                </div>
                <div class="form-group">
                  <label for="address">*Address</label>
                  <input name="address" type="address" class="form-control" id="address" aria-describedby="address" value="<?php echo ($signedIn ? $_SESSION['address'] : ''); ?>">
                </div>
                <div class="form-group">
                  <label for="email">*Email</label>
                  <input name="username" type="email" class="form-control" id="email" aria-describedby="email" value="<?php echo ($signedIn ? $_SESSION['user_name'] : ''); ?>">
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="tel" class="form-control" id="phone" aria-describedby="phone" value="<?php echo ($signedIn ? $_SESSION['phone'] : ''); ?>">
                </div>
                <div class="form-group">
                  <label for="credit-card">*Credit Card</label>
                  <input type="credit-card" class="form-control" id="credit-card" aria-describedby="credit-card">
                </div>
                <div <?php echo (isset($_SESSION['user_id']) ? "hidden" : ""); ?> class="form-group">
                  <label for="create-account-check">Create Account</label>
                  <input name="create-check" type="checkbox" class="form-control" id="create-account-check" aria-describedby="createAccount">
                </div>
                <div id="password-input-group" class="hidden">
                  <div class="form-group">
                    <label for="password">*Create a password</label>
                    <input name="password" type="password" class="form-control" id="password" aria-describedby="password">
                  </div>
                  <div class="form-group">
                    <label for="password-verify">*Verify password</label>
                    <input name="confirm" type="password" class="form-control" id="password-verify" aria-describedby="password">
                  </div>
                </div>
                <p class="text-muted">*Required Fields</p>

                <?php
                if (!isset($_SESSION['cart']) || count($_SESSION['cart']) < 1)  {
                  // if cart does not exist or is empty, go back to cart
                  header('Location: cart.php');
                } 
                ?>
                <br>
                <hr>
                <h2>Order</h2>

                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Qty</th>
                      <th scope="col">Price</th>
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
                          <td><?php echo $qty; ?></td>
                          <td><?php echo $product_price; ?></td>
                        </tr>

                        <?php
                        $subtotal += doubleval($items[0]->price) * (int)$qty;
                      }
                    }

                    ?>
                  </tbody>
                </table>
                <div class="container subtotal">
                  <p id="subtotal-label"><strong>Subtotal:</strong>
                  <span id="subtotal-value">$<?php echo number_format($subtotal, 2, '.', ''); ?></span></p>
                  <p id="tax-label"><strong>Sales Tax:</strong>
                  <span id="tax-value">$<?php echo number_format(0.0825 * $subtotal, 2, '.', ''); ?></span></p>
                  <p id="shipping-label"><strong>Shipping:</strong>
                  <span id="shipping-value">FREE</span></p>
                  <h2 id="total-label">Total:</h2>
                  <p id="total-value">$<?php echo number_format(1.0825 * $subtotal, 2, '.', ''); ?></p>
                </div>

                <button type="button" class="btn btn-primary" id="checkout-btn" disabled=true>Checkout</button>
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