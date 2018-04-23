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
            echo("here");
            $con=$this->connector->getConnection();
            if($this->hasPurchased($userID, $itemID, $con)){
                echo("purchased");
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
    function getRatings($userID){
        $con= $this->connector->getConnection();
        $result=$this->ratingAccess->selectByUser($userId, $con);
        $con->close();
       return $result;
    }
}
