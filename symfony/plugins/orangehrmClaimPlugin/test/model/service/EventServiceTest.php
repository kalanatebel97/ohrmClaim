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

/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 31/12/18
 * Time: 9:44 AM
 */
class CreateEventServiceTest extends PHPUnit_Framework_TestCase
{
       protected $createEventService;

    protected function setUp() {
        $this->CreateEventService = new EventService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmClaimPlugin/test/fixtures/EventDao.yml';
        TestDataService::populate($this->fixture);
    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testGetEventById()
    {
        $id = 2;
        $claimEvent = new ClaimEvent();
        $claimEvent->setName('event2');
        $claimEvent->setId($id);

        $mockDao = $this->getMockBuilder('EventDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getEventById')
            ->with($id)
            ->will($this->returnValue($id));

        $this->createEventService->setCreateEventDao($mockDao);

        $retVal = $this->createEventService->getEventById($id);

        $this->assertEquals($claimEvent, $retVal);

    }


    public function testDeleteEvents()
    {
        $id = 3;
        $mockDao = $this->getMockBuilder('EventDao')->getMock();
        $mockDao->expects($this->once())
            ->method('deleteEvents')
            ->with($id)
            ->will($this->returnValue(23));

        $this->createEventService->setCreateEventDao($mockDao);

        $result = $this->createEventService->deleteEvents($id);
        $this->assertEquals(23, $result);
    }
}