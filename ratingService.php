<?php
require_once 'ratingDAO';
require_once 'purchaseHistoryDAO';
require_once 'itemDAO';
require_once 'databaseConnector';
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
                $this->ratingAccess->createRating($userID, $itemID, $rating, $description, $con);
                $rating=$this->ratingAccess->getItemAverage($itemID, $con);
                $item= $this->itemAccess->selectByID($itemID, $con);
                $item->rating=$rating;
                $this->itemAccess->updateUsingItem($item, $con);
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
