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

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    <link href="css/search.css" rel="stylesheet">

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
            </li><li class="nav-item">
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
            <br>
            <br>
            <?php
                $search=$_GET['search_item'];
                include_once 'itemService.php';
                $service=new itemService();
                $result = $service->searchItem($search);
                
                if(mysqli_num_rows($result)== 0){
                    echo "no results found";
                }
                else{
                    $rows=array();
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){     
                    $rows[]=$row;
                }
                $arraySize=sizeof($rows);
                include 'pages.php';
                $page = new pages();
                $page->setArraySize($arraySize);
               $currentPage=$page->getCurrentPage();
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(isset($_POST['perPage']))
                    {
                   
                    if ($_POST['perPage']=='all')
                        $total=$arraySize;
                    else
                        $total=$_POST['perPage'];
                    
                    $page->setItemsPerPage($total);  
                    
                    }
                    if(isset($_POST['pageNum'])){
                        $page->setCurrentPage((int)($_POST['pageNum']));
                        
                    }
                }
                $currentPage=$page->getCurrentPage();
                $pages=$page->setPages();
                $itemsPerPage = $page->getItemsPerPage();
             ?>
            <div id='page-buttons'>
              <?php     
              echo "<form id='pageform' action = '' method = 'post'>";
            if($currentPage==1)  
               echo "<button id='pageNum' disabled>previous</button>";
            else{
                
               echo "<button name='pageNum' id='pageNum' value='".($currentPage-1)."'>previous</button>";
               
            }
            echo "</form>";
            
            for($i=1;$i<=$pages;$i++){
                echo "<form id='pageform' action = '' method = 'post'>";
                if($i==$currentPage)
                    echo " <button id='pageNum' disabled>".$i."</button>";
                else{
                    echo " <button id='pageNum' name='pageNum' value='".$i."'>".$i."</button>";
                }
                echo "</form>";
            }
            echo "<form id='pageform' action = '' method = 'post'>";
            if($currentPage==$pages)
                echo "<button id='pageNum' disabled>next</button>";
            else{
                echo "<button id='pageNum' name='pageNum' value='".($currentPage+1)."'>next</button>"; 
            }
            echo "</form>";
            ?>
        
           
            <form action="" id='formid' method="POST"> 
                    <label>items per page: </label>
                    <select name='perPage' id='perPage' onchange="$('#formid').submit()" >
                        <option value='6'>6</option>
                         <option value='12'>12</option>
                         <option value='18'>18</option>
                         <option value='all'>all</option>
                     </select> 
                    </form>
            
         </div>
            <br/>
           
            <div class="row">
              
                <?php
                
                for($i=($currentPage-1)*$itemsPerPage;$i<$currentPage*$itemsPerPage&&$i<$arraySize;$i++){
                    
            ?>  
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <a href=<?php echo "product.php?action=get_product&id=" . $rows[$i]["itemid"] ?>><img class="card-img-top" src=<?php echo 'imgs/'.$rows[$i]['pictureLink']?> alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href=<?php echo "product.php?action=get_product&id=" . $rows[$i]["itemid"] ?>><?php echo $rows[$i]['name']?></a>
                  </h4>
                  <h5>$<?php echo number_format($rows[$i]['price'], 2, '.', '');?></h5>
                  <p class="card-text" id="description"><?php echo $rows[$i]['description']?></p>
                </div>
                <div class="card-footer">
                  <small class="text-muted">
                      <?php 
                      $rating=(int)$rows[$i]['rating'];
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
                }
                            
                           
              ?>
                    
             
          </div>
          <!-- /.row -->
           <?php     
              echo "<form id='pageform' action = '' method = 'post'>";
            if($currentPage==1)  
               echo "<button id='pageNum' disabled>previous</button>";
            else{
                
               echo "<button name='pageNum' id='pageNum' value='".($currentPage-1)."'>previous</button>";
               
            }
            echo "</form>";
            
            for($i=1;$i<=$pages;$i++){
                echo "<form id='pageform' action = '' method = 'post'>";
                if($i==$currentPage)
                    echo " <button id='pageNum' disabled>".$i."</button>";
                else{
                    echo " <button id='pageNum' name='pageNum' value='".$i."'>".$i."</button>";
                }
                echo "</form>";
            }
            echo "<form id='pageform' action = '' method = 'post'>";
            if($currentPage==$pages)
                echo "<button id='pageNum' disabled>next</button>";
            else{
                echo "<button id='pageNum' name='pageNum' value='".($currentPage+1)."'>next</button>"; 
            }
            echo "</form>";
            ?>
        
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
    <script src="scripts/pages.js"></script>
  </body>

</html>
