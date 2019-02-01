$(document).ready(function () {

    $('#btnAdd').click(function() {
        window.location.replace(addClaimUrl);


    });

    $('#btnCancel').click(function() {
        window.location.replace(viewClaimUrl);


    });


    $('#frmSubmitClaim').validate({
        rules: {
            'claimRequest[eventType]': {
                required: true,
                'maxlength': 255
            },
            'claimRequest[description]': {
                required: false,
                'maxlength': 1000
            },
            'claimRequest[currency]': {
                required: true,
                'maxlength': 1000
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