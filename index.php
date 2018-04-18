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
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
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
             

          <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
               <?php
            $servername = 'localhost';
            $serverusername = 'root';
            $serverpassword = '';
            $con = new mysqli($servername, $serverusername, $serverpassword, "maxinami_games");
            $result = mysqli_query($con, "SELECT product_id,SUM(quantity) as amt,pictureLink FROM purchase_history,items WHERE purchase_history.product_id=items.itemid GROUP BY product_id ORDER BY amt DESC");
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            ?>
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <a href="product.php?action=get_product&id=<?php echo $row['product_id']; ?>"><img class="d-block img-fluid" src=<?php echo 'imgs/'.$row['pictureLink']?> alt="First slide"></a>
              </div>
                <?php $row = mysqli_fetch_array($result, MYSQLI_ASSOC); ?>
              <div class="carousel-item">
                <a href="product.php?action=get_product&id=<?php echo $row['product_id']; ?>"><img class="d-block img-fluid" src=<?php echo 'imgs/'.$row['pictureLink']?> alt="Second slide"></a>
              </div>
                <?php $row = mysqli_fetch_array($result, MYSQLI_ASSOC); ?>
              <div class="carousel-item">
                <a href="product.php?action=get_product&id=<?php echo $row['product_id']; ?>"><img class="d-block img-fluid" src=<?php echo 'imgs/'.$row['pictureLink']?> alt="Third slide"></a>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <div class="row">
             
           <?php
            $result = mysqli_query($con, "SELECT * FROM items ORDER BY inventory DESC;");
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){                
            ?>  
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <a href=<?php echo "product.php?action=get_product&id=" . $row["itemid"] ?>><img class="card-img-top" src=<?php echo 'imgs/'.$row['pictureLink']?> alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href=<?php echo "product.php?action=get_product&id=" . $row["itemid"] ?>><?php echo $row['name']?></a>
                  </h4>
                  <h5>$<?php echo number_format($row['price'], 2, '.', '');?></h5>
                  <p class="card-text" id="description"><?php echo $row['description']?></p>
                </div>
                <div class="card-footer">
                  <small class="text-muted">
                      <?php 
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
                      ?>
                      </small>
                </div>
              </div>
            </div>

              <?php
              
                            }
                            mysqli_close($con);
              ?>
          </div>
          <!-- /.row -->

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
