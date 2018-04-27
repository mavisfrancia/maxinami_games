<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'databaseConnector.php';
    require_once 'purchaseHistoryDAO.php';
    require_once 'shoppingCartDAO.php';
    require_once 'itemDAO.php';
    require_once 'userDAO.php';
/**
 * Description of PurchaseService
 *
 * @author Nathan
 */
class purchaseService {
    var $connector;
    var $purchaseAccess;
    var $cartAccess;
    var $itemAccess;

    public function __construct() {
        $this->connector=new databaseConnector();
        $this->purchaseAccess=new purchaseHistoryDAO();
        $this->cartAccess=new shoppingCartDAO();
        $this->itemAccess=new itemDAO;
    }
    public function getPurchases($userId){
        try{
            $con=$this->connector->getConnection();
            return $this->purchaseAccess->selectByUser($userId,$con);
        }
        finally {
            $con->close();
        }
    }
    /*
     * the purchase function
     * either returns true if the purchase is made
     */
    public function userPurchase($userID){
        try{
            $con=$this->connector->getConnection();
            $con->autocommit(FALSE);
            $result= $this->cartAccess->selectByUser($userID, $con);
            $record=[];
            if(mysqli_num_rows($result)<1){
                return FALSE;
            }
            while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)){
                array_push($record, $this->purchaseItem($userID, $row["product_id"], $row["quantity"], $con));
            }
            return $this->successfulPurchase($record, $con);
        }
        finally {
            mysqli_free_result($result);
            $con->close();
        }
    }
    public function anonymousPurchase($cart){
        try{
            $con=$this->connector->getConnection();
            $con->autocommit(FALSE);
            $result=(new userDAO())->selectByUsername('anonymous', $con);
            if(mysqli_num_rows($result)>0){
                $id=mysqli_fetch_array($result,MYSQLI_ASSOC)["user_id"];
            }
            $record=[];
            if(count($cart)<1){
                return FALSE;
            }
            foreach ($cart as $key => $value) {
                array_push($record, $this->purchaseItem($id, $key, $value, $con));
            }
            return $this->successfulPurchase($record, $con);
        }
        finally {
            $con->close();
        }
    }
    
    private function purchaseItem($userID,$itemID,$quantity,$con) {
        $name="none";
        $inventory=0;
        $outcome=FALSE;
        $result= $this->itemAccess->selectByID($itemID, $con);
        $num=$this->itemAccess->reduceQuantity($itemID, $quantity, $con);
        $this->cartAccess->deleteCartItem($userID, $itemID, $con);
        if(count($result)==1){
            $name=$result[0]->name;
            $inventory=$result[0]->number;
            if($num>0){
                $this->purchaseAccess->createPurchase($userID,$itemID,$quantity,$con);
                $outcome=TRUE;
            }
        }
        return ["id"=>$itemID, "name"=>$name,"outcome"=>$outcome,"inventory"=>$inventory,"quantity"=>$quantity];
        
    }
    private function successfulPurchase($record,$con) {
        foreach ($record as $value) {
                if(!$value["outcome"]){
                    $con->rollback();
                    return $record; 
                }
        }
        $con->commit();
        return TRUE;
    }
}
