<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['qty'])) {
	$itemid = $_POST['id'];

	// User is logged in, store in session and database
	if (isset($_SESSION['user_name'])) {
		require_once 'databaseConnector.php';
	    require_once 'shoppingCartDAO.php';
	    $db = new databaseConnector();
	    $con = $db->getConnection();
	    $cartDAO = new shoppingCartDAO();
	    
		if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$itemid])) {
			header('Location: cart.php');
		}
		$_SESSION['cart'][$itemid] = $_POST['qty'];
		$cartDAO->updatePurchase($_SESSION['user_id'],$itemid,$_POST['qty'],$con);
		session_write_close();
		echo $_SESSION['cart'][$itemid];

	}
	// User is not logged in, just store in session
	else {
		if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$itemid])) {
			header('Location: cart.php');
		}
		$_SESSION['cart'][$itemid] = $_POST['qty'];
		session_write_close();
		echo $_SESSION['cart'][$itemid];
	}
} else {
	header('Location: cart.php');
}

?>