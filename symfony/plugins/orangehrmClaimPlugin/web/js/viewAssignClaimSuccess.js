$(document).ready(function () {

    $('#btnAdd').click(function() {
        window.location.replace(addClaimUrl);


    });

    $('#btnCancel').click(function() {
        window.location.replace(viewClaimUrl);


    });

    $('#frmSubmitClaim').validate({
        rules: {
            'assignClaim[empName]': {
                required: true,

            },
            'assignClaim[eventType]': {
                required: true,
                'maxlength': 255
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

            'assignClaim[empName]': {
                required: true

            },
            'assignClaim[eventType]': {
                required: lang_required,

            },
            'assignClaim[description]': {
                'maxlength': lang_maxChars
            },
            'assignClaim[currency]': {
                required: true,

            },


        }
    });


    $('#btnDelete').click(function () {
        $('#frmList_ohrmListComponent').submit(function () {
            $('#deleteConfirmation').dialog('open');
            return false;
        });
    });

    $('#btnAdd').click(function () {
        $('#frmSubmitClaim').show();


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
        if ($('#frmSubmitClaim').valid()) {
            $('#frmSubmitClaim').submit();
            $('#frmSubmitClaim').resetForm();


        }
    });

})