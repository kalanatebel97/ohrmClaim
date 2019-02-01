$(document).ready(function () {

    $('.claim-submit-btn#btnSave').click(function(e) {
        e.stopImmediatePropagation();
        if ($('.claim-submit-btn#btnSave').val() == lang_edit) {
            $('#saveFormHeading').text(saveFormHeading);
            $('#claimRequest_eventType').removeAttr('disabled');
            $('#claimRequest_description').removeAttr('disabled');
            $('#claimRequest_currency').removeAttr('disabled');
            $('.claim-submit-btn#btnSave').val(lang_save);

        }else if($('.claim-submit-btn#btnSave').val() == lang_save) {
            e.preventDefault();
            e.stopImmediatePropagation();
            if ($('#frmSubmitClaim').valid()) {
                $('#frmSubmitClaim').submit();

            }
        }
    });
    $('.addExpense-submit-btn#btnSave').click(function(e) {
        e.stopImmediatePropagation();
        if ($('.addExpense-submit-btn#btnSave').val() == lang_edit) {
            $('#addExpense_expenseType').removeAttr('disabled');
            $('#assignExpense_dueDate').removeAttr('disabled');
            $('#addExpense_amount').removeAttr('disabled');
            $('#addExpense_note').removeAttr('disabled');
            $('.addExpense-submit-btn#btnSave').val(lang_save);

        }else if($('.addExpense-submit-btn#btnSave').val() == lang_save) {
            e.preventDefault();
            if ($('#frmAddExpense').valid()) {
                $('#frmAddExpense').submit();
            }
        }
    });

    if(claimId > 0 ){
        $('#saveFormHeading').text(edit_form_heading);
        $('#claimRequest_eventType').attr('disabled','disabled');
        $('#claimRequest_description').attr('disabled','disabled');
        $('#claimRequest_currency').attr('disabled','disabled');
        $('.claim-submit-btn#btnSave').val(lang_edit);

    }
    $('#frmAddExpense').validate({
        rules: {
            'addExpense[expenseType]': {
                required: true,
            },
            'addExpense[date]': {
                required: true,

            },
            'addExpense[amount]': {
                required: true,
                decimal: true,
            },
            'addExpense[note]': {
                required: false,
                'maxlength': 1000
            },

        },
        messages: {

            'addExpense[expenseType]': {
                required: lang_required
            },
            'addExpense[date]': {
                required: lang_required
            },
            'addExpense[amount]': {
                required: lang_required,
                decimal: lang_invalidDecimal
            },
            'addExpense[note]': {
                'maxlength': lang_maxChars
            },
        }
    });

    $('#btnCancel').click(function () {
        window.location.replace(viewClaimUrl);
    });


    $('#frmSubmitClaim').validate({
        rules: {
            'claimRequest[eventType]': {
                required: true,
            },
            'claimRequest[description]': {
                required: false,
                'maxlength': 1000
            },
            'claimRequest[currency]': {
                required: true,

            },

        },
        messages: {
            'claimRequest[eventType]': {
                required: lang_required,

            },
            'claimRequest[description]': {

                'maxlength': lang_maxChars
            },
            'claimRequest[currency]': {
                required: lang_required,

            },

        }
    });
    $('#dialogExpenseDeleteBtn').attr('disabled', 'disabled');


    $("#ohrmList_chkSelectAll").click(function() {
        if($(":checkbox").length == 1) {
            $('#dialogExpenseDeleteBtn').attr('disabled','disabled');
        }
        else {
            if($("#ohrmList_chkSelectAll").is(':checked')) {
                $('#dialogExpenseDeleteBtn').removeAttr('disabled');
            } else {
                $('#dialogExpenseDeleteBtn').attr('disabled','disabled');
            }
        }
    });

    $(':checkbox[name*="chkSelectRow[]"]').click(function() {
        if($(':checkbox[name*="chkSelectRow[]"]').is(':checked')) {
            $('#dialogExpenseDeleteBtn').removeAttr('disabled');
        } else {
            $('#dialogExpenseDeleteBtn').attr('disabled','disabled');
        }
    });

    $('#dialogExpenseDeleteBtn').click(function () {
        $('#frmList_ohrmListComponent').submit(function () {
            $('#deleteConfirmation').dialog('open');
            return false;
        });
    });

    $('#frmList_ohrmListComponent').attr('name', 'frmList_ohrmListComponent');
    $('#dialogExpenseDeleteBtn').click(function () {
        document.frmList_ohrmListComponent.submit();
    });
    $('#dialogCancelBtn').click(function () {
        $("#deleteConfirmation").dialog("close");
    });
    $('#btnAdd').click(function () {
        $('#addExpenseModalLink').click();

    });
    $('#btnCancelSave').click(function () {
        $('#addExpenseModal').hide();

    });
    $('a[href="javascript:"]').click(function() {
            var me = $(this);
            var expenseId = (me.next('.edit-expense').val());
            openModal(expenseId);
        }

    );

    $.validator.addMethod('decimal', function (value, element) {
        return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
    }, lang_invalidDecimal);

});
function openModal(expenseId){
    //AJAX => with ID
    $.ajax({
        method: "GET",
        data: {expenseID: expenseId},
        url: getExpsenseURL,
        dataType: 'json',
        success: function (result) {
            var data = result.data;
            $('#addExpense_expenseType').val(data.expenseTypeId);
            $('#assignExpense_dueDate').val(data.date);
            $('#addExpense_amount').val(data.amount);
            $('#addExpense_note').val(data.note);
            $('#addExpense_id').val(data.id);

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        }
    });
    $('#btnAdd').click();

}



