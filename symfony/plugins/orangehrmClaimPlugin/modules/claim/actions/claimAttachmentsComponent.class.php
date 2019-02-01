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


class claimAttachmentsComponent extends sfComponent
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
        $this->attEditPane = false;
        $this->attSeqNO = false;
        $this->attComments = '';
        $this->scrollToAttachments = false;

        $this->permission = $this->getDataGroupPermissions($this->screen . '_claimAttachments', $this->claimRequestId);
        if ($this->getUser()->hasFlash('attachmentMessage')) {

            $this->scrollToAttachments = true;

            list($this->attachmentMessageType, $this->attachmentMessage) = $this->getUser()->getFlash('attachmentMessage');

            if ($this->attachmentMessageType == 'warning') {
                $this->attEditPane = true;
                if ( $this->getUser()->hasFlash('attachmentComments') ) {
                    $this->attComments = $this->getUser()->getFlash('attachmentComments');
                }

                if ( $this->getUser()->hasFlash('attachmentSeqNo')) {
                    $tmpNo = $this->getUser()->getFlash('attachmentSeqNo');
                    $tmpNo = trim($tmpNo);
                    if (!empty($tmpNo)) {
                        $this->attSeqNO = $tmpNo;
                    }
                }
            }
        } else {
            $this->attachmentMessageType = '';
            $this->attachmentMessage = '';
        }
        $this->claimId = $this->getClaimService()->getAssignClaimById($this->claimRequestId);
        $this->attachmentList = $this->getClaimService()->getClaimAttachments($this->claimRequestId);
        $this->form = new ClaimAttachmentForm(array(),  array(), true);
        $this->deleteForm = new EmployeeAttachmentDeleteForm(array(), array(), true);

    }
    private function getDataGroupPermissions($string)
    {
        return new ResourcePermission(true, true, true, true);
    }
}