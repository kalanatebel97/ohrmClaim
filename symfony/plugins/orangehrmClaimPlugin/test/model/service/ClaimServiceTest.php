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
 * Class ClaimServiceTest
 * @group ClaimService
 */
class ClaimServiceTest extends PHPUnit_Framework_TestCase
{
    protected $claimService;

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testGetClaimType()
    {
        $id = 2;
        $claimRequest = new ClaimRequest();
        $claimRequest->setEventType('event2');
        $claimRequest->setId($id);

        $mockDao = $this->getMockBuilder('ClaimDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getClaimType')
            ->with($id)
            ->will($this->returnValue($claimRequest));

        $this->claimService->setClaimDao($mockDao);

        $retVal = $this->claimService->getClaimType($id);

        $this->assertEquals($claimRequest, $retVal);

    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testSaveClaim()
    {
        $data = array(
            'name' => 'test claim',
            'description' => 'test claim Description',
            'currency' => 'lkr'
        );

        $mockClaimRequest = new ClaimRequest();
        $mockClaimRequest->setId(1);
        $mockClaimRequest->setEventType($data['eventType']);
        $mockClaimRequest->setDescription($data['description']);
        $mockClaimRequest->setCurrency($data['currency']);

        $mockDao = $this->getMockBuilder('ClaimDao')->getMock();
        $mockDao->expects($this->once())
            ->method('saveClaim')
            ->will($this->returnValue($mockClaimRequest));

        $this->claimService->setClaimDao($mockDao);

        $result = $this->claimService->saveClaim($data);
        $this->assertTrue($result instanceof ClaimRequest);
        $this->assertEquals($result->getEventType(), $data['eventType']);
        $this->assertEquals($result->getDescription(), $data['description']);
        $this->assertEquals($result->getCurrency(), $data['currency']);

        $this->assertTrue($result->getId() > 0);
    }

    public function testGetClaimCount()
    {
        $claimDao = $this->getMockBuilder('ClaimDao')->getMock();
        $claimDao->expects($this->once())
            ->method('getClaimCount')
            ->with("")
            ->will($this->returnValue(2));

        $this->claimService->setClaimDao($claimDao);

        $result = $this->claimService->getClaimCount("");
        $this->assertEquals($result, 2);

    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testGetClaimbyId()
    {
        $id = 3;
        $claimRequest = new ClaimRequest();
        $claimRequest->setEventType('event3');
        $claimRequest->setId($id);

        $mockDao = $this->getMockBuilder('ClaimDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getClaimById')
            ->with($id)
            ->will($this->returnValue($claimRequest));

        $this->claimService->setClaimDao($mockDao);

        $retVal = $this->claimService->getClaimById($id);

        $this->assertEquals($claimRequest, $retVal);
    }

    public function testDeleteClaims()
    {
        $id = 3;
        $mockDao = $this->getMockBuilder('ClaimDao')->getMock();
        $mockDao->expects($this->once())
            ->method('deleteClaims')
            ->with($id)
            ->will($this->returnValue(23));

        $this->claimService->setClaimDao($mockDao);

        $result = $this->claimService->deleteClaims($id);
        $this->assertEquals(23, $result);
    }

    protected function setUp()
    {
        $this->claimService = new ClaimService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmClaimPlugin/test/fixtures/ClaimDao.yml';
        TestDataService::populate($this->fixture);
    }
}