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


class submitClaimAction extends sfAction {

   protected $claimService;
   protected $expenseService;

    /**
     * @return ExpenseService
     */
    public function getExpenseService()
    {
        if (!($this->expenseService instanceof ExpenseService)) {
            $this->expenseService = new ExpenseService();
        }

        return $this->expenseService;
    }

    /**
     * @param $expenseService
     */
    public function setExpenseService($expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * @return ClaimService
     */
    public function getClaimService()
    {
        if (!($this->claimService instanceof ClaimService)) {
        $this->claimService = new ClaimService();
    }
        return $this->claimService;

    }

    /**
     * @param mixed $claimService
     */
    public function setClaimService($claimService)
    {
        $this->claimService = $claimService;

    }

    public function execute($request)
    {
        $this->claimId = $request->getParameter('id', null);
        $defaults = array();
        if (!is_null($this->claimId)) {

            $defaults = $this->getClaimService()->getClaimAsArray($this->claimId);
        }

        $this->form = new ClaimRequestForm($defaults);

        $this->addExpenseform = new AddExpenseForm();

        $expense = $this->getExpenseService()->getExpenseByClaimRequestId($this->claimId);

        if (!is_null($this->claimId)) {

            $this->setListComponent($expense);
        }

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $formValues = $this->form->getValues();
                $loggedInUser = $this->getUser()->getAttribute('user');
                $formValues['emp_num'] = $loggedInUser->getEmployeeNumber();
                $formValues['addedBy'] = $loggedInUser->getUserId();
                $result = $this->getClaimService()->saveClaim($formValues);

                if ($result instanceof ClaimRequest) {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                } else {
                    $this->getUser()->setFlash('error', __(TopLevelMessages::SAVE_FAILURE));
                }$this->redirect('claim/viewClaim');
            } else {
                $this->getUser()->setFlash('error', __(TopLevelMessages::VALIDATION_FAILED));

            }

        }
    }
    public function setListComponent($expense)
    {
        $configurationFactory = new EmployeeClaimExpensesListConfigurationFactory();
        $buttons = array();
        $hasSelectableRows = false;

        $buttons['Add'] = array('label' => 'Add');
        $hasSelectableRows = true;
        $buttons['Delete'] = array(
            'type' => 'submit',
            'label' => 'Delete',
            'class' => 'delete',
            'id'=>'dialogExpenseDeleteBtn',
            'data-toggle' => 'modal',
            'data-target' => '#deleteConfModal'
        );

        $configurationFactory->setRuntimeDefinitions(array(
            'hasSelectableRows' => $hasSelectableRows,
            'hasSummary' => true,
            'buttons' => $buttons,
            'buttonsPosition' => 'before-data',
            'title' => __(''),
            'formAction' => 'claim/deleteExpense?claimId='.$this->claimId.'?referrer=submit',
            'formMethod' => 'post',
            'summary' => array(
                'summaryLabel' => 'Total',
                'summaryField' => __('Amount'),
                'summaryFunction' => 'SUM',
                'summaryFieldDecimals' => 2,
            )
        ));

        $noOfRecords = sfConfig::get('app_items_per_page');
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setPageNumber(1);
        ohrmListComponent::setListData($expense);
        ohrmListComponent::setItemsPerPage($noOfRecords);
        ohrmListComponent::setNumberOfRecords($this->getExpenseService()->getExpenseCount());
    }

}