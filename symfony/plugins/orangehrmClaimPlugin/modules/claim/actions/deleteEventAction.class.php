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


class deleteEventAction extends sfAction {

    private $eventService;

    /**
     * @return EventService
     */
    public function getEventservice() {


        if (!($this->eventService instanceof EventService)) {
            $this->eventService = new EventService();
        }

        return $this->eventService;
    }

    /**
     * @param $createEventService
     */
    public function setCreateEventService($eventService) {

        $this->eventService = $eventService;
    }

    public function execute($request) {

        $userPermissions = $this->getDataGroupPermissions('time_customers');

        if ($userPermissions->canDelete()) {

            $form = new DefaultListForm();
            $form->bind($request->getParameter($form->getName()));

            if ($form->isValid()) {
                $toBeDeletedEventIds = $request->getParameter('chkSelectRow');
                if (!empty($toBeDeletedEventIds)) {
                        foreach ($toBeDeletedEventIds as $toBeDeletedEventId) {
                            $event = $this->getEventservice()->deleteEvents($toBeDeletedEventId);
                        }
                        $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                }
            }
            $this->redirect('claim/viewEvent');
        }


    }

    /**
     * @param $string
     * @return ResourcePermission
     */
    private function getDataGroupPermissions($string) {

        return new ResourcePermission(true, true, true, true);
    }

}