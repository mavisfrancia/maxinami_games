<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
	
	$itemid = $_POST['id'];
	
	// User is logged in, store in session and database
	if (isset($_SESSION['user_name'])) {
		// If user is logged in, store cart items in database
	    require_once 'cartService.php';
	    $cartService = new cartService();

	    if (!isset($_SESSION['cart'])) { // create cart if not created yet
			$_SESSION['cart'] = [];
		}
		if (!isset($_SESSION['cart'][$itemid]) || $_SESSION['cart'][$itemid] == 0) { // create entry for item in cart if not created yet
			$_SESSION['cart'][$itemid] = 1;
			// also create entry in database
			$cartService->addItem($_SESSION['user_id'], $itemid, 1);
		}
		else {
			// update quantity of item in cart and database
			$_SESSION['cart'][$itemid] += 1;
			$cartService->updateItem($_SESSION['user_id'], $itemid, $_SESSION['cart'][$itemid]);
		}
		session_write_close();
		
		//var_dump($_SESSION['cart']);

		//header('Location: product.php?id=' . $itemid);

	}
	// User is not logged in, just store in session
	else {

		if (!isset($_SESSION['cart'])) { // create cart if not created yet
			$_SESSION['cart'] = [];
		}
		if (!isset($_SESSION['cart'][$itemid])) { // create entry for item in cart if not created yet
			$_SESSION['cart'][$itemid] = 0;
		}
		$_SESSION['cart'][$itemid] += 1;
		session_write_close();
		//var_dump($_SESSION['cart']);

		header('Location: product.php?id=' . $itemid);

	}


} else {
	header('Location: cart.php');
}

?>