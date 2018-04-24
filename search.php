<?php session_start(); 
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
    <link href="css/search.css" rel="stylesheet">
    <script type="text/javascript">
    function itemsPerPage(val){
        document.getElementById(val).selected = "true";
    }
    </script>
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
                if(isset($_POST['price'])){
                    if($_POST['price']=='0to10'){
                        $min=0;
                        $max=9.99;
                    }
                    elseif($_POST['price']=='10to20'){
                        $min=10;
                        $max=19.99;
                    }
                    elseif($_POST['price']=='20to40'){
                        $min=20;
                        $max=39.99;
                    }
                    elseif($_POST['price']=='40to70'){
                        $min=40;
                        $max=69.99;
                    }
                    elseif($_POST['price']=='70up'){
                        $min=70;
                        $max=PHP_FLOAT_MAX;
                    }
                    include_once 'sort_item.php';
                    $rows= sortByPrice($min, $max, $rows);
                }
                
                if(isset($_POST['rating'])){
                    if($_POST['rating']=='1'){
                        $min=0;
                        $max=1;
                    }
                    elseif($_POST['rating']=='2'){
                        $min=1;
                        $max=2;
                    }
                    elseif($_POST['rating']=='3'){
                        $min=2;
                        $max=3;
                    }
                    elseif($_POST['rating']=='4'){
                        $min=4;
                        $max=5;
                    }
                    elseif($_POST['rating']=='5'){
                        $min=70;
                        $max=PHP_FLOAT_MAX;
                    }
                    include_once 'sort_item.php';
                    $rows= sortByRating($_POST['rating'], $rows);
                }
                ?>
            <form id='priceSort' action = '' method = 'post'>Price Ranges &emsp;&emsp;
                <button name='price' id='price' value='0to10'>&ensp;$0-$9.99 &emsp;</button>
                <button name='price' id='price' value='10to20'>&ensp;$10-$19.99 &emsp;</button>
                <button name='price' id='price' value='20to40'>&ensp;$20-$39.99 &emsp;</button>
                <button name='price' id='price' value='40to70'>&ensp;$40-$69.99 &emsp;</button>
                <button name='price' id='price' value='70up'>&ensp;above $70</button>
            </form>
            <br/>
            <form id='ratingSort' action = '' method = 'post'>Rating &emsp;&emsp;&emsp;&emsp;&emsp;
                <button name='rating' id='rating' value='1'>&ensp;above 1 &emsp;&emsp;&emsp;</button>
                <button name='rating' id='rating' value='2'>&ensp;above 2 &emsp;&emsp;&emsp;</button>
                <button name='rating' id='rating' value='3'>&ensp;above 3 &emsp;&emsp;&emsp;</button>
                <button name='rating' id='rating' value='4'>&ensp;above 4 &emsp;&emsp;&emsp;</button>
                <button name='rating' id='rating' value='5'>&ensp;5</button>
            </form>
            <br/>
                <?php
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
              if(sizeof($rows)==0)
                    echo  "no results found";
                else{
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
                    <select name='perPage' id='perPage' onchange="$('#formid').submit();" >
                        <option id='6' value='6'>6</option>
                        <option id='12' value='12'>12</option>
                        <option id='18' value='18'>18</option>
                        <option id='all' value='all'>all</option>
                     </select> 
                    </form>
                
            <script>itemsPerPage(<?php if($_POST['perPage']=='all') echo "'all'"; else echo $itemsPerPage;?>)</script>
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
                  <small class="<?php echo ($rows[$i]['rating'] > 0 ? 'text-warning' : 'text-muted'); ?>">
                      <?php echo getRatingStarString($rows[$i]['rating']); ?>
                  </small>
                </div>
              </div>
            </div>

              <?php
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
                }
                }
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



    <!-- <script src="scripts/pages.js"></script> -->

  </body>

</html>
