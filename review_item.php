<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

	function add_review() {
		if(!isset($_POST['id']) ||
			!isset($_POST['rating']) ||
			!isset($_POST['description']) )
		{
			die("Error adding review.");
		}

		$userID = $_SESSION['user_id'];
		$itemID = $_POST['id'];
		$ratingVal = $_POST['rating'];
		$comment = htmlentities($_POST['description']);

		require_once 'ratingService.php';
		$ratingService = new ratingService();

		$ratingService->addRating($userID,$itemID,$ratingVal,$comment);

		exit("UID: $userID IID: $itemID R: $ratingVal C: $comment");

	}

	if ($_POST['action'] == 'add_review')
		add_review();
	else
		die();


} else {
	die();
}








?>