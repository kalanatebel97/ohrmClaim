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

class CreateExpenseAction extends sfAction
{

    private $expenseService;

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
     * @param sfRequest $request
     * @return mixed|void
     * @throws sfStopException
     */
    public function execute($request)
    {
        $request->setParameter('initialActionName', 'viewExpense');

        $this->expenseId = $request->getParameter('id', null);
        $defaults = array();
        if (!is_null($this->expenseId)) {

            $defaults = $this->getExpenseService()->getExpenseTypeAsArray($this->expenseId);
        }

        $this->form = new CreateExpenseForm($defaults);

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $formValues = $this->form->getValues();
                $loggedInUser = $this->getUser()->getAttribute('user');
                $formValues['addedBy'] = $loggedInUser->getUserId();
                $result = $this->getExpenseService()->saveExpenseType($formValues);

                if ($result instanceof ExpenseType) {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                } else {
                    $this->getUser()->setFlash('error', __(TopLevelMessages::SAVE_FAILURE));
                }
                $this->redirect('claim/viewExpense');
            } else {

                $this->getUser()->setFlash('error', __(TopLevelMessages::VALIDATION_FAILED));

            }

        }

    }

}