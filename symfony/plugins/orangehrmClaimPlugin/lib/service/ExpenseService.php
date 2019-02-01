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

class ExpenseService extends BaseService
{


    private $expenseDao;

    /**
     * @return ExpenseDao
     */
    public function getExpenseDao()
    {

        if (!($this->expenseDao instanceof ExpenseDao)) {
            $this->expenseDao = new ExpenseDao();
        }

        return $this->expenseDao;
    }

    /**
     * @param mixed $expenseDao
     */
    public function setExpenseDao($expenseDao)
    {

        $this->expenseDao = $expenseDao;
    }

    public function saveExpenseType($expenseData)
    {

        $expense = null;
        if (isset($expenseData['id'])) {
            $expense = $this->getExpenseTypeById($expenseData['id']);
        }

        if (!$expense instanceof ExpenseType) {
            $expense = new ExpenseType();
        }

        $status = $expenseData['status'];

        $expense->setName($expenseData['name']);
        $expense->setDescription($expenseData['description']);
        $expense->setAddedBy($expenseData['addedBy']);
        $expense->setStatus($expenseData['status']);

        return $this->getExpenseDao()->saveExpenseType($expense);
    }

    /**
     * @param bool $activeOnly
     * @return mixed
     */
    public function getExpenseTypeCount($activeOnly = true)
    {
        return $this->getExpenseDao()->getExpenseTypeCount($activeOnly);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getExpenseTypeById($id)
    {

        return $this->getExpenseDao()->getExpenseTypeById($id);
    }

    /**
     * @param $status
     * @param int $limit
     * @param int $offset
     * @param string $sortField
     * @param string $sortOrder
     * @param bool $excludeDeleted
     * @return mixed
     * @throws DaoException
     */
    public function getExpenseTypesList($status, $limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $excludeDeleted = true)
    {
        return $this->getExpenseDao()->getExpenseTypesList($status, $limit, $offset, $sortField, $sortOrder, $excludeDeleted);
    }

    /**
     * @param $toDeleteIds
     * @return mixed
     */
    public function deleteExpenseTypes($toDeleteIds)
    {

        return $this->getExpenseDao()->deleteExpenseTypes($toDeleteIds);
    }

    /**
     * @param $id
     * @return mixed
     * @throws DaoException
     */
    public function getExpenseType($id)
    {

        return $this->getExpenseDao()->getExpenseType($id);
    }

    /**
     * @param $expenseTypeId
     * @return array
     */
    public function getExpenseTypeAsArray($expenseTypeId)
    {
        $expenseType = $this->getExpenseType($expenseTypeId);
        $data = array();
        if ($expenseType instanceof ExpenseType) {
            $data = array(
                'id' => $expenseType->getId(),
                'name' => $expenseType->getName(),
                'description' => $expenseType->getDescription(),
                'status' => $expenseType->getStatus(),

            );
        }

        return $data;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getExpense($id)
    {

        return $this->getExpenseDao()->getExpense($id);
    }

    /**
     * @param $expenseId
     * @return array
     */
    public function getExpenseAsArray($expenseId)
    {
        $expense = $this->getExpense($expenseId);
        $data = array();
        if ($expense instanceof Expense) {
            $data = array(
                'id' => $expense->getId(),
                'expenseTypeId' => $expense->getExpenseTypeId(),
                'date' => set_datepicker_date_format($expense->getDate()),
                'note' => $expense->getNote(),
                'amount' => $expense->getAmount(),
            );
        }

        return $data;
    }

    public function getExpenseTypeByClaimRequestId($claimRequestId)
    {
        return $this->getExpenseDao()->getExpenseTypeByClaimRequestId($claimRequestId);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getExpenseById($id)
    {
        return $this->getExpenseDao()->getExpenseById($id);
    }

    /**
     * @param null $claimId
     * @param $expenseData
     * @return Expense
     * @throws DaoException
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function saveExpense($claimId = null, $expenseData)
    {
        $expense = null;
        if (isset($expenseData['id'])) {
            $expense = $this->getExpenseById($expenseData['id']);
        }

        if (!$expense instanceof Expense) {
            $expense = new Expense();
        }
        $expense->setExpenseTypeId($expenseData['expenseType']);
        $expense->setDate($expenseData['date']);
        $expense->setAmount($expenseData['amount']);
        $expense->setNote($expenseData['note']);
        $expense->setRequestId($claimId);

        return $this->getExpenseDao()->saveExpense($expense);
    }

    /**
     * @param bool $available
     * @return int
     * @throws DaoException
     */
    public function getExpenseCount($available = true)
    {
        return $this->getExpenseDao()->getExpenseCount($available);
    }

    /**
     * @param $id
     * @return Doctrine_Collection
     * @throws DaoException
     */
    public function getExpenseByClaimRequestId($id)
    {
        return $this->getExpenseDao()->getExpenseByClaimRequestId($id);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $sortField
     * @param string $sortOrder
     * @param bool $activeOnly
     * @return Doctrine_Collection
     * @throws DaoException
     */
    public function getExpenseList($limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $activeOnly = true)
    {
        return $this->getExpenseDao()->getExpenseList($limit, $offset, $sortField, $sortOrder, $activeOnly);
    }

    /**
     * @param $toDeleteIds
     * @return Doctrine_Collection
     * @throws DaoException
     */
    public function deleteExpenses($toDeleteIds)
    {
        return $this->getExpenseDao()->deleteExpenses($toDeleteIds);
    }
}