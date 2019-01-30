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

use_stylesheet(plugin_web_path('orangehrmClaimPlugin', 'css/createEvent'));
use_javascript(plugin_web_path('orangehrmClaimPlugin', 'js/viewEventSuccess'));



?>

<div class="box" id="createEvent">
    <div class="head">
        <h1 id="saveFormHeading">Create Event</h1>
    </div>
    <div class="inner" id="innerDiv">

        <?php include_partial('global/flash_messages'); ?>
        <form name="frmCreateEvent" id="frmCreateEvent" method="post"
              action="<?php echo url_for('claim/CreateEvent'); ?>">

            <?php echo $form->renderHiddenFields(); ?>

            <fieldset>

                <ol>
                    <li class="largeTextBox">
                        <?php echo $form['name']->renderLabel(); ?>
                        <?php echo $form['name']->render(array("class" => "block default editable valid")); ?>
                    </li>
                    <li class="largeTextBox">
                        <?php echo $form['description']->renderLabel(); ?>
                        <?php echo $form['description']->render(array("class" => "editable","maxlength" => 1000)); ?>
                    </li>

                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                </ol>

                <p>
                    <input type="submit" class="" name="btnCreate" id="btnCreate" value="<?php echo __('Create') ?>"/>
                    <input type="button" class="btn reset" name="btnCancel" id="btnCancel"
                           value="<?php echo __("Cancel"); ?>"/>
                </p>

            </fieldset>

        </form>

    </div> <!-- End-inner -->
</div>

<div id="eventList">
    <?php //include_component('core', 'ohrmList'); ?>
</div>

<!-- Confirmation box HTML: Begins -->
<div class="modal hide" id="deleteConfModal">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('OrangeHRM - Confirmation Required'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo __(CommonMessages::DELETE_CONFIRMATION); ?></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn" data-dismiss="modal" id="dialogDeleteBtn" value="<?php echo __('Ok'); ?>" />
        <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
    </div>
</div>

<script type="text/javascript">

    var lang_required = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var lang_maxChars = '<?php echo __(ValidationMessages::TEXT_LENGTH_EXCEEDS, array('%amount%' => 255)); ?>';
    var viewEventUrl = '<?php echo url_for('claim/ViewEvent'); ?>';
</script>