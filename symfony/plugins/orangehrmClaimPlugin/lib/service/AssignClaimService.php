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


class AssignClaimService extends BaseService
{

    private $assignClaimDao;

    /**
     * @return AssignClaimDao
     */
    public function getAssignClaimDao()
    {
        if (!($this->assignClaimDao instanceof AssignClaimDao)) {
            $this->assignClaimDao = new AssignClaimDao();
        }
        return $this->assignClaimDao;
    }

    /**
     * @param $assignClaimDao
     */
    public function setAssignClaimDao($assignClaimDao)
    {
        $this->assignClaimDao = $assignClaimDao;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $sortField
     * @param string $sortOrder
     * @param bool $activeOnly
     * @return mixed
     */
    public function getAssignClaimType($limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $available= true)
    {
        return $this->getAssignClaimDao()->getAssignClaimType($limit, $offset, $sortField, $sortOrder, $available);
    }

    /**
     * @param $claimData
     * @return mixed
     */
    public function saveAssignClaim($claimData)
    {
        $assignClaim = null;
        if (isset($claimData['id'])) {
            $assignClaim = $this->getAssignClaimById($claimData['id']);
        }

        if (!$assignClaim instanceof ClaimRequest) {
            $assignClaim = new ClaimRequest();
        }
        $assignClaim->setEmpNumber($claimData['empId']);
        $assignClaim->setEventType($claimData['eventType']);
        $assignClaim->setDescription($claimData['description']);
        $assignClaim->setCurrency($claimData['currency']);

        return $this->getAssignClaimDao()->saveAssignClaim($assignClaim);

    }

    /**
     * @param bool $available
     * @return mixed
     */
    public function getAssignClaimCount($available = true)
    {

        return $this->getAssignClaimDao()->getAssignClaimCount($available);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAssignClaimById($id)
    {

        return $this->getAssignClaimDao()->getAssignClaimById($id);
    }

    /**
     * @param $toDeleteIds
     * @return mixed
     */
    public function deleteAssignClaims($toDeleteIds)
    {
        return $this->getAssignClaimDao()->deleteAssignClaims($toDeleteIds);
    }

    /**
     * @param $claimId
     * @return array
     */
    public function getAssignClaimAsArray($claimId) {

        $assignClaim = $this->getAssignClaimById($claimId);
        $data = array();
        if($assignClaim instanceof ClaimRequest){
            $data = array(
                'id' => $assignClaim->getId(),
                'empName'=>$assignClaim->getEmployee(),
                'name' => $assignClaim->getEventType(),
                'description'=> $assignClaim->getDescription(),
                'currency'   => $assignClaim->getCurrency(),

            );
        }

        return $data;
    }



}
