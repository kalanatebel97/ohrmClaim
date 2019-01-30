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

class CreateEventService extends BaseService
{
    private $createEventDao;

    /**
     * @return EventDao|getCreateEventDao
     */
    public function getCreateEventDao()
    {

        if (!($this->createEventDao instanceof EventDao)) {
            $this->createEventDao = new EventDao();
        }

        return $this->createEventDao;
    }

    /**
     * @param $createEventDao
     */
    public function setCreateEventDao($createEventDao)
    {
        $this->createEventDao = $createEventDao;
    }

    /**
     * @param $eventData
     * @throws DaoException
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     *
     */
    public function saveEvent($eventData)
    {
        $event = null;
        if(isset($eventData['id'])){
            $event = $this->getEventById($eventData['id']);
        }

        if(!$event instanceof ClaimEvent){
            $event = new ClaimEvent();
        }

        $event->setName($eventData['name']);
        $event->setDescription($eventData['description']);

        return $this->getCreateEventDao()->saveEvent($event);
    }

    /**
     * @param bool $activeOnly
     * @return int
     * @throws DaoException
     */
    public function getEventCount($activeOnly = true) {
        return $this->getCreateEventDao()->getEventCount($activeOnly);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getEventById($id)
    {
        return $this->getCreateEventDao()->getEventById($id);
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
    public function getEventList($limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $activeOnly = true)
    {
        return $this->getCreateEventDao()->getEventList($limit, $offset, $sortField, $sortOrder, $activeOnly);
    }

    /**
     * @param $toDeleteIds
     * @return mixed
     */
    public function deleteEvents($toDeleteIds)
    {
        return $this->getCreateEventDao()->deleteEvents($toDeleteIds);
    }


}