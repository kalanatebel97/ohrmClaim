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


class AssignClaimForm extends sfForm
{
    private $currencies;
    protected $eventTypes;
    private $currencyService;
    private $eventService;
    private $employees;
    private $employeeService;
    public $edited = false;

    /**
     * @return EmployeeService
     */
    public function getEmployeeService()
    {
        if (is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
        }
        return $this->employeeService;
    }

    /**
     * @param $employeeService
     */
    public function setEmployeeService($employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * @return CurrencyService
     */
    public function getCurrencyService()
    {
        if (is_null($this->currencyService)) {
            $this->currencyService = new CurrencyService();
        }
        return $this->currencyService;
    }

    /**
     * @param CurrencyService $currencyService
     */
    public function setCurrencyService(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * @return EventService
     */
    public function getEventService()
    {
        if (is_null($this->eventService)) {
            $this->eventService = new EventService();
        }
        return $this->eventService;

    }

    /**
     * @param EventService $eventService
     */
    public function setEventService(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @throws AdminServiceException
     * @throws DaoException
     */
    public function configure()

    {
        parent::configure();

        $this->currencies = $this->_getCurrencies();
        $this->eventTypes = $this->getEventList();
        $this->employees = $this->getEmployees();
        if (!empty($this->id)) {
            $this->edited = true;
        }

//        $idGenService = new IDGeneratorService();
//        $idGenService->setEntity(new ClaimRequest());
//        $claimId = $idGenService->getNextID(false);
//        var_dump($claimId);
////        $employeeId = str_pad($claimId, 4, '0');

        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(),
            'status' => new sfWidgetFormInputHidden(),
            'empName' => new ohrmWidgetEmployeeNameAutoFill(),
            'eventType' => new sfWidgetFormSelect(array('choices' => $this->eventTypes)),
            'description' => new sfWidgetFormTextarea(),
            'currency' => new sfWidgetFormSelect(array('choices' => $this->currencies)),
        ));
        $this->setValidators(array(

            'id' => new sfValidatorInteger(array('required' => false)),
            'status' => new sfValidatorString(array('required' => false)),
            'empName' => new ohrmValidatorEmployeeNameAutoFill(),
            'eventType' => new sfValidatorChoice(array('required' => true, 'choices' => array_keys($this->eventTypes))),
            'description' => new sfValidatorString(array('required' => false)),
            'currency' => new sfValidatorChoice(array('required' => true, 'choices' => array_keys($this->currencies)))

        ));
        $this->widgetSchema->setLabels(array(
            'id' =>__('Id'),
            'status' => __('Status'),
            'empName' => __('Employee') . '<em>*</em>',
            'eventType' => __('Event Type') . ' <em>*</em>',
            'description' => __('Description'),
            'currency' => __('Currency') . ' <em>*</em>',

        ));

        $this->getWidgetSchema()->setNameFormat('assignClaim[%s]');
    }

    /**
     * @return array
     * @throws AdminServiceException
     */
    private function _getCurrencies()
    {
        $currencies = $this->getCurrencyService()->getCurrencyList();
        $choices = array('' => '-- ' . __('Select') . ' --');

        foreach ($currencies as $currency) {
            $choices[$currency->getCurrencyId()] = $currency->getCurrencyName();
        }
        return $choices;
    }

    /**
     * @return mixed
     * @throws DaoException
     */
    private function getEventList()
    {
        $eventList = $this->getEventService()->getEventList();
        $list = array('' => '-- ' . __('Select') . ' --');
        foreach ($eventList as $event) {
            $list[$event->getId()] = $event->getName();
        }
        return $list;
    }

    /**
     * @return mixed
     * @throws DaoException
     */
    private function getEmployees()
    {
        $empList = $this->getEmployeeService()->getEmployeeList();
        foreach ($empList as $emp) {
            $list[$emp->getEmployeeId()] = $emp->getFirstName();
        }
        return $list;
    }



}