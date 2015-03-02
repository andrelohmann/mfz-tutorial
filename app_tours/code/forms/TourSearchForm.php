<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TourSearchForm extends BootstrapHorizontalModalForm {
    
    static public $hours_diff = array('1' => '+/- 1', '3' => '+/- 3', '6' => '+/- 6', '12' => '+/- 12', '24' => '+/- 24');
    static public $radius = array('1' => '1 KM', '5' => '5 KM', '10' => '10 KM', '20' => '20 KM', '50' => '50 KM', '100' => '100 KM');
    static public $default_diff = 3;
    static public $default_radius = 5;
 
    public function __construct($controller, $name, $fields = null, $actions = null) {
        
        $fields = new FieldList(
            $StartDate = BootstrapDatetimepickerField::create('StartDate')->setTitle(_t('Tour.STARTDATE','Tour.STARTDATE'))->setValue((Session::get('TourSearch.StartDate') ? Session::get('TourSearch.StartDate') : time())),
            $StartDateDiff = DropdownField::create('StartDateDiff')->setTitle(_t('Tour.STARTDATEDIFF','Tour.STARTDATEDIFF'))->setSource(self::$hours_diff)->setValue((Session::get('TourSearch.StartDateDiff') ? Session::get('TourSearch.StartDateDiff') : self::$default_diff)),
            $Start = BootstrapGeoLocationField::create('Start')->setTitle(_t('Tour.START','Tour.START')),
            $StartRadius = DropdownField::create('StartRadius')->setTitle(_t('Tour.STARTRADIUS','Tour.STARTRADIUS'))->setSource(self::$radius)->setValue((Session::get('TourSearch.StartRadius') ? Session::get('TourSearch.StartRadius') : self::$default_radius)),
            $Goal = BootstrapGeoLocationField::create('Goal')->setTitle(_t('Tour.GOAL','Tour.GOAL')),
            $GoalRadius = DropdownField::create('GoalRadius')->setTitle(_t('Tour.GOALRADIUS','Tour.GOALRADIUS'))->setSource(self::$radius)->setValue((Session::get('TourSearch.GoalRadius') ? Session::get('TourSearch.GoalRadius') : self::$default_radius))
        );
        
        $StartDate->setRightTitle(_t('Tour.STARTDATEDESCRIPTION','Tour.STARTDATEDESCRIPTION'))->addExtraClass('input-lg');
        $StartDateDiff->addExtraClass('input-lg');
        $Start->setRightTitle(_t('Tour.STARTDESCRIPTION','Tour.STARTDESCRIPTION'))->addExtraClass('input-lg')->setValue(Session::get('TourSearch.Start'));
        $StartRadius->addExtraClass('input-lg');
        $Goal->setRightTitle(_t('Tour.GOALDESCRIPTION','Tour.GOALDESCRIPTION'))->addExtraClass('input-lg')->setValue(Session::get('TourSearch.Goal'));
        $GoalRadius->addExtraClass('input-lg');
        
        
        $actions = new FieldList(
            $Search = BootstrapLoadingFormAction::create('doSearch')->setButtonContent('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>')
        );
        
        $Search->addExtraClass('btn-info btn-lg btn-block');
        
        $ModalOpenButton = BootstrapModalFormAction::create('openModal')->setButtonContent($Title = '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>');
        $ModalOpenButton->addExtraClass('btn-primary btn-lg btn-block');
         
        parent::__construct(
            $controller,
            $name,
            $fields,
            $actions,
            new RequiredFields(
                "StartDate",
                "StartDateDiff",
                "Start",
                "StartRadius",
                "Goal",
                "GoalRadius"
            ),
            $title = _t('Tour.SEARCHMODALTITLE','Tour.SEARCHMODALTITLE'),
            $ModalOpenButton
        );
    }
    
    public function doSearch(array $data) {
        
        Session::set('TourSearch.StartDate', $this->Fields()->dataFieldByName('StartDate')->dataValue());
        Session::set('TourSearch.StartDateDiff', $data['StartDateDiff']);
        Session::set('TourSearch.Start', $data['Start']);
        Session::set('TourSearch.StartRadius', $data['StartRadius']);
        Session::set('TourSearch.Goal', $data['Goal']);
        Session::set('TourSearch.GoalRadius', $data['GoalRadius']);
        
        $this->controller->redirect('tour/search');
    }
}