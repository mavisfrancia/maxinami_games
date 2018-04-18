<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of databaseConnector
 *
 * @author Nathan
 */
class databaseConnector {
    //put your code here
    function getConnection() {
        require_once 'config.php';
        return new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_SCHEMA);
        
    }
}
