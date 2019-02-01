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

class AssignClaimDao extends BaseDao
{
    /**
     * @param $assignClaim
     * @return mixed
     * @throws DaoException
     */
    public function saveAssignClaim($assignClaim) {

        try {
            $assignClaim->save();
            return $assignClaim;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * @param bool $available
     * @return int
     * @throws DaoException
     */
    public function getAssignClaimCount($available = true) {

        try {
            $q = Doctrine_Query :: create()
                ->from('ClaimRequest');
            if ($available == true) {
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
    public function getAssignClaimById($id) {


        try {
            return Doctrine::getTable('ClaimRequest')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);


        }

    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $sortField
     * @param string $sortOrder
     * @param bool $available
     * @return Doctrine_Collection
     * @throws DaoException
     */
    public function getAssignClaimType($limit = 50, $offset = 0, $sortField = 'emp_number', $sortOrder = 'ASC', $available = true) {

        $sortField = ($sortField == "") ? 'emp_number' : $sortField;
        $sortOrder = strcasecmp($sortOrder, 'DESC') === 0 ? 'DESC' : 'ASC';

        try {
            $q = Doctrine_Query :: create()
                ->from('ClaimRequest');
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

    /**
     * @param $toDeleteIds
     * @return Doctrine_Collection
     * @throws DaoException
     */
    public function deleteAssignClaims($toDeleteIds){

        try {

            $q = Doctrine_Query::create()->delete('ClaimRequest')
                ->whereIn('id', $toDeleteIds);

            return $q->execute();

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }





}