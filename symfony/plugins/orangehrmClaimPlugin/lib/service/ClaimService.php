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

class ClaimService extends BaseService
{

    private $claimDao;

    /**
     * @return ClaimDao
     */
    public function getClaimDao()
    {
        if (!($this->claimDao instanceof ClaimDao)) {
            $this->claimDao = new ClaimDao();
        }
        return $this->claimDao;
    }

    /**
     * @param $claimDao
     */
    public function setClaimDao($claimDao)
    {
        $this->claimDao = $claimDao;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $sortField
     * @param string $sortOrder
     * @param bool $activeOnly
     * @return mixed
     */
    public function getClaims($empNumber,$limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $activeOnly = true)
    {
        return $this->getClaimDao()->getClaims($empNumber,$limit, $offset, $sortField, $sortOrder, $activeOnly);
    }

    /**
     * @param $claimData
     * @return mixed
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function saveClaim($claimData)
    {


        $claim = null;
        if (isset($claimData['id'])) {
            $claim = $this->getClaimById($claimData['id']);
        }

        if (!$claim instanceof ClaimRequest) {
            $claim = new ClaimRequest();
        }
        $claim->setEmpNumber($claimData['emp_num']);
        $claim->setAddedBy($claimData['addedBy']);
        $claim->setEventType($claimData['eventType']);
        $claim->setDescription($claimData['description']);
        $claim->setCurrency($claimData['currency']);

        return $this->getClaimDao()->saveClaim($claim);

    }

    /**
     * @param bool $activeOnly
     * @return mixed
     */
    public function getClaimCount($activeOnly = true)
    {
        return $this->getClaimDao()->getClaimCount($activeOnly);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getClaimById($id)
    {
        return $this->getClaimDao()->getClaimById($id);
    }

    /**
     * @param $toDeleteIds
     * @return mixed
     */
    public function deleteClaims($toDeleteIds)
    {
        return $this->getClaimDao()->deleteClaims($toDeleteIds);
    }

    public function getClaimAsArray($eventId)
    {
        $claimRequest = $this->getClaimById($eventId);
        $data = array();
        if ($claimRequest instanceof ClaimRequest) {
            $data = array(
                'id' => $claimRequest->getId(),
                'eventType' => $claimRequest->getEventType(),
                'description' => $claimRequest->getDescription(),
                'currency' => $claimRequest->getCurrency(),
            );
        }

        return $data;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $sortField
     * @param string $sortOrder
     * @param bool $activeOnly
     * @return mixed
     */
    public function getAssignClaimType($limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $available = true)
    {
        return $this->getClaimDao()->getAssignClaimType($limit, $offset, $sortField, $sortOrder, $available);
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
        $assignClaim->setEmpNumber($claimData['empName']['empId']);
        $assignClaim->setAddedBy($claimData['addedBy']);
        $assignClaim->setEventType($claimData['eventType']);
        $assignClaim->setDescription($claimData['description']);
        $assignClaim->setCurrency($claimData['currency']);

        return $this->getClaimDao()->saveAssignClaim($assignClaim);
    }

    /**
     * @param $claimRequestId
     * @param $screen
     * @return Doctrine_Collection
     * @throws DaoException
     */
    public function getClaimAttachments($claimRequestId) {
        return $this->getClaimDao()->getClaimAttachments($claimRequestId);
    }

    /**
     * @param $claimRequestId
     * @param null $attachmentIds
     * @return mixed
     */
    public function deleteClaimAttachments($claimRequestId, $attachmentIds = null) {
        return $this->getClaimDao()->deleteClaimAttachments($claimRequestId, $attachmentIds);
    }

    /**
     * @param bool $available
     * @return mixed
     */
    public function getAssignClaimCount($available = true)
    {
        return $this->getClaimDao()->getAssignClaimCount($available);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAssignClaimById($id)
    {
        return $this->getClaimDao()->getAssignClaimById($id);
    }

    /**
     * @param $toDeleteIds
     * @return mixed
     */
    public function deleteAssignClaims($toDeleteIds)
    {
        return $this->getClaimDao()->deleteAssignClaims($toDeleteIds);
    }

    /**
     * @param $claimId
     * @return array
     */
    public function getAssignClaimAsArray($claimId)
    {
        $assignClaim = $this->getAssignClaimById($claimId);
        $data = array();

        if ($assignClaim instanceof ClaimRequest) {
            $data = array(
                'id' => $assignClaim->getId(),
                'empName' => array(
                    'empName' => $assignClaim->getEmployee()->getFullName(),
                    'empId' => $assignClaim->getEmployee()->getEmpNumber()
                ),
                'eventType' => $assignClaim->getEventType(),
                'currency' => $assignClaim->getCurrency(),
                'description' => $assignClaim->getDescription(),

            );
        }

        return $data;
    }


}