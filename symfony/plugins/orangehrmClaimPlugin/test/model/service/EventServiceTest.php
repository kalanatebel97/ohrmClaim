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
 * Class EventServiceTest
 * @group Event
 */
class EventServiceTest extends PHPUnit_Framework_TestCase
{
    protected $eventService;

    protected function setUp()
    {
        $this->eventService = new EventService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmClaimPlugin/test/fixtures/EventDao.yml';
        TestDataService::populate($this->fixture);
    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testGetEventById()
    {

        $id = 3;
        $claimEvent = new ClaimEvent();
        $claimEvent->setName('event3');
        $claimEvent->setId($id);

        $mockDao = $this->getMockBuilder('EventDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getEventById')
            ->with($id)
            ->will($this->returnValue($claimEvent));

        $this->eventService->setEventDao($mockDao);

        $retVal = $this->eventService->getEventById($id);

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

        $this->eventService->setEventDao($mockDao);

        $result = $this->eventService->deleteEvents($id);
        $this->assertEquals(23, $result);
    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testGetEventList()
    {


        $id = 2;
        $claimEvent = new ClaimEvent();
        $claimEvent->setName('event2');
        $claimEvent->setId($id);

        $mockDao = $this->getMockBuilder('EventDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getEventList')
            ->with($id)
            ->will($this->returnValue($claimEvent));

        $this->eventService->setEventDao($mockDao);

        $retVal = $this->eventService->getEventList($id);

        $this->assertEquals($claimEvent, $retVal);


    }

    public function testGetEventCount()
    {
        $eventDao = $this->getMockBuilder('EventDao')->getMock();
        $eventDao->expects($this->once())
            ->method('getEventCount')
            ->with("")
            ->will($this->returnValue(2));

        $this->eventService->setEventDao($eventDao);

        $result = $this->eventService->getEventCount("");
        $this->assertEquals($result, 2);

    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testSaveEvent()
    {
        $data = array(
            'name' => 'Event Event',
            'description' => 'Event Event Description'
        );


        $mockEventType = new ClaimEvent();
        $mockEventType->setId(1);
        $mockEventType->setName($data['name']);
        $mockEventType->setDescription($data['description']);

        $mockDao = $this->getMockBuilder('EventDao')->getMock();
        $mockDao->expects($this->once())
            ->method('saveEvent')
            ->will($this->returnValue($mockEventType));

        $this->eventService->setEventDao($mockDao);


        $result = $this->eventService->saveEvent($data);
        $this->assertTrue($result instanceof ClaimEvent);
        $this->assertEquals($result->getName(), $data['name']);
        $this->assertEquals($result->getDescription(), $data['description']);


        $this->assertTrue($result->getId() > 0);
    }
}