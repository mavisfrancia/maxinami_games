<?php

require_once 'databaseConnector.php';
require_once 'itemDAO.php';
require_once 'ItemQuery.php';

/**
 * Description of itemService
 *TODO queryItem
 * @author Nathan
 */
class itemService {
    var $connector;
    var $itemAccess;
    public function __construct() {
        $this->connector=new databaseConnector();
        $this->itemAccess=new itemDAO();
    }
    function addItem($name,$description,$price,$inventory,$pictureLink,$type,$rating){
        try{
            $con= $this->connector->getConnection();
            return $this->itemAccess->createItem($name,$description,$price,$inventory,$pictureLink,$type,$rating, $con);
        }
        finally {
            $con->close();
        }
    }
    function searchItem($queryString){
        try{
        $con=$this->connector->getConnection();
        $itemQuery= new ItemQuery(mysqli_real_escape_string($con,$queryString));
        return $this->itemAccess->selectByQuery($itemQuery, $con);
        }
        finally{
            $con->close();
        }
    }
    function makeInactive($id){
        try{
            $con= $this->connector->getConnection();
            $con->begin_transaction();
            $result=$this->itemAccess->selectByID($id, $con);
            if(count($result)==1){
                $item=$result[0];
                $item->type=0;
                $number= $this->itemAccess->updateUsingItem($item, $con);
                $this->determineAction($number, $con);
            }
            return false;
        }
        finally {
            mysqli_free_result($result);
            $con->close();
        }
    }
    function adjustInventory($id,$quantity){
        try{
            $con= $this->connector->getConnection();
            $con->begin_transaction();
            $result=$this->itemAccess->selectByID($id, $con);
            if(count($result)==1){
                $item=$result[0];
                $item->quantity+=$quantity;
                $number= $this->itemAccess->updateUsingItem($item, $con);
                return $this->determineAction($number, $con);
            }
            return false;
        }
        finally {
            mysqli_free_result($result);
            $con->close();
        }
    }
    function modifyItem($id,$name,$description,$price,$inventory,$pictureLink,$type,$rating){
        try{
            $con= $this->connector->getConnection();
        $item=new Item($id,$name,$description,$price,$type,$rating,$inventory,$pictureLink);
        $con->begin();
        $number= $this->itemAccess->updateUsingItem($item, $con);
        return $this->determineAction($number, $con);      
        }
         finally {
             $con->close();
        }
    }
    function deleteItem($id){
        try{
            $con= $this->connector->getConnection();
            $con->begin();
            $number= $this->itemAccess->deleteItem($id, $con);
            return $this->determineAction($number, $con);      
        }
         finally {
             $con->close();
        }
    }

    private function determineAction($number,$con){
        if(!is_int($number)||$number!=1){
            $con->rollback();
            return false;
        }
        else{
            $con->commit();
            return true;
        }
    }
    
}
