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
    
    public function getStartDistance(){
        
        if(Session::get('TourSearch.Start')){
            return round(GeoFunctions::getDistance(Session::get('TourSearch.Start')['Latitude'], Session::get('TourSearch.Start')['Longditude'], $this->obj('Start')->getLatitude(), $this->obj('Start')->getLongditude())).' km';
        }
    }
    
    public function getGoalDistance(){
        
        if(Session::get('TourSearch.Goal')){
            return round(GeoFunctions::getDistance(Session::get('TourSearch.Goal')['Latitude'], Session::get('TourSearch.Goal')['Longditude'], $this->obj('Goal')->getLatitude(), $this->obj('Goal')->getLongditude())).' km';
        }
    }
    
}