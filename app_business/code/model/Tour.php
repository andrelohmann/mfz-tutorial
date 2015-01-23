<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tour extends DataObject {
    
    private static $db = array(
        "StartDate" => "SS_Datetime",
        "Start" => "GeoLocation",
        "Goal" => "GeoLocation"
    );
    
    private static $has_one = array();
    
    private static $has_many = array();
    
    private static $many_many = array();
    
    private static $belongs_many_many = array();
    
}