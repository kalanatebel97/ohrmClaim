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


class asignClaimAction extends sfAction
{
    protected $eventService;

    /**
     * @return mixed
     */
    public function getEventService()
    {
        return $this->eventService;
    }

    /**
     * @param $eventService
     */
    public function setEventService($eventService)
    {
        $this->eventService = $eventService;
    }
    protected $employeeService;

    /**
     * @return mixed
     */
    public function getEmployeeService()
    {
        return $this->employeeService;
    }

    /**
     * @param mixed $employeeService
     */
    public function setEmployeeService($employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function execute($request)
    {
        // TODO: Implement execute() method.
        $this->claimId = $request->getParameter('id', null);
        $defaults = array();
        if (!is_null($this->claimId)) {

            $defaults = $this->getClaimService()->getClaimAsArray($this->claimId);


        }

        $this->form = new AsignClaimRequestForm($defaults);

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $formValues = $this->form->getValues();
                $result = $this->getClaimService()->saveClaim($formValues);

                if ($result instanceof ClaimRequest) {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                } else {
                    $this->getUser()->setFlash('error', __(TopLevelMessages::SAVE_FAILURE));
                }$this->redirect('claim/viewClaim');
            } else {
                $this->getUser()->setFlash('error', __(TopLevelMessages::VALIDATION_FAILED));

            }

        }


    }

}