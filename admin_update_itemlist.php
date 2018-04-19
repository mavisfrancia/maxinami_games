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

	function add_item() {
		// User uploaded a file
		if (is_uploaded_file($_FILES['product-image']['tmp_name'])) {
			echo "file found\n";
			$result = upload_file();
			$success = $result['upload_successful'];
			if ($success) {
				$pictureLink = $result['filename'];
			} else {
				$pictureLink = "_placeholder_image.png";
			}
		} else { // No file was selected
			$pictureLink = "_placeholder_image.png";
		}
		//exit("Picture: " . $pictureLink);

		$name = $_POST['product-name'];
		$type = $_POST['product-type'];
		$description = $_POST['product-description'];
		$inventory = $_POST['product-inventory'];
		$price = $_POST['product-price'];
	    $rating = 0;

	    require_once 'itemService.php';

	    $itemService = new itemService();
	    $itemService->addItem($name,$description,$price,$inventory,$pictureLink,$type,$rating);

	}

	function upload_file() {
		$target_dir = getcwd() . "/imgs/";
		$target_file = $target_dir . basename($_FILES["product-image"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["product-image"]["tmp_name"]);
		    if($check == false) {
		        echo "File is not an image.\n";
		        return array('upload_successful' => false);
		    }
		}
		// If file already exists, append (different) number to end
		while (file_exists($target_file)) {
			// fakepath/imgs/imagefile(2).png
			if (preg_match("/^(.*)\(([0-9]+)\).(png|jpg|jpeg|gif)$/", $target_file, $matches)) {
				$nextnum = (int)$matches[2] + 1;
				$target_file = $matches[1] . "(" . $nextnum . ")." . $matches[3];
			} else { // fakepath/imgs/imagefile.png
				preg_match("/^(.*).(png|jpg|jpeg|gif)$/", $target_file, $matches);
				$target_file = $matches[1] . "(1)." . $matches[2];
			}
		}
		// Check file size
		if ($_FILES["product-image"]["size"] > 500000) {
		    echo "File is too large.\n";
		    return array('upload_successful' => false);
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
		    echo "Unsupported file extension. Only .jpg, .jpeg, .png, and .gif are supported.\n";
			return array('upload_successful' => false);
		}

	    if (move_uploaded_file($_FILES["product-image"]["tmp_name"], $target_file)) {
	        echo "The file " . basename($target_file) . " has been uploaded.\n";
	        return array('upload_successful' => true, 'filename' => basename($target_file));
	    } else {
	        echo "Error uploading file.\n";
	        return array('upload_successful' => false);
	    }
	}

	function update_item() {

		require_once 'itemDAO.php';
	    require_once 'databaseConnector.php';
	    $db = new databaseConnector();
	    $con = $db->getConnection();

	    $itemDAO = new itemDAO();
	    $items = $itemDAO->selectByID($_POST['id'], $con);
	    if (count($items) == 1) {
	    	$pictureLinkLabel=$items[0]->imageLink;
	    	$rating=$items[0]->rating;
	    } elseif (count($items) == 0) {
	    	die("ERROR: ID not found.");
	    } else {
	    	die("ERROR: Duplicate ID found.");
	    }

		// User uploaded a file
		if (is_uploaded_file($_FILES['product-image']['tmp_name'])) {
			echo "file found\n";
			$result = upload_file();
			$success = $result['upload_successful'];
			if ($success) {
				$pictureLink = $result['filename'];
			} else {
				// keep old image
				$pictureLink = $pictureLinkLabel;
			}
		} else { // No file was selected, keep old image
			$pictureLink = $pictureLinkLabel;
		}
		//exit("Picture: " . $pictureLink);

		$name = $_POST['product-name'];
		$type = $_POST['product-type'];
		$description = $_POST['product-description'];
		$description = htmlentities($description);
		$inventory = $_POST['product-inventory'];
		$price = $_POST['product-price'];

	    require_once 'itemService.php';

	    $itemService = new itemService();
	    $itemService->modifyItem($_POST['id'],$name,$description,$price,$inventory,$pictureLink,$type,$rating);
	}

	switch($_POST['action']) {
		case 'update_inventory':
			update_inventory();
			break;
		case 'disable_item':
			disable_item();
			break;
		case 'add_item':
			add_item();
			break;
		case 'update_item':
			update_item();
			break;
		default:
			die("No matching action");
	}

} else {
	die(var_dump($_POST));
}

?>