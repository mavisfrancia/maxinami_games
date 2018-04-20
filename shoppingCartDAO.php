<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shoppingCartDAO
 *
 * @author Nathan
 */
class shoppingCartDAO {
    private $createSQL="INSERT INTO shopping_cart (user_id,product_id,quantity) VALUES (?,?,?)";
    private $selectByUserSQL="SELECT * FROM shopping_cart WHERE user_id=?";
    private $selectByUserItemSQL="SELECT * FROM shopping_cart WHERE user_id=? AND product_id=?";
    private $updateSQL="UPDATE shopping_cart SET quantity=? WHERE user_id=? AND product_id=?";
    private $deleteSQL="DELETE FROM shopping_cart WHERE user_id=? AND product_id=?";
    function createCartItem($userID,$itemID,$quantity,$con) {
        $statement=mysqli_prepare($con, $this->createSQL);
        $statement->bind_param("iii",$userID,$itemID,$quantity);
        $statement->execute();
        $num=$statement->affected_rows;
        $statement->close();
        return $num;
    }
    function selectByUserAndItem($userId,$itemID,$con){
        $statement= mysqli_prepare($con, $this->selectByUserItemSQL);
        $statement->bind_param("ii", $userId,$itemID);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        return $result;
        
    }
    function selectByUser($userId,$con){
        $statement= mysqli_prepare($con, $this->selectByUserSQL);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        return $result;
        
    }
    
    function deleteCartItem($userId,$productId,$con){
        $statement= mysqli_prepare($con, $this->deleteSQL);
        $statement->bind_param("ii", $userId,$productId);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
        
    }
    
    function updatePurchase($userID,$itemID,$quantity,$con) {
        $statement=mysqli_prepare($con, $this->updateSQL);
        $statement->bind_param("iii",$quantity,$userID,$itemID);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
    }
    
}
