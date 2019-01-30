<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 26/12/18
 * Time: 1:45 PM
 */

class createEventForm extends sfForm
{

    public function configure()
    {
        $this->setWidgets(array(
            'id'=> new sfWidgetFormInputHidden(),
            //'addedBy'=> new sfWidgetFormInputHidden(),
            'eventName'=> new sfWidgetFormInput(),
            'description' => new sfWidgetFormInput()
        ));

        $this->setValidators(array(
            'id'=> new sfValidatorInteger(),
            //'addedBy'=> new sfValidatorInteger(),
            'eventName'=> new sfValidatorString(array('required' => true,'max_length'=> 255)),
            'description'=> new sfValidatorString(array('required'=>false, 'max_length'=> 1000))

        ));
        $this->widgetSchema->setLabels(array(
            'eventName'=> __('Event Name') .' <em>*</em>',
            'description'=> __('Description') 
        ));
        $this->getWidgetSchema()->setNameFormat('createEvent[%s]');

    }
}