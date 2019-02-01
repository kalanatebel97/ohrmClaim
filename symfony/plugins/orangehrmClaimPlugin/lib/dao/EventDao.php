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

class EventDao extends BaseDao {

    /**
     * @param $event
     * @return mixed
     * @throws DaoException
     */
    public function saveEvent($event) {

        try {
            $event->save();
            return $event;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * @param bool $activeOnly
     * @return int
     * @throws DaoException
     */
    public function getEventCount($activeOnly = true) {

        try {
            $q = Doctrine_Query :: create()
                ->from('ClaimEvent');
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
    public function getEventById($id) {


        try {
            return Doctrine::getTable('ClaimEvent')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }


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
    public function getEventList($limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $available = true) {


        $sortField = ($sortField == "") ? 'name' : $sortField;
        $sortOrder = strcasecmp($sortOrder, 'DESC') === 0 ? 'DESC' : 'ASC';

        try {
            $q = Doctrine_Query :: create()
                ->from('ClaimEvent');
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
     * @param $id
     * @return mixed
     * @throws DaoException
     */
    public function getClaimEvent($id) {

        try {
            return Doctrine :: getTable('ClaimEvent')->find($id);

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * @param $toDeleteIds
     * @return Doctrine_Collection
     * @throws DaoException
     */

    public function deleteEvents($toDeleteIds){

        try {
            $q = Doctrine_Query :: create()
                ->update('ClaimEvent')
                ->set('is_deleted', '?', ClaimEvent::DELETED)
                ->whereIn('id', $toDeleteIds);
            return $q->execute();

        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }

    }

}