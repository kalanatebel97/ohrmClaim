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


class deleteClaimAttachmentsAction extends sfAction
{
    public function execute($request)
    {
        $this->form = new  EmployeeAttachmentDeleteForm(array(), array(), true);
        $this->claimRequestId = $request->getParameter('claimRequestId', null);
//        var_dump($request->getParameterHolder()->getAll());die;

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {

            //            if (!$claimRequestId) {
//                throw new PIMServiceException("No Employee ID given");
//            }
//            if (!$this->IsActionAccessible($claimRequestId)) {
//                $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
//            }
            $attachmentsToDelete = $request->getParameter('chkattdel', array());
            if ($attachmentsToDelete) {
                $service = new ClaimService();
                $service->deleteClaimAttachments( $this->claimRequestId, $attachmentsToDelete);
                $this->getUser()->setFlash('listAttachmentPane.success', __(TopLevelMessages::DELETE_SUCCESS));
            }
//        } else {
//            $this->handleBadRequest();
//            $this->forwardToSecureAction();
//        }

            $this->redirect('claim/assignClaim?id=' .$this->claimRequestId);
        }else{
            var_dump($this->form->getErrorSchema()->getErrors());die;
        }
    }

}