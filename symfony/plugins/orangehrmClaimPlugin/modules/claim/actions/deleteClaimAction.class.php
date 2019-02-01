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

class deleteClaimAction extends sfAction
{
    private $claimService;

    /**
     * @return ClaimService
     */
    public function getClaimservice() {

        if (!($this->claimService instanceof ClaimService)) {
            $this->claimService = new ClaimService();
        }

        return $this->claimService;
    }

    /**
     * @param $claimService
     */
    public function setClaimService($claimService) {

        $this->claimService = $claimService;
    }

    public function execute($request) {

        $userPermissions = $this->getDataGroupPermissions('time_customers');

          if ($userPermissions->canDelete()) {

            $form = new DefaultListForm();
            $form->bind($request->getParameter($form->getName()));
            if ($form->isValid()) {
                $toBeDeletedClaimIds = $request->getParameter('chkSelectRow');
                if (!empty($toBeDeletedClaimIds)) {
                    foreach ($toBeDeletedClaimIds as $toBeDeletedClaimId) {
                        $claim = $this->getClaimservice()->deleteClaims($toBeDeletedClaimId);
                    }
                    $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                }
            }
            $this->redirect('claim/viewClaim');
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
