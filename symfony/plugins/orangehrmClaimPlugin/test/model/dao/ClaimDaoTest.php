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
 * Class ClaimDaoTest
 * @group ClaimDao
 */
class ClaimDaoTest extends PHPUnit_Framework_TestCase
{
    protected $claimDao;

    protected function setUp()
    {
        $this->claimDao = new ClaimDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmClaimPlugin/test/fixtures/ClaimDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testSaveClaim()
    {
        $claimData = array();
        $claimData['eventType'] = 'Test Event1';
        $claimData['description'] = 'Test event 1 description';
        $claimData['currency'] = 'lkr';

        $claimObj = $this->claimDao->saveClaim($claimData);

        $this->assertEquals('Test Event1', $claimObj->getEventType());
        $this->assertEquals('Test event 1 description', $claimObj->getDescription());
        $this->assertEquals('lkr', $claimObj->getCurrency());
    }

    public function testSaveAssignClaim()
    {
        $assignClaimData = array();
        $assignClaimData['empName'] = 'Kalana';
        $assignClaimData['eventType'] = 'Test Event1';
        $assignClaimData['description'] = 'Test event 1 description';
        $assignClaimData['currency'] = 'lkr';

        $assignClaimObj = $this->claimDao->saveClaim($assignClaimData);

        $this->assertEquals('Kalana', $assignClaimObj->getEmployee->getEmployeeName());
        $this->assertEquals('Test Event1', $assignClaimObj->getEventType());
        $this->assertEquals('Test event 1 description', $assignClaimObj->getDescription());
        $this->assertEquals('lkr', $assignClaimObj->getCurrency());
    }

    public function testGetClaimCount()
    {
        $result = $this->claimDao->getClaimCount(false);
        $this->assertEquals(4, $result);
    }

    public function testGetAssignClaimCount()
    {
        $result = $this->claimDao->getAssignClaimCount(false);
        $this->assertEquals(4, $result);
    }

    public function testGetClaimById()
    {
        $result = $this->claimDao->getClaimById(2);
        $this->assertEquals($result->getEventType(), "event2");
    }

    public function testGetAssignClaimById()
    {
        $result = $this->claimDao->getAssignClaimById(2);
        $this->assertEquals($result->getEventType(), "event2");
    }

    public function testGetClaimType()
    {
        $result = $this->claimDao->getClaimType("", "", "", "", false);
        $this->assertEquals(4, count($result));
    }

    public function testGetAssignClaimType()
    {
        $result = $this->claimDao->getAssignClaimType("", "", "", "", false);
        $this->assertEquals(4, count($result));
    }

    public function testDeleteClaims()
    {
        $this->claimDao->deleteClaims(3);
        $claimRequests = $this->claimDao->getEventById(3);
        $this->assertFalse($claimRequests instanceof ClaimRequest);
    }

    public function testDeleteAssignClaims()
    {
        $this->claimDao->deleteAssignClaims(3);
        $claimRequests = $this->claimDao->getEventById(3);
        $this->assertFalse($claimRequests instanceof ClaimRequest);
    }
}