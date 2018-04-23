<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'databaseConnector.php';
require_once 'shoppingCartDAO.php';
/**
 * Description of cartService
 *
 * @author Nathan
 */
class cartService {
    var $connector;
    var $cartAccess;
    public function __construct() {
        $this->connector=new databaseConnector();
        $this->cartAccess=new shoppingCartDAO();
    }
    public function addItem($userID,$itemID,$quantity){
        try{
            $con=$this->connector->getConnection();
            $num= $this->addCartItem($userID, $itemID, $quantity, $con);
            if($num==1){
                $con->commit();
            }
            else{
                $con->rollback();
                return 0;
            }
            return $num;
        }
        finally {
            $con->close();
        }
    }
    public function getCart($userID){
        try{
            $con=$this->connector->getConnection();
            return $this->cartAccess->selectByUser($userID, $con);
        }
        finally {
            $con->close();
        }
    }
    public function updateItem($userID,$itemID,$quantity) {
        try{
            $con=$this->connector->getConnection();
            $con->begin_transaction();
            $quantities= $this->changeQuantity($userID, $itemID, $quantity, $con);
            $newQuantity=min([$quantities[2],$quantity]);
            $num= $this->updateCartItem($userID, $itemID, $newQuantity, $con);
            if($num==1){
                $con->commit();
            }
             else {
                 $con->rollback();
                 return 0;
             }
             return $num;
        }
        finally {
            $con->close();
        }
    }
    private function updateCartItem($userID,$itemID,$quantity,$con) {
        $num= $this->cartAccess->updatePurchase($userID, $itemID, $quantity, $con);
        return $num;
    }
    private function addCartItem($userID,$itemID,$quantity,$con) {
            $quantities= $this->changeQuantity($userID, $itemID, $quantity, $con);
            if($quantities[0]>0){
                $this->cartAccess->deleteCartItem($userID, $itemID, $con);
                return 1;
            }
            elseif ($quantities[1]==0) {
                $num= $this->cartAccess->createCartItem($userID, $itemID, $quantities[0], $con);
            }
             else {
                $num= $this->updateCartItem($userID, $itemID, $quantities[0], $con);
             }
            
            return $num;
    }
    private function getQuantity($userID, $itemID, $con){
            $result=$this->cartAccess->selectByUserAndItem($userID, $itemID, $con);
            if(mysqli_num_rows($result)==0){
                mysqli_free_result($result);
                return 0;
            }
            $Currquantity=0;
            while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $Currquantity+=$row["quantity"];
            }
            mysqli_free_result($result);
            return $Currquantity;
    }
    private function changeQuantity($userID,$itemID,$quantity,$con){
        require_once 'itemDAO.php';
        $existing= $this->getQuantity($userID, $itemID, $con);
        $result= (new itemDAO())->selectByID($itemID, $con);
        if(count($result)==1){
            $inventoryBound= $result[0]->number;
        }
        $newQuantity=min([$quantity+$existing,$inventoryBound]);
        return [$newQuantity,$existing,$inventoryBound];
    }
    public function moveCartToUser($userID,$cart){
        if(is_array($cart)){
            $con= $this->connector->getConnection();
            foreach ($cart as $key => $value) {
                $this->addCartItem($userID, $key, $value, $con);
            }
            return TRUE;
        }
        return FALSE;
    }
    public function removeItem($userID,$itemID){
        $con= $this->connector->getConnection();
        $con->begin_transaction();
        $num= $this->cartAccess->deleteCartItem($userID, $itemID, $con);
        if($num!=1){
            $con->rollback();
            return FALSE;
        }
        $con->commit();
        return TRUE;
    }
}
