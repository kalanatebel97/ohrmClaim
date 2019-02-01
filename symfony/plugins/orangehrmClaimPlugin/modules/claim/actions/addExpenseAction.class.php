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

class addExpenseAction extends sfAction
{
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

    public function execute($request)
    {
        $this->claimId = $request->getParameter('claimId', null);

        if(is_null($this->claimId)){
            $this->getUser()->setFlash('error', __(TopLevelMessages::SAVE_FAILURE));
        }

        $this->form = new AddExpenseForm();

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {

                $formValues = $this->form->getValues();
                $loggedInUser = $this->getUser()->getAttribute('user');
//                $formValues['requestId'] = $loggedInUser->getUserId();
                $result = $this->getExpenseService()->saveExpense($this->claimId, $formValues);

                if ($result instanceof Expense) {

                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));

                } else {
                    $this->getUser()->setFlash('error', __(TopLevelMessages::SAVE_FAILURE));
                }

            } else {
                $this->getUser()->setFlash('error', __(TopLevelMessages::VALIDATION_FAILED));
            }
        }

        $this->redirect($request->getReferer());
    }


}