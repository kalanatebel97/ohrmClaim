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
 * Class ExpenseDaoTest
 * @group Expense
 */
class ExpenseDaoTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {

        $this->expenseDao = new ExpenseDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmClaimPlugin/test/fixtures/ExpenseDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testSaveExpenseType()
    {
        $expenseData = array();
        $expenseData['name'] = 'Test Expense';
        $expenseData['description'] = 'Test Expense 1 description';
        $expenseData['status'] = 'Test Expense 1 status';

        $expenseObj = $this->expenseDao->saveExpenseType($expenseData);

        $this->assertEquals('Test Expense', $expenseObj->getName());
        $this->assertEquals('Test Expense 1 description', $expenseObj->getDescription());
        $this->assertEquals('Test Expense 1 status', $expenseObj->getStatus());

    }

    public function testSaveExpense()
    {
        $expenseData = array();
        $expenseData['expenseType'] = 'Test Expense1';
        $expenseData['date'] = 'Test Expense1  description';
        $expenseData['amount'] = 'Test Expense1 amount';
        $expenseData['note'] = 'Test Expense1 note';


        $expenseObj = $this->expenseDao->saveExpense($expenseData);

        $this->assertEquals('Test Expense1', $expenseObj->getExpenseType());
        $this->assertEquals('Test Expense1  description', $expenseObj->getDescription());
        $this->assertEquals('Test Expense1 amount', $expenseObj->getAmount());
        $this->assertEquals('Test Expense1 note', $expenseObj->getNote());


    }

    public function testGetExpenseTypeCount()
    {

        $result = $this->expenseDao->getExpenseTypeCount(false);
        $this->assertEquals(8, $result);
    }

    public function testGetExpenseCount()
    {

        $result = $this->expenseDao->getExpenseCount(false);
        $this->assertEquals(4, $result);
    }

    public function testGetExpenseTypeById()
    {

        $result = $this->expenseDao->getExpenseTypeById(3);
        $this->assertEquals($result->getName(), "expense3");
    }

    public function getExpenseByClaimRequestId()
    {

        $result = $this->expenseDao->getExpenseByClaimRequestId(3);
        $this->assertEquals($result->getName(), "expense3");
    }

    public function testGetExpenseTypesList()
    {

        $result = $this->expenseDao->getExpenseTypesList("", "", "", "", false);
        $this->assertEquals(5, count($result));
    }

    public function testGetExpenseList()
    {

        $result = $this->expenseDao->getExpenseList("", "", "", "", false);
        $this->assertEquals(4, count($result));
    }


    public function testDeleteExpenseTypes()
    {

        $this->expenseDao->deleteExpenseTypes(3);
        $expenseTypes = $this->expenseDao->getExpenseTypeById(3);
        $this->assertFalse($expenseTypes instanceof ExpenseType);
    }

    public function testDeleteExpenses()
    {

        $this->expenseDao->deleteExpenses(3);
        $expenseTypes = $this->expenseDao->getExpenseByClaimRequestId(3);
        $this->assertFalse($expenseTypes instanceof ExpenseType);
    }


}