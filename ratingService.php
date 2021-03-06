<?php
require_once 'ratingDAO.php';
require_once 'purchaseHistoryDAO.php';
require_once 'itemDAO.php';
require_once 'databaseConnector.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ratingService
 *
 * @author Nathan
 */
class ratingService {
    var $ratingAccess;
    var $purchaseAccess;
    var $itemAccess;
    var $connector;
    function __construct() {
        $this->ratingAccess=new ratingDAO();
        $this->purchaseAccess=new purchaseHistoryDAO();
        $this->itemAccess=new itemDAO();
        $this->connector=new databaseConnector();
    }
    function addRating($userID,$itemID,$ratingVal,$comment){
        try{
            $con=$this->connector->getConnection();
            if($this->hasPurchased($userID, $itemID, $con)){
                $this->ratingAccess->createRating($userID, $itemID, $ratingVal, $comment, $con);
                $rating=$this->ratingAccess->getItemAverage($itemID, $con);
                $items= $this->itemAccess->selectByID($itemID, $con);
                if (count($items) == 1) {
                    $items[0]->rating=$rating;
                } else {
                    return FALSE;
                }
                $this->itemAccess->updateUsingItem($items[0], $con);
            }
             else {
                 return FALSE;
             }
        }
        finally{
            $con->close();
        }
    }

    function refreshItemRating($itemID) {
        try{
            $con=$this->connector->getConnection();

            $rating=$this->ratingAccess->getItemAverage($itemID, $con);
            $items= $this->itemAccess->selectByID($itemID, $con);
            if (count($items) == 1) {
                $items[0]->rating=$rating;
            } else {
                return FALSE;
            }
            $this->itemAccess->updateUsingItem($items[0], $con);
        }
        finally{
            $con->close();
        }
    }

    function updateRating($userID,$itemID,$ratingVal,$comment){
        try{
            $con=$this->connector->getConnection();
            if($this->hasPurchased($userID, $itemID, $con)){
                $affected_rows = $this->ratingAccess->updateRating($userID, $itemID, $userID, $itemID, $ratingVal, $comment, $con);
                if ($affected_rows == 1) {
                    $rating=$this->ratingAccess->getItemAverage($itemID, $con);
                    $items= $this->itemAccess->selectByID($itemID, $con);
                    if (count($items) == 1) {
                        $items[0]->rating=$rating;
                    } else {
                        return FALSE;
                    }
                    $this->itemAccess->updateUsingItem($items[0], $con);
                }
                else {
                    return FALSE;
                }
            }
             else {
                 return FALSE;
             }
        }
        finally{
            $con->close();
        }
    }
    private function hasPurchased($userID,$itemID,$con) {
        try{
            $result=$this->purchaseAccess->selectUserItem($userID, $itemID, $con);
            echo(mysqli_num_rows($result));
            if(mysqli_num_rows($result)>0){
                return TRUE;
            }
            return FALSE;
        }
        finally {
            mysqli_free_result($result);    
        }
    }
    function hasReviewed($userID,$itemID,$con) {
        try{
            $result=$this->ratingAccess->selectByUserItem($userID, $itemID, $con);
            if(mysqli_num_rows($result)>0){
                return TRUE;
            }
            return FALSE;
        }
        finally {
            mysqli_free_result($result);    
        }
    }
    function getRatings($userID){
        $con= $this->connector->getConnection();
        $result=$this->ratingAccess->selectByUser($userID, $con);
        $con->close();
       return $result;
    }
}
