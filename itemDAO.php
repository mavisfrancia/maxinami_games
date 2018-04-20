<?php
require_once 'Item.php';
require_once 'ItemQuery.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of itemDAO
 *  TODO Select by QueryItem
 * @author Nathan
 */
class itemDAO {
    private $createSQL="INSERT INTO items (name,description,price,inventory,pictureLink,type,rating) VALUES (?,?,?,?,?,?,?)";
    private $selectByIdSQL="SELECT * FROM items WHERE itemid=?";
    private $updateSQL="UPDATE items SET name=?,description=?,price=?,inventory=?,pictureLink=?,type=?,rating=? WHERE itemid=?";
    private $deleteSQL="DELETE FROM items WHERE itemid=?";
    private $searchSQL='SELECT * FROM items WHERE type > "0"';
    private $reduceQuantitySQL="UPDATE items SET inventory=inventory-? WHERE itemid=? AND inventory>?";
            function createItem($name,$description,$price,$inventory,$pictureLink,$type,$rating,$con) {
        $statement=mysqli_prepare($con, $this->createSQL);
        $statement->bind_param("ssdisid",$name,$description,$price,$inventory,$pictureLink,$type,$rating );
        $statement->execute();
        $id=$statement->insert_id;
        $statement->close();
        return $id;
    }
    
    function selectByID($id,$con){
        $statement= mysqli_prepare($con, $this->selectByIdSQL);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result=$statement->get_result();
        $items=[];
        if(mysqli_num_rows($result)>0){
                while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)){
                     $name=$row["name"];
                     $price=$row["price"];
                     $description=$row["description"];
                     $inventory=$row["inventory"];
                     $type=$row["type"];
                     $pictureLink=$row["pictureLink"];
                     $rating=$row["rating"];
                     array_push($items,new Item($id,$name,$description,$price,$type,$rating,$inventory,$pictureLink));
                 }
                 
            }
        $statement->close();
        return $items;
        
    }
    function selectByQuery($itemQuery,$con){
        if($itemQuery instanceof ItemQuery){
            $query= $this->searchSQL.$itemQuery->createSQL();
            $result=mysqli_query($con, $query);
            return $result;
        }
    }
            function deleteItem($id,$con){
        $statement= mysqli_prepare($con, $this->deleteSQL);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
        
    }
    
    function updateItem($id,$name,$description,$price,$inventory,$pictureLink,$type,$rating,$con) {
        $statement=mysqli_prepare($con, $this->updateSQL);
        $statement->bind_param("ssdisidi",$name,$description,$price,$inventory,$pictureLink,$type,$rating,$id);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
    }
    function updateUsingItem($item,$con){
        if(is_a($item, "Item")){
            return updateItem($item->id, $item->name, $item->description, $item->price, $item->inventory, $item->pictureLink, 0, $item->rating, $con);
        }
        return 0;
    }
    function reduceQuantity($id,$quantity,$con){
        $statement= mysqli_prepare($con, $this->reduceQuantitySQL);
        $statement->bind_param("iii", $quantity,$id,$quantity);
        $statement->execute();
        $result=$statement->affected_rows;
        return $result;
    }
}
