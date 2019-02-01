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
 * Class EventDaoTest
 * @group Event
 */
class EventDaoTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {

        $this->eventDao = new EventDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmClaimPlugin/test/fixtures/EventDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testSaveEvent(){

        $eventData = array();
        $eventData['name'] = 'Test Event1';
        $eventData['description'] = 'Test event 1 description';

        $eventObj = $this->eventDao->saveEvent($eventData);

        $this->assertEquals('Test Event1', $eventObj->getName());
        $this->assertEquals('Test event 1 description', $eventObj->getDescription());
    }

    public function testGetEventById() {

        $result = $this->eventDao->getEventById(2);
        $this->assertEquals($result->getName(), "event2");
    }

    public function testGetEventList() {

        $result = $this->eventDao->getEventList("", "", "", "", false);
        $this->assertEquals(4, count($result));
    }

    public function testDeleteEvents() {

        $this->eventDao->deleteEvents(3);
        $claimEvents = $this->eventDao->getEventById(3);
        $this->assertFalse($claimEvents instanceof ClaimEvent);



    }

    public function testGetEventCount() {

        $result = $this->eventDao->getEventCount(false);
        $this->assertEquals(4, $result);
    }


}