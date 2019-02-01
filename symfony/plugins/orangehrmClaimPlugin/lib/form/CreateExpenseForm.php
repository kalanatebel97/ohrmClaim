<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 27/12/18
 * Time: 4:41 PM
 */

class CreateExpenseForm extends sfForm
{

    public function configure()
    {

        parent::configure();

        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(),
            'name' => new sfWidgetFormInput(),
            'description' => new sfWidgetFormTextarea(),
            'status' => new sfWidgetFormInputCheckbox(array())
        ));
        $this->setValidators(array(
            'id' => new sfValidatorPass(array('required' => false)),
            'name' => new sfValidatorString(array('required' => true, 'max_length' => 255)),
            'description' => new sfValidatorString(array('required' => true)),
            'status' => new sfValidatorPass(array('required' => false)),

        ));
        $this->widgetSchema->setLabels(array(
            'name' => __('Expense Name') . ' <em>*</em>',
            'description' => __('Description') . '<em>*</em>',
            'status' => __('Active'),
        ));
        $this->getWidgetSchema()->setNameFormat('createExpense[%s]');

    }


}