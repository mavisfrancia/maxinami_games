<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author Nathan
 */
class Item {
    var $name;
    var $id;
    var $description;
    var $price;
    var $rating;
    var $imageLink;
    var $number;
    var $type;
    function __construct($id=null,$productName=null,$description=null,$price=0.0,$type=0,$rating=5.0,$inventory=0,$imageLink=null) {
        $this->name=$productName;
        $this->id=$id;
        $this->description=$description;
        $this->imageLink=$imageLink;
        $this->number=$inventory;
        $this->price=$price;
        $this->type=$type;
        $this->rating=$rating;
    }
    
}
