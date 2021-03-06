<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of purchaseHistoryDAO
 *
 * @author Nathan
 */
class purchaseHistoryDAO {
    private $createSQL="INSERT INTO purchase_history (user_id,product_id,quantity,time_of_purchase) VALUES (?,?,?,?)";
    private $selectByUserSQL="SELECT * FROM purchase_history WHERE user_id=? ORDER_BY (time_of_purchase) DESC";
    private $selectByUserItemSQL="SELECT * FROM purchase_history WHERE product_id=? AND user_id=?";
    private $selectByItemSQL="SELECT * FROM purchase_history WHERE product_id=?";
    private $updateSQL="UPDATE purchase_history SET user_id=?,product_id=?,quantity=?,time_of_purchase=? WHERE user_id=? AND product_id=?";
    private $deleteSQL="DELETE FROM purchase_history WHERE user_id=? AND product_id=? AND time_of_purchase=?";
    function createPurchase($userID,$itemID,$quantity,$con) {
        $statement=mysqli_prepare($con, $this->createSQL);
        $time = time();
        $mysqltime = date("Y-m-d H:i:s", $time);
        $statement->bind_param("iiis",$userID,$itemID,$quantity, $mysqltime);
        $statement->execute();
        $statement->close();
    }
    
    function selectByUser($userId,$con){
        $statement= mysqli_prepare($con, $this->selectByUserSQL);
        $statement->bind_param("i", $userId);
        $statement->bind_result($result);
        $statement->execute();
        $statement->close();
        return $result;
        
    }
    function selectByItem($itemId,$con){
        $statement= mysqli_prepare($con, $this->selectByItemSQL);
        $statement->bind_param("i", $itemId);
        $statement->bind_result($result);
        $statement->execute();
        $statement->close();
        return $result;
    }
    function selectUserItem($userId,$itemId,$con){
        $statement= mysqli_prepare($con, $this->selectByUserItemSQL);
        $statement->bind_param("ii", $itemId,$userId);
        // $statement->bind_result($result);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        return $result;
    }
    function deletePurchase($userId,$productId,$con){
        $statement= mysqli_prepare($con, $this->deleteSQL);
        $statement->bind_param("ii", $userId,$productId);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
        
    }
    
    function updatePurchase($userID,$itemID,$oldTimestamp,$newUserId,$newItemId,$quantity,$timestamp,$con) {
        $statement=mysqli_prepare($con, $this->updateSQL);
        $statement->bind_param("iiisiis",$newUserId,$newItemId,$quantity,$timestamp,$userID,$itemID,$oldTimestamp);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
    }
}
