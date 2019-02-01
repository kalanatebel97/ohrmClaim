$(document).ready(function () {

    $('#btnCreate').click(function(e) {
        e.stopImmediatePropagation();
        if ($('#btnCreate').val() == lang_edit_event) {
            $('#saveFormHeading').text(saveFormHeading);
            $('#createEvent_name').removeAttr('disabled');
            $('#createEvent_description').removeAttr('disabled');
            $('#btnCreate').val(lang_create_event);

        }else if($('#btnCreate').val() == lang_create_event) {
            e.preventDefault();
            if ($('#frmCreateEvent').valid()) {
                $('#frmCreateEvent').submit();

            }
        }
    });

    $('#frmCreateEvent').validate({
        rules: {
            'createEvent[name]': {
                required: true,
                'maxlength': 255
            },
            'createEvent[description]': {
                required: false,
                'maxlength': 1000
            },
        },
        messages: {
            'createEvent[name]': {
                required: lang_required,
                'maxlength': lang_maxChars
            },
            'createEvent[description]': {
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
    if(eventId > 0 ){
        $('#saveFormHeading').text(edit_form_heading);
        $('#createEvent_name').attr('disabled','disabled');
        $('#createEvent_description').attr('disabled','disabled');
        $('#btnCreate').val(lang_edit_event);

    }
    $('#btnCancel').click(function () {
        window.location.replace(viewEventUrl);

    });

    $('#btnDelete').click(function () {

            $('#deleteConfirmation').modal();
            return false;

    });

    $('#frmList_ohrmListComponent').attr('name', 'frmList_ohrmListComponent');
    $('#dialogDeleteBtn').click(function () {
        document.frmList_ohrmListComponent.submit();
    });
    $('#dialogCancelBtn').click(function () {
        $("#deleteConfirmation").dialog("close");
    });

});

