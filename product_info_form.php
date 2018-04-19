<?php session_start();

if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] != 0) {
  header('Location: signin.php');
}

if (!isset($_GET['action'])) {
  header('Location: index.php');
}

if ($_GET['action'] != 'add_new_product' && $_GET['action'] != 'update_product') {
  header('Location: index.php');
}

if ($_GET['action'] == 'update_product') {
  if(!isset($_GET['id'])) {
    header('Location: index.php');
  } else {
    require_once 'itemDAO.php';
    require_once 'databaseConnector.php';
    $db = new databaseConnector();
    $con = $db->getConnection();

    $itemDAO = new itemDAO();
    $items = $itemDAO->selectByID($_GET['id'], $con);
    if (count($items) == 1) {
      $name = $items[0]->name;
      $type = $items[0]->type;
      $description = $items[0]->description;
      $inventory = $items[0]->number;
      $price = $items[0]->price;
      $pictureLinkLabel=$items[0]->imageLink;
    } else {
      die("ERROR: Duplicate id found.");
    }

  }
} else {
  $name = '';
  $type = '-1';
  $description = '';
  $inventory = '';
  $price = '';
  $pictureLinkLabel = 'Choose file';
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
            <div class="card-body">
              <h1><?php

              if ($_GET['action'] == 'add_new_product') {
                echo 'Add New Product';
              } else {
                echo 'Update Product';
              }


              ?></h1>
              <hr>

              <form id="product-form" enctype="multipart/form-data" action="admin_update_itemlist.php" method="POST">
                <input name="action" value=<?php
                if ($_GET['action'] == 'update_product')
                  echo 'update_item';
                else
                  echo 'add_item';
                ?> hidden>
                <?php if ($_GET['action'] == 'update_product') { ?>
                <input name="id" value=<?php echo $_GET['id']; ?> hidden>
                <?php } ?>
                <div class="form-group">
                  <label for="product-name">Product Name</label>
                  <input name="product-name" type="text" class="form-control" id="product-name" aria-describedby="productName" value="<?php echo $name; ?>">
                </div>
                <div class="form-group">
                  <label for="product-type">Type</label>
                  <select name="product-type" class="custom-select" name="rating" id="product-type">
                    <option <?php if ($type == '-1') echo 'selected'; ?> disabled hidden>Select a product type...</option>
                    <option <?php if ($type == '1') echo 'selected'; ?> value="1">Board Game</option>
                    <option <?php if ($type == '2') echo 'selected'; ?> value="2">Video Game</option>
                    <option <?php if ($type == '3') echo 'selected'; ?> value="3">Card Game</option>
                    <option <?php if ($type == '4') echo 'selected'; ?> value="4">Gift Card</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="product-description">Description</label>
                  <textarea name="product-description" class="form-control" rows="6" id="product-description"><?php echo $description; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="product-inventory">Inventory</label>
                  <input name="product-inventory" type="text" class="form-control" id="product-inventory" aria-describedby="inventory" value="<?php echo $inventory; ?>">
                </div>
                <div class="form-group">
                  <label for="product-price">Price</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input name="product-price" id="product-price" type="text" class="form-control" aria-label="price" aria-describedby="productPrice" value="<?php echo $price; ?>">
                  </div>
                </div> 
                <div class="form-group">
                  <label for="product-image">Image</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input name="product-image" type="file" class="custom-file-input" id="product-image">
                        <label id="product-image-label" class="custom-file-label" for="product-image"><?php echo $pictureLinkLabel; ?></label>
                      </div>
                    </div>

                </div>
                <button id="submit-btn" name="submit" type="submit" class="btn btn-primary">Submit</button>
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
    <script src="scripts/product_info_form.js"></script>

  </body>

</html>