<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of ItemQuery
 *
 * @author Nathan
 */
class ItemQuery {
    var $types;
    var $price;
    var $strings;
    var $order;
    var $minQuantity;
    var $ratingMin;
    const boardgame=1;
    const videogame=2;
    const cardgame=3;
    const giftcard=4;
    const price="price";
    const quantity="inventory";
    const rating="rating";
    const asc="ASC";
    const desc="DESC";
    const all="%all%";

    function __construct($queryString) {
        $this->types=[];
        $this->price=["max"=>0,"min"=>INF];
        $this->strings=[];
        $this->order=["orderValue"=>ItemQuery::quantity,"direction"=> ItemQuery::desc];
        $this->minQuantity=1;
        $this->ratingMin=0;
        if(is_string($queryString)){
            
            $parts= preg_split("/[\s,]+/", $queryString);
            for($i=0;$i<count($parts);$i++){
                $i+= $this->process($parts,$i);
            }
        }
        
    }
    function createSQL(){
        $s="";
        $s.=$this->typeSQL();
        $s.=" AND inventory >= \"".$this->minQuantity."\"";
        $s.=" AND rating >= \"". $this->ratingMin."\"";
        $s.= $this->priceSQL();
        foreach ($this->strings as $value){
            $s.=" AND (name LIKE \"%".$value."%\" OR description LIKE \"%".$value."%\")";
        }
        $s.=" ORDER BY ".$this->order["orderValue"]." ".$this->order["direction"];
        return $s;
    }
    private function typeSQL(){
        $s="";
        for($i=0;$i<count($this->types);$i++){
            if($i==0){
                $s.=" AND (";
            }
            else{
                $s.=" OR";
            }  
            $s.=" type = '".$this->types[$i]."'";
        }
        if(count($this->types)>0){
            $s.=")";
        }
        return $s;
    }
    private function priceSQL(){
        if(!$this->price["max"]<$this->price["min"]){
            $s=" AND price BETWEEN ";
            if($this->price["max"]== $this->price["min"]){
                $s.="".($this->price["max"]-5)." AND ".($this->price["max"]+5);
            }else {
                $s.="".$this->price["min"]." AND ".$this->price["max"];
            }
            return $s;
        }
        return "";
    }

     function process($queryParts,$index){
         
        if(strstr($queryParts[$index],"$")!==FALSE&&empty(strstr($queryParts[$index], "$", TRUE))){
            $this->addPrice($queryParts, $index);
            
        }elseif (strcmp($queryParts[$index],"%rtd")==0) {
            return $this->changeRating($queryParts, $index);

        }elseif (strcmp($queryParts[$index],"%ordr")==0) {
            return $this->changeOrder($queryParts, $index);
        }elseif (strcmp($queryParts[$index],"%cardgame")==0|| strcmp($queryParts[$index], "%boardgame") == 0||strcmp($queryParts[$index],"%videogame")==0||strcmp($queryParts[$index],"%giftcard")==0) {
            $this->addType($queryParts[$index]);
            //$index==0&&
        }elseif (strcmp($queryParts[$index], ItemQuery::all)==0) {
            
            return $this->allSearch($queryParts,$index);
        }
        else{
            $this->addString($queryParts[$index]);
            
        }
        return 0;
    }
    private function allSearch($queryParts,$index){
        $this->minQuantity=0;
        for($i=$index+1;$i<count($queryParts);$i++){
            if(strcmp($queryParts[$index],"ordr")==0) {
                $this->changeOrder($queryParts, $index);
                $i= count($queryParts);
            }
        }
        return $i;
    }
    private function changeOrder($queryParts,$index){
        if(count($queryParts)>$index+1){
            $goodOrder= $this->changeOrderCategory($queryParts[$index+1]);
            if($goodOrder>0&& count($queryParts)>$index+2){
                $goodOrder+= $this->changeOrderDirection($queryParts[$index+2]);
            }
            return $goodOrder;
        }
        return 0;
    }
    private function changeOrderCategory($category){
        if(strcmp($category, ItemQuery::price)==0){
            $this->order["orderValue"]= ItemQuery::price;
            return 1;
        }
        if(strcmp($category, ItemQuery::quantity)==0){
            $this->order["orderValue"]= ItemQuery::quantity;
            return 1;
        }
        if(strcmp($category, ItemQuery::rating)==0){
            $this->order["orderValue"]= ItemQuery::rating;
            return 1;
        }
        return 0;
    }
    private function changeOrderDirection($direction){
        if(strcmp($direction, "asc")==0){
            $this->order["direction"]= ItemQuery::asc;
            return 1;
        }
        if(strcmp($direction, "desc")==0){
            $this->order["direction"]= ItemQuery::desc;
            return 1;
        }
        return 0;
    }
    private function addString($searchItem){
        array_push($this->strings,$searchItem);
    }
    private function addType($type) {
        $typeval= ItemQuery::boardgame;
        switch ($type){
            case "%videogame":{
                $typeval= ItemQuery::videogame;
                break;
            }
            case "%cardgame":{
                $typeval= ItemQuery::cardgame;
                break;
            }
            case "%giftcard" :
                $typeval= ItemQuery::giftcard;
        }
        array_push($this->types,$typeval);
    }
    private function addPrice($queryParts,$index) {
        preg_match("/[\d]+(\.[\d]+)?/", $queryParts[$index], $matches);
        foreach ($matches as $value){
            $this->price["min"]= min($value, $this->price["min"]);
            $this->price["max"]= max($value, $this->price["max"]);
        }
    }
    private function changeRating($queryParts,$index){
        if(count($queryParts)>$index+1){
            preg_match("/[\d]+(\.[\d]+)?/", $queryParts[$index+1], $matches);
            foreach ($matches as $value){
                
                $this->ratingMin= max($value, $this->ratingMin);
            }
            return 1;
        }
        return 0;
    }
}
