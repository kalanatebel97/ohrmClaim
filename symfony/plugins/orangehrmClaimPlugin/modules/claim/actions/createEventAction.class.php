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
 * Class createEventAction
 */
class createEventAction extends sfAction {


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
     * @param $eventService
     */
    public function setEventService($eventService){

        $this->eventService = $eventService;

    }

    /**
     * @param sfRequest $request
     * @return mixed|void
     * @throws Doctrine_Collection_Exception
     */
    public function execute($request){

        $request->setParameter('initialActionName', 'viewEvent');

        $this->eventId = $request->getParameter('id', null);
        $defaults = array();
        if (!is_null($this->eventId)) {

            $defaults = $this->getEventService()->getEventAsArray($this->eventId);
        }

        $this->form = new CreateEventForm($defaults);

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $formValues = $this->form->getValues();
                $loggedInUser = $this->getUser()->getAttribute('user');
                $formValues['addedBy'] = $loggedInUser->getUserId();
                $result = $this->getEventservice()->saveEvent($formValues);
                if ($result instanceof ClaimEvent) {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                } else {
                    $this->getUser()->setFlash('error', __(TopLevelMessages::SAVE_FAILURE));
                }$this->redirect('claim/viewEvent');
            } else {
                $this->getUser()->setFlash('error', __(TopLevelMessages::VALIDATION_FAILED));

            }

        }


    }


}
