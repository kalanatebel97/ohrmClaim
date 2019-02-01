<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 26/12/18
 * Time: 1:45 PM
 */

class CreateEventForm extends sfForm {


    public function configure() {

        $this->setWidgets(array(
            'id'=> new sfWidgetFormInputHidden(),
            'name'=> new sfWidgetFormInput(),
            'description' => new sfWidgetFormTextarea()
        ));

        $this->setValidators(array(
            'id'=> new sfValidatorInteger(array('required' =>false)),
            'name'=> new sfValidatorString(array('required' => true,'max_length'=> 255)),
            'description'=> new sfValidatorString(array('required'=>false))

        ));
        $this->widgetSchema->setLabels(array(
            'name'=> __('Event Name') .' <em>*</em>',
            'description'=> __('Description') 
        ));
        $this->getWidgetSchema()->setNameFormat('createEvent[%s]');

    }
}