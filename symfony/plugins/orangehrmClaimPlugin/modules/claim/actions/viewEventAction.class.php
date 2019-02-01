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

class viewEventAction extends sfAction {

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

    public function execute($request){

        // TODO: Implement execute() method.

        //$usrObj = $this->getUser()->getAttribute('user');

        $this->userPermissions = $this->getDataGroupPermissions('time_customers');

        $id = $request->getParameter('id');
        $isPaging = $request->getParameter('pageNo');
        $sortField = $request->getParameter('sortField');
        $sortOrder = $request->getParameter('sortOrder');
        $pageNumber = $isPaging;
        if ($id > 0 && $this->getUser()->hasAttribute('pageNumber')) {
            $pageNumber = $this->getUser()->getAttribute('pageNumber');
        }
        if ($this->getUser()->getAttribute('addScreen') && $this->getUser()->hasAttribute('pageNumber')) {
            $pageNumber = $this->getUser()->getAttribute('pageNumber');
        }
        if ($this->userPermissions->canRead()) {
            $noOfRecords = sfConfig::get('app_items_per_page');
            $offset = ($pageNumber >= 1) ? (($pageNumber - 1) * $noOfRecords) : ($request->getParameter('pageNo', 1) - 1) * $noOfRecords;
            $eventList = $this->getEventService()->getEventList($noOfRecords, $offset, $sortField, $sortOrder);
            $this->setListComponent($eventList, $noOfRecords, $pageNumber, $this->userPermissions);
            $this->getUser()->setAttribute('pageNumber', $pageNumber);
            $params = array();
            $this->parmetersForListCompoment = $params;
        }

    }

    /**
     * @param $eventList
     * @param $noOfRecords
     * @param $pageNumber
     * @param $permissions
     * @throws DaoException
     */
    public function setListComponent($eventList, $noOfRecords, $pageNumber, $permissions){


        if ($permissions->canCreate()) {
            $buttons['Add'] = array('label' => 'Add');
        }

        if (!$permissions->canDelete()) {
            //$runtimeDefinitions['hasSelectableRows'] = false;
        } else if ($permissions->canDelete()) {
            $buttons['Delete'] = array('label' => 'Delete',
                'type' => 'submit',
                'data-toggle' => 'modal',
                'data-target' => '#deleteConfModal',
                'class' => 'delete');
        }
        $isLinkable = false;
        if($permissions->canUpdate()){
            $isLinkable = true;
        }

        $runtimeDefinitions['buttons'] = $buttons;
        $runtimeDefinitions['hasSelectableRows'] = true;
        $runtimeDefinitions['hasSummary'] = false;
        $runtimeDefinitions['title'] = __('Events');
        $runtimeDefinitions['formMethod'] = sfRequest::POST;
        $runtimeDefinitions['formAction'] = 'claim/deleteEvent';

        $configurationFactory = new EmployeeClaimEventTypeListConfigurationFactory();
        //$configurationFactory->setIsLinkable($isLinkable);
        $configurationFactory->setRuntimeDefinitions($runtimeDefinitions);
        ohrmListComponent::setPageNumber($pageNumber);
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($eventList);
        ohrmListComponent::setItemsPerPage($noOfRecords);
        ohrmListComponent::setNumberOfRecords($this->getEventService()->getEventCount());

    }

    /**
     * @param $string
     * @return ResourcePermission
     */
    private function getDataGroupPermissions($string){

        return new ResourcePermission(true, true, true, true);
    }

}