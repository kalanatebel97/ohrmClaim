$(document).ready(function () {

    $('.assign-claim-submit-btn#btnSave').click(function(e) {
        e.stopImmediatePropagation();
        if ($('.assign-claim-submit-btn#btnSave').val() == lang_edit) {
            $('#assignClaim_empName_empName').removeAttr('disabled');
            $('#assignClaim_eventType').removeAttr('disabled');
            $('#assignClaim_currency').removeAttr('disabled');
            $('#assignClaim_description').removeAttr('disabled');
            $('.assign-claim-submit-btn#btnSave').val(lang_save);

        }else if($('.assign-claim-submit-btn#btnSave').val() == lang_save) {
            e.preventDefault();
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
                $('.modal hide').hide();


            }
        }
    });

    $.validator.addMethod("validEmployeeName", function(value, element) {

        return autoFill('assignClaim_empName_empName', 'assignClaim_empName_empId', employees_assignClaim_empName);

    });

    function autoFill(selector, filler, data) {
        $("#" + filler).val("");
        var valid = false;
        $.each(data, function(index, item){
            if(item.name.toLowerCase() == $("#" + selector).val().toLowerCase()) {
                $("#" + filler).val(item.id);
                valid = true;
            }
        });
        return valid;
    }

    $('#frmSubmitClaim').validate({
        rules: {
            'assignClaim[empName][empName]': {
                required:true,
                maxlength: 200,
                validEmployeeName: true

            },
            'assignClaim[eventType]': {
                required: true,

            },
            'assignClaim[description]': {
                required: false,
                'maxlength': 1000
            },
            'assignClaim[currency]': {
                required: true,
                'maxlength': 1000
            },

        },
        messages: {

            'assignClaim[empName][empName]': {
                required: lang_required,
                validEmployeeName: lang_required,

            },
            'assignClaim[eventType]': {
                required: lang_required,
            },
            'assignClaim[description]': {
                'maxlength': lang_maxChars
            },
            'assignClaim[currency]': {
                required: lang_required,

            },
        }
    });

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
    $('#btnDelete').attr('disabled', 'disabled');


    $("#ohrmList_chkSelectAll").click(function() {
        if($(":checkbox").length == 1) {
            $('#btnDelete').attr('disabled','disabled');
        }
        else {
            if($("#ohrmList_chkSelectAll").is(':checked')) {
                $('#btnDelete').removeAttr('disabled');
            } else {
                $('#btnDelete').attr('disabled','disabled');
            }
        }
    });
    $(':checkbox[name*="chkSelectRow[]"]').click(function() {
        if($(':checkbox[name*="chkSelectRow[]"]').is(':checked')) {
            $('#btnDelete').removeAttr('disabled');
        } else {
            $('#btnDelete').attr('disabled','disabled');
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

    if(ClaimId > 0 ){
        $('#assignClaim_empName_empName').attr('disabled','disabled');
        $('#assignClaim_eventType').attr('disabled','disabled');
        $('#assignClaim_currency').attr('disabled','disabled');
        $('#assignClaim_description').attr('disabled','disabled');
        $('.assign-claim-submit-btn#btnSave').val(lang_edit);

    }

    $('#dialogExpenseDeleteBtn').click(function () {
        $('#deleteConfirmation').modal();
    });


    $('#btnAdd').click(function () {
        $('#addExpenseModalLink').click();

    });
    $('#btnCancelSave').click(function () {
        $('#addExpenseModal').hide();

    });

    $('#frmList_ohrmListComponent').attr('name', 'frmList_ohrmListComponent');
    $('#dialogExpenseDeleteBtn').click(function() {
        document.frmList_ohrmListComponent.submit();
    });
    $('#dialogCancelBtn').click(function () {
        $("#deleteConfirmation").dialog("close");
    });

    $('a[href="javascript:"]').click(function(){
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

