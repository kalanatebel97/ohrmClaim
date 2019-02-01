$(document).ready(function () {

    $('#btnCreate').click(function(e) {
        e.stopImmediatePropagation();
        if ($('#btnCreate').val() == lang_edit_expense) {
            $('#saveFormHeading').text(saveFormHeading);
            $('#createExpense_name').removeAttr('disabled');
            $('#createExpense_description').removeAttr('disabled');
            $('#createExpense_status').removeAttr('disabled');

            $('#btnCreate').val(lang_create_expense);

        }else if($('#btnCreate').val() == lang_create_expense) {
            e.preventDefault();
            if ($('#frmCreateExpense').valid()) {
                $('#frmCreateExpense').submit();

            }
        }
    });


    $('#frmCreateExpense').validate({
        rules: {
            'createExpense[name]': {
                required: true,
                'maxlength': 255
            },
            'createExpense[description]': {
                required: true,
                'maxlength': 1000
            },


        },
        messages: {
            'createExpense[name]': {
                required: lang_required,
                'maxlength': lang_maxChars
            },
            'createExpense[description]': {
                required: lang_required,
                'maxlength': lang_maxChars
            }



        }
    });

    if(expenseId > 0 ){
        $('#saveFormHeading').text(edit_form_heading);
        $('#createExpense_name').attr('disabled','disabled');
        $('#createExpense_description').attr('disabled','disabled');
        $('#createExpense_status').attr('disabled','disabled');
        $('#btnCreate').val(lang_edit_expense);

    }
    $('#btnCancel').click(function () {
        window.location.replace(viewExpenseUrl);


    });

    $('#btnDelete').click(function () {
        $('#frmList_ohrmListComponent').submit(function () {
            $('#deleteConfirmation').dialog('open');
            return false;
        });
    });

    $('#frmList_ohrmListComponent').attr('name', 'frmList_ohrmListComponent');
    $('#dialogDeleteBtn').click(function () {
        document.frmList_ohrmListComponent.submit();
    });
    $('#dialogCancelBtn').click(function () {
        $("#deleteConfirmation").dialog("close");
    });


})

