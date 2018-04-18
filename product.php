<?php
session_start(); 

function getRatingStarString($rating) {
  /*
    1 star:  0    -  1.49999
    2 star:  1.5  -  2.499999
    3 star:  2.5. -  3.499999
    4 star:  3.5  -  4.499999
    5 star:  4.5  -  5
  */
  if($rating==0)
      return "&#9734; &#9734; &#9734; &#9734; &#9734;";
  else if ($rating < 1.5)
    return "&#9733; &#9734; &#9734; &#9734; &#9734;";
  else if ($rating < 2.5)
    return "&#9733; &#9733; &#9734; &#9734; &#9734;";
  else if ($rating < 3.5)
    return "&#9733; &#9733; &#9733; &#9734; &#9734;";
  else if ($rating < 4.5)
    return "&#9733; &#9733; &#9733; &#9733; &#9734;";
  else
    return "&#9733; &#9733; &#9733; &#9733; &#9733;";
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

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

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
            <a href="search.php?search+item=%cardgame" class="list-group-item" name="card games">Card Games</a>
            <a href="search.php?search+item=%videogame" class="list-group-item" name="video games">Video Games</a>
            <a href="search.php?search+item=%giftcard" class="list-group-item" name="gift cards">Gift Cards</a>
          </div>

        </div>
        <!-- /.col-lg-3 -->
        
        <div class="col-lg-9">
          <div class="card mt-4">
            <?php
              if(isset($_GET['id'])) {

                $product_name = 'A Product';
                $product_description = 'A description of the product';
                $product_price = "$50.00";
                $product_avg_rating = 2.33;
                $product_rating_string = getRatingStarString($product_avg_rating);

                $product_id = (int)$_GET['id'];

                require_once 'databaseConnector.php';
                require_once 'itemDAO.php';
                $db = new databaseConnector();
                $con = $db->getConnection();

                $item_dao = new itemDAO();
                $items = $item_dao->selectByID($product_id, $con);

                if (count($items) == 1) {
                  $product_name = $items[0]->name;
                  $product_description = $items[0]->description;;
                  $product_price = $items[0]->price;
                  $product_avg_rating = $items[0]->rating;
                  $product_rating_string = getRatingStarString($product_avg_rating);
                  $product_img_link = $items[0]->imageLink;
                } else {
                  // product id not found
                  header('Location: signIn.php');
                }

                $product_img_uri = "imgs/" . $product_img_link;

              } else {
                // $product_name = 'Product Name';
                // $product_price = '$24.99';
                // $product_description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente dicta fugit fugiat hic aliquam itaque facere, soluta. Totam id dolores, sint aperiam sequi pariatur praesentium animi perspiciatis molestias iure, ducimus!';
                // $product_avg_rating = 4.0;
                // $product_rating_string = getRatingStarString($product_avg_rating);
                // $product_id = '-1';
                // $product_img_uri = "http://placehold.it/900x400";

                // redirect back to home (no valid product to show)
                header('Location: index.php');
              }
            ?>
            <img class="card-img-top img-fluid col-sm-6" src="<?php echo $product_img_uri; ?>" alt="">
            <div class="card-body">
              <h3 class="card-title"><?php echo $product_name; ?></h3>
              <h4>$<?php echo number_format((float)$product_price, 2, '.', ''); ?></h4>
              <p class="card-text"><?php echo $product_description; ?></p>
              <span id="product-avg-rating" class="text-warning"><?php echo $product_rating_string; ?></span>
              <?php 
              if ($product_avg_rating!=0){
                  echo $product_avg_rating; ?> stars
                  <?php
                  
              }
                  else{
                      echo "This product has not been rated yet";
                  }
                  ?>
              <hr>
              <span class="itemid" hidden><?php echo $product_id; ?></span>
              <button type="button" id="add-to-cart-btn" class="btn btn-success">Add to Cart</button>
            </div>
          </div>
          <!-- /.card -->


          <!--*************************************
               TODO retrieve reviews from database
              ************************************* -->

          <div class="card card-outline-secondary my-4">
            <div class="card-header">
              Product Reviews
            </div>
            <?php 
                $result = mysqli_query($con, "SELECT * FROM user_rating WHERE product_id= ".$_GET["id"].";");
                if ( mysqli_num_rows($result)== 0) { 
                    echo "This product has not been rated yet";
                } else { 
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    ?>
                
              <span class="text-warning"><?php 
                      $rating=(int)$row['rating'];
                      
                      for($stars=5;$stars>0;$stars--){
                        if ($rating>0){
                            $rating--;
                            ?>
                        &#9733;
                            <?php
                        }
                        else{
                            ?>
                            &#9734;
                            <?php
                        }
                      }
                      ?></span>
              <p><?php echo $row['description']?></p>
              <?php $user=mysqli_query($con, "SELECT * FROM users WHERE users.user_id= ".$row['user_id'].";"); 
              $username=mysqli_fetch_array($user, MYSQLI_ASSOC)?>
              <small class="text-muted">Posted by <?php echo $username['username']?></small>
              <hr>
                <?php }
                }?>
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
    <script src="scripts/product.js"></script>

  </body>

</html>
