<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 27/12/18
 * Time: 12:28 PM
 */

class EmployeeClaimEventTypeListConfigurationFactory extends ohrmListConfigurationFactory {



    protected function init(){

        parent::init(); // TODO: Change the autogenerated stub
        $header1 = new ListHeader();
        $header2 = new ListHeader();


        $header1->populateFromArray(array(

            'name' => __('Event Name'),
            'isSortable' => true,
            'elementType' => 'link',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array(
                'labelGetter' => 'getName',
                'linkable' => true,
                'placeholderGetters' => array('id' => 'getId'),
                'urlPattern' => 'createEvent?id={id}'),
            //'urlPattern' => public_path('index.php/empTask/employeeAddTaskForm/taskId/{id}'),
        ));

        $header2->populateFromArray(array(

            'name' => __('Description'),
            'isSortable' => false,
            'elementType' => 'label',
            'textAlignmentStyle' => 'left',
            'elementProperty' => array('getter' => 'getDescription'),
            'elementProperty' => array(
                'getter' => array('getDescription')
            )

        ));

        $this->headers = array($header1, $header2);
    }

    /**
     * @return string
     */
    public function getClassName() {

        // TODO: Implement getClassName() method.
        return 'ClaimEvent';
    }

}
