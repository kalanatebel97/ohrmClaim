$(document).ready(function () {

    $('#btnAdd').click(function() {
        window.location.replace(addExpenseUrl);

    });

    $('#btnCancel').click(function() {
        window.location.replace(viewExpenseUrl);


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
            },


        }
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

    $('#btnCreate').click(function (e) {
        e.preventDefault();
        if ($('#frmCreateExpense').valid()) {
            $('#frmCreateExpense').submit();
            $('#frmCreateExpense').resetForm();
            window.location.replace(viewExpenseUrl);

        }
    });

})