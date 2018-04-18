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
    <link href="css/account.css" rel="stylesheet">
    <link href="css/adminproductlist.css" rel="stylesheet">

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
            
            <li class="nav-item active">
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
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a id="account-info-tab" class="nav-link active" href="#">Account Info</a>
              </li>
              <li class="nav-item">
                <a id="order-history-tab" class="nav-link" href="#">Order History</a>
              </li>
              <?php
              if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 0) {
              ?>
              <li class="nav-item">
                <a id="modify-items-tab" class="nav-link" href="#">Modify Items</a>
              </li>
              <?php } ?>
            </ul>
            <div class="card-body" id="account-info-card">
              <div class="container">
                <p class="card-text">Username: <?php echo $_SESSION['user_name']?></p>
                <p class="card-text">Name: <?php echo $_SESSION['fullname']?></p>
                <p class="card-text">Phone #: <?php echo $_SESSION['phone']?></p>
                <p class="card-text">Address: <?php echo $_SESSION['address']?></p>
                <a class="btn btn-primary" href="account_edit.php">Edit</a>
              </div>
            </div>
            <div class="card-body hidden" id="order-history-card">
              <div class="container">
                <?php
                $servername = 'localhost';
                $serverusername = 'root';
                $serverpassword = '';
                $con = new mysqli($servername, $serverusername, $serverpassword, "maxinami_games");
                
                $result=mysqli_query($con, "SELECT * FROM users WHERE username= \"".$_SESSION['user_name']."\";");
                
                $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
                $id=$row['user_id'];
                
                $result=mysqli_query($con, "SELECT * FROM purchase_history WHERE user_id= ".$id.";");

                $numPurchases = mysqli_num_rows($result);

                if ( $numPurchases == 0) {
                echo "No purchases have been made";
                echo "<br>";
                } else { 
                ?> 
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Date Purchased</th>
                      <th scope="col">Product</th>
                      <th scope="col">Qty</th>
                      <th scope="col">Price</th>
                      <th scope="col">Write Review</th>
                    </tr>
                  </thead>
                   <tbody>
                    <?php
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    ?> 
                    <tr>
                        <?php
                        $query = mysqli_query($con, "SELECT * FROM items WHERE itemid=".$row['product_id'].";");
                        $product = mysqli_fetch_array($query, MYSQLI_ASSOC);
                        ?>
                        <td><?php echo $row['time_of_purchase']?></td>
                        <td><?php echo $product['name']?></td>
                      <td><?php echo $row['quantity']?></td>
                      <td><?php echo $product['price']?></td>
                      <td><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></button></td>
                    </tr>
                        <?php
                        }
                        }
                        mysqli_close($con);
                        ?>
                   
                  </tbody>
                </table>
              </div>
            </div>
            <?php
            if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 0) {
            ?>
            <div class="card-body hidden" id="modify-items-card">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Price</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  require_once 'itemService.php';
                  $itemService = new itemService();
                  $result = $itemService->searchItem("%all%");

                  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?><tr>
                    <td class="item-id" hidden><?php echo $row['itemid']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><input type="text" class="form-control stock-num-input inventory" value="<?php echo $row['inventory']; ?>"></td>
                    <td>$<?php echo number_format($row['price'], 2, '.', ''); ?></td>
                    <td><button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-pencil"></i></button></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i></button></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              <button type="button" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Add New Product</button>
            </div>
            <?php } ?>
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

    <?php
    if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 0) {
    ?>
    <script src="scripts/adminaccount.js"></script>
    <?php } else { ?>
    <script src="scripts/account.js"></script>
    <?php } ?>

  </body>

</html>