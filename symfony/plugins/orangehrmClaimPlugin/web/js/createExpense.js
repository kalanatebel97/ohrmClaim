$(document).ready(function () {

    $('#frmCreateExpensesType').validate({
        rules: {
            'createExpenses[expenseName]': {
                required: true,
                'maxlength': 255
            },
            'createExpenses[description]': {
                required: false,
                'maxlength': 1000
            },
            'createExpenses[status]': {
                required: true,

            },

        },
        messages: {
            'createExpenses[expenseName]': {
                required: lang_required,
                'maxlength': lang_maxChars
            },
            'createExpenses[description]': {
                'maxlength': lang_maxChars
            },
            'createExpenses[status]': {
                required: lang_required,

            }

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
        if ($('#frmCreateExpensesType').valid()) {
            $('#frmCreateExpensesType').submit();
            $('#frmCreateExpensesType').resetForm();

        }
    });


})