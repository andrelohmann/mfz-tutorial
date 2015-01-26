<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TourAddSearchForm extends BootstrapHorizontalForm {
 
    public function __construct($controller, $name, $fields = null, $actions = null) {
        
        $fields = new FieldList(
            $StartDate = BootstrapDatetimepickerField::create('StartDate')->setTitle(_t('Tour.STARTDATE','Tour.STARTDATE'))->setValue(time()),
            $Start = BootstrapGeoLocationField::create('Start')->setTitle(_t('Tour.START','Tour.START')),
            $Goal = BootstrapGeoLocationField::create('Goal')->setTitle(_t('Tour.GOAL','Tour.GOAL'))
        );
        
        $StartDate->setRightTitle(_t('Tour.STARTDATEDESCRIPTION','Tour.STARTDATEDESCRIPTION'))->addExtraClass('input-lg');
        $Start->setRightTitle(_t('Tour.STARTDESCRIPTION','Tour.STARTDESCRIPTION'))->addExtraClass('input-lg');
        $Goal->setRightTitle(_t('Tour.GOALDESCRIPTION','Tour.GOALDESCRIPTION'))->addExtraClass('input-lg');
        
        $actions = new FieldList(
            $Search = BootstrapLoadingFormAction::create('doSearch')->setTitle('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>'),
            $Add = BootstrapLoadingFormAction::create('doAdd')->setTitle('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>')
        );
        
        $Search->addExtraClass('btn-info btn-lg btn-block');
        
        $Add->addExtraClass('btn-success btn-lg btn-block');
         
        parent::__construct(
            $controller,
            $name,
            $fields,
            $actions,
            new RequiredFields(
                "StartDate",
                "Start",
                "Goal"
            )
        );
    }
    
    public function doSearch(array $data) {
        
        Session::set('TourSearch.StartDate', $this->Fields()->dataFieldByName('StartDate')->dataValue());
        Session::set('TourSearch.Start', $data['Start']);
        Session::set('TourSearch.Goal', $data['Goal']);
        
        $this->controller->redirect('tour/search');
    }
    
    public function doAdd(array $data) {
        
        $Tour = Tour::create();
        $this->saveInto($Tour);
        $Tour->write();
        
        $this->sessionMessage(_t('TourAddSearchForm.ADDSUCCESS', 'TourAddSearchForm.ADDSUCCESS'), 'good');
        
        $this->controller->redirectBack();
    }
}