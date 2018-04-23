<?php

class pages{
    private $currentPage =1;
    private $perPage = 6;
    private $arraySize = 0;
    private $pages = 1;
    
    function setItemsPerPage($argument){
        $this->perPage = $argument;
    }
    function getItemsPerPage(){
        return $this->perPage;
    }
    function setArraySize($argument){
        $this->arraySize = $argument;
    }
    
    function setPages(){
        $this->pages = ceil($this->arraySize/$this->perPage);
        return $this->pages;
    }
    function setCurrentPage($argument){
        $this->currentPage=$argument;
    }
    function getCurrentPage(){
        return $this->currentPage;
    }
 
}



?>
