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


class ClaimRequestForm extends sfForm {

    private $currencies;
    protected $eventTypes;
    private $currencyService;
    private $eventService;


    /**
     * @return CurrencyService
     */
    public function getCurrencyService() {
        if (is_null($this->currencyService)) {
            $this->currencyService = new CurrencyService();
        }
        return $this->currencyService;
    }

    /**
     * @param CurrencyService $currencyService
     */
    public function setCurrencyService(CurrencyService $currencyService) {
        $this->currencyService = $currencyService;
    }

    /**
     * @return EventService
     */
    public function getEventService() {
        if (is_null($this->eventService)) {
            $this->eventService = new EventService();
        }
        return $this->eventService;

    }

    /**
     * @param EventService $eventService
     */
    public function setEventService(EventService $eventService) {
        $this->eventService = $eventService;
    }


    public function configure()    {

        parent::configure(); // TODO: Change the autogenerated stub

        $this->currencies = $this->_getCurrencies();
        $this->eventTypes = $this->getEventList();

        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(),
            'eventType' => new sfWidgetFormSelect(array('choices' => $this->eventTypes)),
            'description' => new sfWidgetFormTextarea(),
            'currency' => new sfWidgetFormSelect(array('choices'=> $this->currencies)),
        ));
        $this->setValidators(array(

            'id'=> new sfValidatorInteger(array('required' =>false)),
            'eventType'=> new sfValidatorChoice(array('required' => true,'choices' => array_keys($this->eventTypes))),
            'description'=> new sfValidatorString(array('required'=>false)),
            'currency' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->currencies)))

        ));
        $this->widgetSchema->setLabels(array(
            'eventType'=> __('Event Type') .' <em>*</em>',
            'description'=> __('Description'),
            'currency'=> __('Currency') .' <em>*</em>',
        ));

        $this->getWidgetSchema()->setNameFormat('claimRequest[%s]');

        

    }

    /**
     * @return array
     * @throws AdminServiceException
     */
    private function _getCurrencies() {
        $currencies = $this->getCurrencyService()->getCurrencyList();
        $choices = array('' => '-- ' . __('Select') . ' --');

        foreach ($currencies as $currency) {
            $choices[$currency->getCurrencyId()] = $currency->getCurrencyName();
        }
        return $choices;
    }

    /**
     * @return array
     * @throws DaoException
     */
    private function getEventList() {
        $eventList = $this->getEventService()->getEventList();
        $list = array('' => '-- ' . __('Select') . ' --');
        foreach ($eventList as $event) {
            $list[$event->getId()] = $event->getName();
        }
        return $list;
    }
}