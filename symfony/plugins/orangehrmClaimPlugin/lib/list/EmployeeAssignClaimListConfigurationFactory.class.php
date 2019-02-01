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


class EmployeeAssignClaimListConfigurationFactory extends ohrmListConfigurationFactory
{
    protected function init()
    {
        parent::init();
        $header1 = new ListHeader();
        $header2 = new ListHeader();
        $header3 = new ListHeader();
        $header4 = new ListHeader();

        $header1->populateFromArray(array(

            'name' => __('Employee Name'),
            'isSortable' => true,
            'elementType' => 'link',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'labelGetter' => array('getEmployee','getFirstName','getLastName'),
                'linkable' => true,
                'placeholderGetters' => array('id' => 'getId'),
                'urlPattern' => 'assignClaim?id={id}'
            )

        ));

        $header2->populateFromArray(array(

            'name' => __('Event Type'),
            'isSortable' => false,
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'getter' => array('getClaimEvent', 'getName'),

            )

        ));

        $header3->populateFromArray(array(

            'name' => __('Description'),
            'isSortable' => false,
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getDescription'),


        ));

        $header4->populateFromArray(array(

            'name' => __('Currency'),
            'isSortable' => false,
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getCurrency'),


        ));

        $this->headers = array($header1, $header2, $header3, $header4);
    }

    public function getClassName()
    {
        return 'ClaimRequest';
    }
}