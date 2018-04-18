<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
	$itemid = $_POST['id'];

	if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$itemid])) {
		header('Location: cart.php');
	}

	// User is logged in, remove from session and database
	if (isset($_SESSION['user_name'])) {
		require_once 'databaseConnector.php';
	    require_once 'shoppingCartDAO.php';
	    $db = new databaseConnector();
	    $con = $db->getConnection();
	    $cartDAO = new shoppingCartDAO();

		unset($_SESSION['cart'][$itemid]);
		$cartDAO->deleteCartItem($_SESSION['user_id'],$itemid,$con);
		session_write_close();
		//var_dump($_SESSION['cart']);
		header('Location: cart.php');
	}
	// User is not logged in, just remove from session
	else {
		unset($_SESSION['cart'][$itemid]);
		session_write_close();
		//var_dump($_SESSION['cart']);
		header('Location: cart.php');
	}
} else {
	header('Location: cart.php');
}

?>