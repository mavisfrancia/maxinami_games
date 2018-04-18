<?php
/**
 * Description of ratingDAO
 *
 * @author Nathan
 */
class ratingDAO {
    private $createSQL="INSERT INTO user_rating (user_id,product_id,rating,description) VALUES (?,?,?,?)";
    private $selectByUserSQL="SELECT * FROM user_rating WHERE user_id=?";
    private $selectByItemSQL="SELECT * FROM user_rating WHERE product_id=?";
    private $updateSQL="UPDATE user_rating SET user_id=?,product_id=?,rating=?,description=? WHERE user_id=? AND product_id=?";
    private $deleteSQL="DELETE FROM user_rating WHERE user_id=? AND product_id=?";
    function createPurchase($userID,$itemID,$rating,$description,$con) {
        $statement=mysqli_prepare($con, $this->createSQL);
        $statement->bind_param("iids",$userID,$itemID,$rating,$description);
        $statement->execute();
        $statement->close();
        return $id;
    }
    
    function selectByUser($userId,$con){
        $statement= mysqli_prepare($con, $this->selectByUserSQL);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        return $result;
        
    }
    function selectByItem($itemId,$con){
        $statement= mysqli_prepare($con, $this->selectByItemSQL);
        $statement->bind_param("i", $itemId);
        $statement->execute();
        $result=$statement->get_result();
        $statement->close();
        return $result;
    }
    function deleteRating($userId,$productId,$con){
        $statement= mysqli_prepare($con, $this->deleteSQL);
        $statement->bind_param("ii", $userId,$productId);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
        
    }
    
    function updateRating($userID,$itemID,$newUserId,$newItemId,$rating,$description,$con) {
        $statement=mysqli_prepare($con, $this->updateSQL);
        $statement->bind_param("iidsii",$newUserId,$newItemId,$rating,$description,$userID,$itemID);
        $statement->execute();
        $result=$statement->affected_rows;
        $statement->close();
        return $result;
    }
}
