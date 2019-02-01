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

class viewAssignClaimAction extends sfAction
{
    protected $claimService;

    /**
     * @return ClaimService
     */
    public function getClaimService()
    {
        if (!($this->claimService instanceof ClaimService)) {
            $this->claimService = new ClaimService();
        }
        return $this->claimService;
    }

    /**
     * @param $claimService
     */
    public function setClaimService($claimService)
    {
        $this->claimService = $claimService;
    }

    public function execute($request)
    {
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
            $assignClaimList = $this->getClaimService()->getAssignClaimType($noOfRecords, $offset, $sortField, $sortOrder);
            $this->setListComponent($assignClaimList, $noOfRecords, $pageNumber, $this->userPermissions);
            $this->getUser()->setAttribute('pageNumber', $pageNumber);
            $params = array();
            $this->parmetersForListComponent = $params;
        }

    }

    /**
     * @param $assignClaimList
     * @param $noOfRecords
     * @param $pageNumber
     * @param $permissions
     */
    public function setListComponent($assignClaimList, $noOfRecords, $pageNumber, $permissions)
    {
        if ($permissions->canCreate()) {
            $buttons['Add'] = array('label' => 'Assign');
        }

//        if (!$permissions->canDelete()) {
//            //$runtimeDefinitions['hasSelectableRows'] = false;
//        } else if ($permissions->canDelete()) {
//            $buttons['Delete'] = array('label' => 'Delete',
//                'type' => 'submit',
//                'data-toggle' => 'modal',
//                'data-target' => '#deleteConfModal',
//                'class' => 'delete',
//
//            );
//        }
//        $isLinkable = false;
//        if ($permissions->canUpdate()) {
//            $isLinkable = true;
//        }

        $runtimeDefinitions['buttons'] = $buttons;
        $runtimeDefinitions['hasSummary'] = false;
        $runtimeDefinitions['hasSelectableRows'] = false;
        $runtimeDefinitions['title'] = __('Claim Requests');
        $runtimeDefinitions['formMethod'] = sfRequest::POST;
        $runtimeDefinitions['formAction'] = 'claim/deleteAssignClaim';

        $configurationFactory = new EmployeeAssignClaimListConfigurationFactory();
        //$configurationFactory->setIsLinkable($isLinkable);
        $configurationFactory->setRuntimeDefinitions($runtimeDefinitions);
        //ohrmListComponent::setPageNumber($pageNumber);
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($assignClaimList);
        ohrmListComponent::setItemsPerPage(1000);
        ohrmListComponent::setNumberOfRecords(count($assignClaimList));

    }

    /**
     * @param $string
     * @return ResourcePermission
     */
    private function getDataGroupPermissions($string)
    {
        return new ResourcePermission(true, true, true, true);
    }


}