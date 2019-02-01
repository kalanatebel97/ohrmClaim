<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */


class AddExpenseForm extends sfForm
{

    protected $expenseTypes;
    protected $expenseService;

    /**
     * @return ExpenseService
     */
    public function getExpenseService()
    {
        if (is_null($this->expenseService)) {
            $this->expenseService = new ExpenseService();
        }
        return $this->expenseService;

    }

    /**
     * @param mixed $expenseService
     */
    public function setExpenseService($expenseService)
    {
        $this->expenseService = $expenseService;
    }



    public function configure()
    {
        parent::configure();

        $this->expenseTypes = $this->getExpenseTypesList();

        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(),
            'expenseType' => new sfWidgetFormChoice(array('choices' => $this->expenseTypes)),
            'date' => new ohrmWidgetDatePicker(array(), array('id' => 'assignExpense_dueDate')),
            'amount' => new sfWidgetFormInput(),
            'note' => new sfWidgetFormTextarea()
        ));

        $this->setValidators(array(
            'id' => new sfValidatorInteger(array('required' => false)),
            'expenseType' => new sfValidatorChoice(array('required' => true, 'choices' => array_keys($this->expenseTypes))),
            'date' => new sfValidatorDate(array('required' => true)),
            'amount' => new sfValidatorString(array('required' => true)),
            'note' => new sfValidatorString(array('required' => false))
        ));
        $this->widgetSchema->setLabels(array(
            'expenseType' => __("Expense Type") . '<em>*</em>',
            'date' => __('Date') . '<em>*</em>',
            'amount' => __('Amount') . '<em>*</em>',
            'note' => __('Note')
        ));
        $this->getWidgetSchema()->setNameFormat('addExpense[%s]');
    }

    protected function getExpenseTypesList()
    {
        $expenseList = $this->getExpenseService()->getExpenseTypesList();
        $list = array('' => '-- ' . __('Select') . ' --');

        foreach ($expenseList as $expense) {
            $list[$expense->getId()] = $expense->getName();
        }
        return $list;
    }

}