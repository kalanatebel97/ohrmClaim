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

use_stylesheet(plugin_web_path('orangehrmClaimPlugin', 'css/submitClaim'));
use_javascript(plugin_web_path('orangehrmClaimPlugin', 'js/submitClaim'));
?>

<div class="box" id="submitClaim">
    <div class="head">
        <h1 id="saveFormHeading">Submit Claim</h1>
    </div>
    <div class="inner" id="innerDiv">

        <?php include_partial('global/flash_messages'); ?>
        <form name="frmSubmitClaim" id="frmSubmitClaim" method="post"
              action="<?php echo url_for('claim/submitClaim'); ?>">

            <?php echo $form->renderHiddenFields(); ?>
            <fieldset>

                <ol>
                    <li>
                        <?php echo $form['eventType']->renderLabel(); ?>
                        <?php echo $form['eventType']->render(array("class" => "block default editable valid")); ?>
                    </li>
                    <li>
                        <?php echo $form['description']->renderLabel(); ?>
                        <?php echo $form['description']->render(array("class" => "editable")); ?>
                    </li>
                    <li>
                        <?php echo $form['currency']->renderLabel(); ?>
                        <?php echo $form['currency']->render(array("class" => "block default editable valid")); ?>
                    </li>

                    <li class="required">
                        <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                    </li>
                </ol>

                <p>
                    <input type="submit" class="editable claim-submit-btn" name="btnSave" id="btnSave" value="<?php echo __('Create') ?>"/>
                    <input type="button" class="btn reset" name="btnCancel" id="btnCancel"
                           value="<?php echo __("Cancel"); ?>"/>
                </p>

            </fieldset>

        </form>
        <?php if (!is_null($claimId)) { ?>
            <div class="expenseList" id="">
                <?php include_component('core', 'ohrmList'); ?>
            </div>
        <?php } ?>


        <?php if (!is_null($claimId)) { ?>
            <div class="attachmentList" >
                <?php echo include_component('claim', 'claimAttachments', array('claimId' => $claimId)); ?>
            </div>
        <?php } ?>

    </div> <!-- End-inner -->
</div>
<?php if (!is_null($claimId)) { ?>

    <div class="modal hide" id="addExpenseModal">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3><?php echo __('Add Expense'); ?></h3>
        </div>
        <div class="modal-body">
            <form name="frmAddExpense" id="frmAddExpense" method="post"
                  action="<?php echo url_for('claim/addExpense') . "?claimId=$claimId"; ?>">
                <?php echo $addExpenseform->renderHiddenFields(); ?>
                <fieldset>
                    <ol>
                        <li>
                            <?php echo $addExpenseform['expenseType']->renderLabel(); ?>
                            <?php echo $addExpenseform['expenseType']->render(array("class" => "block default editable valid")); ?>
                        </li>
                        <li>
                            <?php echo $addExpenseform['date']->renderLabel(); ?>
                            <?php echo $addExpenseform['date']->render(array("class" => "block default editable valid")); ?>
                        </li>
                        <li>
                            <?php echo $addExpenseform['amount']->renderLabel(); ?>
                            <?php echo $addExpenseform['amount']->render(array("class" => "block default editable valid")); ?>
                        </li>
                        <li>
                            <?php echo $addExpenseform['note']->renderLabel(); ?>
                            <?php echo $addExpenseform['note']->render(array("class" => "editable", "maxlength" => 1000)); ?>
                        </li>

                        <li class="required">
                            <em>*</em> <?php echo __(CommonMessages::REQUIRED_FIELD); ?>
                        </li>
                    </ol>
                </fieldset>
        </div>
        <div class="modal-footer">
            <input type="button" class="editable addExpense-submit-btn" name="btnSave" id="btnSave" value="<?php echo __('Save') ?>"/>
            <input type="button" class="btn reset" name="btnCancelSave" id="btnCancelSave"
                   value="<?php echo __("Cancel"); ?>"/>
        </div>
    </div>
<?php } ?>

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
        <input type="button" class="btn" data-dismiss="modal" id="dialogExpenseDeleteBtn" value="<?php echo __('Ok'); ?>" />
        <input type="button" class="btn reset" data-dismiss="modal" value="<?php echo __('Cancel'); ?>" />
    </div>
</div>

<a id="addExpenseModalLink" class="hidden" data-toggle="modal" href="#addExpenseModal" ></a>

<script type="text/javascript">

    var lang_required = '<?php echo __(ValidationMessages::REQUIRED); ?>';
    var lang_maxChars = '<?php echo __(ValidationMessages::TEXT_LENGTH_EXCEEDS, array('%amount%' => 255)); ?>';
    var viewClaimUrl = '<?php echo url_for('claim/viewClaim'); ?>';
    var lang_editClaim = "<?php echo __("Edit Claim"); ?>";
    var lang_edit = "<?php echo __("Edit"); ?>"
    var lang_create = "<?php echo __("Create"); ?>";
    var lang_save = "<?php echo __("Save");?>";
    var claimId = '<?php echo $claimId;?>';
    var edit_form_heading = "<?php echo __("Edit Claim"); ?>"
    var saveFormHeading          = "<?php echo __("Submit Claim"); ?>";
    var getExpsenseURL = '<?php echo url_for('claim/getExpenseAjax'); ?>';
    var lang_invalidDecimal= '<?php echo __('Should be a valid number (xxx.xx)'); ?>';

</script>