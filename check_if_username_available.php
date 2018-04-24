<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if(isset($_POST['username'])) {
		require_once 'userDAO.php';
		require_once 'databaseConnector.php';
		$userDAO = new userDAO();
		$db = new databaseConnector();
		$con = $db->getConnection();

		$result = $userDAO->selectByUsername($_POST['username'],$con);
		if (mysqli_num_rows($result) == 0)
			exit("true");
		else
			exit("false");

	} else {
		exit("false");
	}

} else {
	exit("false");
}

?>