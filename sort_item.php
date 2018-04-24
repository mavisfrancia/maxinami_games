<?php

function sortByPrice($minPrice,$maxPrice,$array){
    $sortedArray=array();
    for($i=0;$i<sizeof($array);$i++){
        if($array[$i]['price']>=$minPrice&&$array[$i]['price']<=$maxPrice)
           $sortedArray[]=($array[$i]);
    }
    return $sortedArray;
}

function sortByRating($minRating,$array){
    $sortedArray=array();
    for($i=0;$i<sizeof($array);$i++){
        if($array[$i]['rating']>=$minRating)
            $sortedArray[]=($array[$i]);
    }
    return $sortedArray;
}
?>
