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

class EmployeeClaimExpensesListConfigurationFactory extends ohrmListConfigurationFactory
{
    protected function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $header1 = new ListHeader();
        $header2 = new ListHeader();
        $header3 = new ListHeader();
        $header4 = new ListHeader();

        $header1->populateFromArray(array(
            'name' => __('Expense Type'),
            'isSortable' => true,
            'elementType' => 'link',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'labelGetter' => array('getExpenseType', 'getName'),
                'linkable' => true,
                'placeholderGetters' => array('id' => 'getId'),
                'urlPattern' => 'javascript:',
                'hasHiddenField'=>true,
                'hiddenFieldClass' => 'edit-expense',
                'hiddenFieldValueGetter'=>'getId'
            )
        ));
        $header2->populateFromArray(array(

            'name' => __('Date'),
            'isSortable' => false,
            'elementType' => 'labelDate',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'getter' => array('getDate')

            )
        ));

        $header3->populateFromArray(array(

            'name' => __('Note'),
            'isSortable' => false,
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'getter' => array('getNote')

            )
        ));
        $header4->populateFromArray(array(

            'name' => __('Amount'),
            'isSortable' => false,
            'elementType' => 'label',
            'textAlignmentStyle' => 'right',
            'elementProperty' => array(
                'getter' => array('getAmount')

            )
        ));
        $this->headers = array($header1, $header2, $header3, $header4);
    }

    public function getClassName()
    {
        return 'Expense';
    }

}