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

class ExpenseDao extends BaseDao
{

    /**
     * @param $expenseData
     * @return ExpenseType
     * @throws DaoException
     */
    public function saveExpenseType($expense)
    {

        try {
            $expense->save();
            return $expense;

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * @param bool $activeOnly
     * @return int
     * @throws DaoException
     */
    public function getExpenseTypeCount($activeOnly = true)
    {

        try {
            $q = Doctrine_Query:: create()
                ->from('ExpenseType');
            if ($activeOnly == true) {
                $q->addWhere('is_deleted = ?', 0);
            }
            $count = $q->execute()->count();
            return $count;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws DaoException
     */
    public function getExpenseTypeById($id)
    {


        try {
            return Doctrine::getTable('ExpenseType')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * @param string $status
     * @param int $limit
     * @param int $offset
     * @param string $sortField
     * @param string $sortOrder
     * @param bool $excludeDeleted
     * @return Doctrine_Collection
     * @throws DaoException
     */
    public function getExpenseTypesList($status ='on', $limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $excludeDeleted = true)
    {
        $sortField = ($sortField == "") ? 'name' : $sortField;
        $sortOrder = strcasecmp($sortOrder, 'DESC') === 0 ? 'DESC' : 'ASC';

        try {
            $q = Doctrine_Query:: create()
                ->from('ExpenseType')
                 ->addWhere('status = ?', $status);
            if ($excludeDeleted == true) {
                $q->addWhere('is_deleted = 0');
            }
            $q->orderBy($sortField . ' ' . $sortOrder)
                ->offset($offset)
                ->limit($limit);
            return $q->execute();
        } catch (Exception $e) {
            var_dump($e->getMessage());die;
            throw new DaoException($e->getMessage());
        }

    }

    /**
     * @param $id
     * @return mixed
     * @throws DaoException
     */
    public function getExpenseType($id)
    {
        try {
            return Doctrine:: getTable('ExpenseType')->find($id);

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * @param $id
     * @return mixed
     * @throws DaoException
     */
    public function getExpense($id)
    {

        try {
            return Doctrine:: getTable('Expense')->find($id);

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * @param $toDeleteIds
     * @return Doctrine_Collection
     * @throws DaoException
     */

    public function deleteExpenseTypes($toDeleteIds)
    {
        try {
            $q = Doctrine_Query:: create()
                ->update('ExpenseType')
                ->set('is_deleted', '?', ExpenseType::DELETED)
                ->whereIn('id', $toDeleteIds);

            return $q->execute();

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    public function getExpenseTypeByClaimRequestId($claimRequestId)
    {
        try {
            $q = Doctrine_Query:: create()
                ->from('Expense')
                ->andWhere('request_id = ?', $claimRequestId);


            return $q->execute();

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param $expense
     * @return mixed
     * @throws DaoException
     */
    public function saveExpense(Expense $expense)
    {
        try {
            $expense->save();

            return $expense;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    public function getExpenseCount($available = true)
    {
        try {
            $q = Doctrine_Query:: create()
                ->from('Expense');
            if ($available == true) {
                $q->addWhere('is_deleted = ?', 0);
            }
            $count = $q->execute()->count();
            return $count;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getExpenseByClaimRequestId($claimRequestId)
    {
        try {
            $q = Doctrine_Query:: create()
                ->from('Expense');
            if (!is_null($claimRequestId)) {
                $q->andWhere('request_id = ?', $claimRequestId);
            }

            return $q->execute();

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getExpenseList($limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $available = true)
    {
        $sortField = ($sortField == "") ? 'name' : $sortField;
        $sortOrder = strcasecmp($sortOrder, 'DESC') === 0 ? 'DESC' : 'ASC';

        try {
            $q = Doctrine_Query:: create()
                ->from('Expense');
            if ($available == true) {
                $q->addWhere('is_deleted = 0');
            }
            $q->orderBy($sortField . ' ' . $sortOrder)
                ->offset($offset)
                ->limit($limit);
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }

    }

    public function deleteExpenses($toDeleteIds)
    {
        try {
            $q = Doctrine_Query:: create()
                ->delete('Expense')
                ->whereIn('id', $toDeleteIds);
            return $q->execute();

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }
    public function getExpenseById($id)
    {

        try {
            return Doctrine::getTable('Expense')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);

        }

    }

}