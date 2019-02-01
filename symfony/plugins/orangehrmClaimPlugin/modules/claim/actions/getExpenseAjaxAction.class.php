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

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 24/1/19
 * Time: 2:09 PM
 */
class getExpenseAjaxAction extends sfAction
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
        $this->expenseId = $request->getParameter('expenseID', null);
        $expenseArray = array();
        if (!is_null($this->expenseId)) {
             $expenseArray = $this->getExpenseService()->getExpenseAsArray($this->expenseId);
        }
        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0, max-age=0");
        $response->setHttpHeader("Cache-Control", "private", false);

        echo json_encode(array('data' => $expenseArray));
        return sfView::NONE;

    }

}