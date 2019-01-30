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

class CreateExpensesAction extends sfAction
{

    private $expenseService;

    /**
     * @return mixed
     */
    public function getExpenseService()
    {
        if (!($this->expenseService instanceof ExpenseService)) {
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

    public function execute($request)
    {
        // TODO: Implement execute() method.
        $this->expenseId = $request->getParameter('id', null);

        $defaults = array();
        if (!is_null($this->expenseId)) {

            $defaults = $this->getExpenseService()->getExpenseAsArray($this->expenseId);
        }

        $this->form = new CreateExpenseForm($defaults);

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $formValues = $this->form->getValues();
                $result = $this->getExpenseService()->saveExpense($formValues);
                $this->redirect('claim/viewExpense');
                if ($result instanceof ExpenseType) {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                } else {
                    $this->getUser()->setFlash('error', __(TopLevelMessages::SAVE_FAILURE));
                }
            } else {
                $this->getUser()->setFlash('error', __(TopLevelMessages::VALIDATION_FAILED));

            }

        }

    }

/*
    public function setListComponent($tasks)
    {

        $configurationFactory = new EmployeeExpensesTypesListConfigurationFactory();
        $buttons = array();
        $hasSelectableRows = false;


        $buttons['Add'] = array('label' => 'Add');
        $hasSelectableRows = true;
        $buttons['Delete'] = array(
            'type'=> 'submit',
            'label' => 'Delete',
            'class' => 'delete',
            'data-toggle'=> 'modal',
            'data-target' => '#deleteConfModal'
        );


        $configurationFactory->setRuntimeDefinitions(array(
            'hasSelectableRows' => $hasSelectableRows,
            'hasSummary' => false,
            'buttons' => $buttons,
            'buttonsPosition' => 'before-data',
            'title' =>  __('Expenses Type'),
            'formAction'=> 'claim/deleteExpenses',
            'formMethod' => 'post'

        ));

        $noOfRecords = sfConfig::get('app_items_per_page');
        //ohrmListComponent::setActivePlugin('orangehrmClaimPlugin');
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setPageNumber(1);
        ohrmListComponent::setListData($tasks);
        ohrmListComponent::setItemsPerPage($noOfRecords);
        ohrmListComponent::setNumberOfRecords(count($tasks));
    }

*/
    /**
     * TODO :  should call a service and get the list of task object
     * @return Doctrine_Collection
     * @throws Doctrine_Collection_Exception
     */
   /* protected function getTaskList(){
        $tasks1 = new ExpenseType();
        $tasks1->setName('bbbb1');
        $tasks1->setDescription('getDescription getDescription');
        $tasks1->setStatus('active1');

        $tasks2 = new ExpenseType();
        $tasks2->setName('bbbb 2');
        $tasks2->setDescription('getDescription getDescription 2');
        $tasks2->setStatus('active2');

        $tasks3 = new ExpenseType();
        $tasks3->setName("bbb3");
        $tasks3->setDescription('getDescription getDescription 3');
        $tasks3->setStatus('active3');

        $taskCollection = new Doctrine_Collection('ExpenseType');
        $taskCollection->add($tasks1);
        $taskCollection->add($tasks2);
        $taskCollection->add($tasks3);

        return $taskCollection;

    }*/
}