<?php

/**
 * ExpenseTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ExpenseTable extends PluginExpenseTable
{
    /**
     * Returns an instance of this class.
     *
     * @return ExpenseTable The table instance
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Expense');
    }
}