<?php session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['action']) || !isset($_POST['item-id'])) {
  header('Location: account.php');
}

require_once 'itemDAO.php';
require_once 'databaseConnector.php';
$db = new databaseConnector();
$con = $db->getConnection();

$itemDAO = new itemDAO();
$items = $itemDAO->selectByID($_POST['item-id'], $con);
if (count($items) == 1) {
  $name = $items[0]->name;
  $pictureLink=$items[0]->imageLink;
} else {
  header('Location: account.php'); // ERROR: duplicate item found
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
    <link href="css/review.css" rel="stylesheet">

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
            <img class="card-img-top img-fluid" src="imgs/<?php echo $pictureLink; ?>" alt="">
              <div class="card-body">
                <h1>Write a Review</h1>
                <h3 class="card-title"><?php echo $name; ?></h3>
                <hr>

                <form action="#">
                  <span id="item-id" hidden><?php echo $_POST['item-id']; ?></span>
                  <div class="form-group">
                    <h4>Rating:</h4>
                    <!--div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rate from 1-5:</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Rating (whole number out of 5)">
                      <div class="input-group-append">
                        <span class="input-group-text">/5</span>
                      </div>
                    </div-->
                    <div class="input-group mb-3">
                      <select  class="custom-select" name="rating" id="rating">
                        <option selected disabled hidden>Select a rating...</option>
                        <option value="1">&#9733; &#9734; &#9734; &#9734; &#9734; (1 star)</option>
                        <option value="2">&#9733; &#9733; &#9734; &#9734; &#9734; (2 stars)</option>
                        <option value="3">&#9733; &#9733; &#9733; &#9734; &#9734; (3 stars)</option>
                        <option value="4">&#9733; &#9733; &#9733; &#9733; &#9734; (4 stars)</option>
                        <option value="5">&#9733; &#9733; &#9733; &#9733; &#9733; (5 stars)</option>
                      </select>
                    </div>
                    
                    <h4>Review:</h4>
                    <div class="input-group">
                      <textarea id="review-description" class="form-control" rows="6"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
                  </div>
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
    <script src="scripts/review.js"></script>

  </body>

</html>
