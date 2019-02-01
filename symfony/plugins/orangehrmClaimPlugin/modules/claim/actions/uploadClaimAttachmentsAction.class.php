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

class uploadClaimAttachmentsAction extends sfAction
{

    /**
     * @param $request
     * @throws PIMServiceException
     * @throws sfStopException
     */
    public function execute($request)
    {

        $loggedInEmpNum = empty($this->getUser()->getEmployeeNumber()) ? null : $this->getUser()->getEmployeeNumber();
        $loggedInUserName = $_SESSION['fname'];

        $this->claimRequestId = $request->getParameter('claimRequestId', null);

        if (is_null($this->claimRequestId)) {
            $this->getUser()->setFlash('error', __(TopLevelMessages::SAVE_FAILURE));
        }

        $this->form = new ClaimAttachmentForm(array(),
            array('loggedInUser' => $loggedInEmpNum,
                'loggedInUserName' => $loggedInUserName), true);

        if ($this->getRequest()->isMethod('post')) {

            $attachId = $request->getParameter('seqNO');
            $screen = $request->getParameter('screen');

            $permission = $this->getDataGroupPermissions($screen . '_claimAttachments', $request->getParameter('requestId'));


                // Handle the form submission
                $this->form->bind($request->getPostParameters(), $request->getFiles());

                if ($this->form->isValid()) {
                    $requestId = $this->form->getValue('requestId');
//                    if (!$this->IsActionAccessible($requestId)) {
//                        $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
//                    }

                    $this->form->save();
                    $this->getUser()->setFlash('listAttachmentPane.success', __(TopLevelMessages::SAVE_SUCCESS));
                } else {
                    $validationMsg = '';
                    foreach ($this->form->getWidgetSchema()->getPositions() as $widgetName) {
                        if ($this->form[$widgetName]->hasError()) {
                            $validationMsg .= __(TopLevelMessages::FILE_SIZE_SAVE_FAILURE);
                        }
                    }

                    $this->getUser()->setFlash('saveAttachmentPane.warning', $validationMsg);
                    $this->getUser()->setFlash('attachmentComments', $request->getParameter('txtAttDesc'));
                    $this->getUser()->setFlash('attachmentSeqNo', $request->getParameter('seqNO'));
                }
        }

        $this->redirect($request->getReferer());
    }

    private function getDataGroupPermissions($string)
    {

        return new ResourcePermission(true, true, true, true);
    }


}