<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['inventory'])) {
	$itemid = $_POST['id'];

	// User is logged in, store in session and database
	if (isset($_SESSION['user_name'])) {
		$inventory = (int)$_POST['inventory'];

		if ($inventory >= 0) {
			require_once 'itemService.php';
		    $itemService = new itemService();
		    $itemService->adjustInventory($itemid, $inventory);
		    exit();
		}
		die("Invalid inventory value");

	}
	// User is not logged in, can't perform action
	else {
		die("Not logged in!");
	}
} else {
	die("Error");
}

?>