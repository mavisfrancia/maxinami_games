<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

	function update_inventory() {
		if(isset($_POST['id']) && isset($_POST['inventory'])) {
			$itemid = $_POST['id'];

			// User is logged in as admin, proceed
			if (isset($_SESSION['user_name']) && $_SESSION['user_status'] == 0) {
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
		}
	}

	function disable_item() {
		// User is logged in as admin, proceed
		if (isset($_SESSION['user_name']) && $_SESSION['user_status'] == 0) {
			if(isset($_POST['id'])) {
				$itemid = $_POST['id'];
				require_once 'itemService.php';
			    $itemService = new itemService();
			    $itemService->makeInactive($itemid);
				exit("Disabled item " . $itemid);
			} else {
				die("Error");
			}
		} else {
			die("Not logged in!");
		}
	}

	switch($_POST['action']) {
		case 'update_inventory':
			update_inventory();
			break;
		case 'disable_item':
			disable_item();
			break;
		default:
			die("No matching action");
	}

} else {
	die("Error");
}

?>