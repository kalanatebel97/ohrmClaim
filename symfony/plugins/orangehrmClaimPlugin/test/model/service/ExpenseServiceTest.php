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
 * Class ExpenseServiceTest
 * @group Expense
 */
class ExpenseServiceTest extends PHPUnit_Framework_TestCase
{

    protected $expenseService;

    protected function setUp()
    {
        $this->expenseService = new ExpenseService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmClaimPlugin/test/fixtures/ExpenseDao.yml';
        TestDataService::populate($this->fixture);
    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testSaveExpenseType()
    {

        $data = array(
            'name' => 'Expense',
            'description' => 'ExpenseDescription'
        );


        $mockExpenseType = new ExpenseType();
        $mockExpenseType->setId(1);
        $mockExpenseType->setName($data['name']);
        $mockExpenseType->setDescription($data['description']);
        $mockExpenseType->setStatus($data['status']);

        $mockDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $mockDao->expects($this->once())
            ->method('saveExpenseType')
            ->will($this->returnValue($mockExpenseType));

        $this->expenseService->setExpenseDao($mockDao);

        $result = $this->expenseService->saveExpenseType($data);
        $this->assertTrue($result instanceof ExpenseType);
        $this->assertEquals($result->getName(), $data['name']);
        $this->assertEquals($result->getDescription(), $data['description']);
        $this->assertEquals($result->getStatus(), $data['status']);

        $this->assertTrue($result->getId() > 0);
    }

    public function testGetExpenseTypeCount()
    {

        $expenseDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $expenseDao->expects($this->once())
            ->method('getExpenseTypeCount')
            ->with("")
            ->will($this->returnValue(2));

        $this->expenseService->setExpenseDao($expenseDao);

        $result = $this->expenseService->getExpenseTypeCount("");
        $this->assertEquals($result, 2);
    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testGetExpenseTypeById()
    {

        $id = 3;
        $expenseType = new ExpenseType();
        $expenseType->setName('expense');
        $expenseType->setId($id);

        $mockDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getExpenseTypeById')
            ->with($id)
            ->will($this->returnValue($expenseType));

        $this->expenseService->setExpenseDao($mockDao);

        $retVal = $this->expenseService->getExpenseById($id);

        $this->assertEquals($expenseType, $retVal);
    }

    /**
     * @throws Doctrine_Connection_Exception
     * @throws Doctrine_Record_Exception
     */
    public function testGetExpenseTypesList()
    {

        $id = 2;
        $expenseType = new ExpenseType();
        $expenseType->setName('expense2');
        $expenseType->setId($id);

        $mockDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getExpenseTypeList')
            ->with($id)
            ->will($this->returnValue($expenseType));

        $this->expenseService->setExpenseDao($mockDao);

        $retVal = $this->expenseService->getExpenseList($id);

        $this->assertEquals($expenseType, $retVal);
    }

    public function testDeleteExpenseTypes()
    {
        $id = 3;
        $mockDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $mockDao->expects($this->once())
            ->method('deleteExpenseTypes')
            ->with($id)
            ->will($this->returnValue(23));

        $this->expenseService->setExpenseDao($mockDao);

        $result = $this->expenseService->deleteExpenseTypes($id);
        $this->assertEquals(23, $result);
    }

    public function testSaveExpense()
    {
        $data = array(
            'name' => 'Expense',
            'description' => 'ExpenseDescription'
        );


        $mockExpense = new Expense();
        $mockExpense->setId(1);
        $mockExpense->setExpenseType($data['expenseType']);
        $mockExpense->setDate($data['date']);
        $mockExpense->setAmount($data['amount']);
        $mockExpense->setNote($data['note']);

        $mockDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $mockDao->expects($this->once())
            ->method('saveExpense')
            ->will($this->returnValue($mockExpense));

        $this->expenseService->setAddExpenseDao($mockDao);

        $result = $this->expenseService->saveExpense($data);
        $this->assertTrue($result instanceof Expense);
        $this->assertEquals($result->getExpenseType(), $data['expenseType']);
        $this->assertEquals($result->getDate(), $data['date']);
        $this->assertEquals($result->getAmount(), $data['amount']);
        $this->assertEquals($result->getNote(), $data['note']);


        $this->assertTrue($result->getId() > 0);

    }

    public function testGetExpenseCount()
    {

        $expenseDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $expenseDao->expects($this->once())
            ->method('getExpenseCount')
            ->with("")
            ->will($this->returnValue(2));

        $this->addExpenseService->setAddExpenseDao($expenseDao);

        $result = $this->addExpenseService->getExpenseCount("");
        $this->assertEquals($result, 2);
    }

    public function testGetExpenseById()
    {

        $id = 2;
        $expense = new Expense();
        $expense->setExpenseType('expenseType');
        $expense->setId($id);

        $mockDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getExpenseById')
            ->with($id)
            ->will($this->returnValue($expense));

        $this->addExpenseService->setAddExpenseDao($mockDao);

        $retVal = $this->addExpenseService->getExpenseById($id);

        $this->assertEquals($expense, $retVal);
    }

    public function testGetExpenseList()
    {

        $id = 2;
        $expense = new Expense();
        $expense->setName('expense2');
        $expense->setId($id);

        $mockDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $mockDao->expects($this->once())
            ->method('getExpenseList')
            ->with($id)
            ->will($this->returnValue($expense));

        $this->expenseService->setExpenseDao($mockDao);

        $retVal = $this->expenseService->getExpenseList($id);

        $this->assertEquals($expense, $retVal);
    }

    public function testDeleteExpenses()
    {
        $id = 3;
        $mockDao = $this->getMockBuilder('ExpenseDao')->getMock();
        $mockDao->expects($this->once())
            ->method('deleteExpenses')
            ->with($id)
            ->will($this->returnValue(23));

        $this->expenseService->setExpenseDao($mockDao);

        $result = $this->expenseService->deleteExpenses($id);
        $this->assertEquals(23, $result);
    }


}