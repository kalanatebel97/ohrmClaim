$(document).ready(function(){

    $('#frmCreateEvent').validate({
        rules: {
            'createEvent[eventName]': {
                required: true,
                'maxlength': 255
            },
            'createEvent[description]': {
                required: false,
                'maxlength': 1000
            },

        },
        messages: {
            'createEvent[eventName]': {
                required: lang_required,
                'maxlength': lang_maxChars
            },
            'createEvent[description]': {
                'maxlength': lang_maxChars
            },

        }
    });


    $('#btnDelete').click(function(){
        $('#frmList_ohrmListComponent').submit(function(){
            $('#deleteConfirmation').dialog('open');
            return false;
        });
    });

    $('#frmList_ohrmListComponent').attr('name','frmList_ohrmListComponent');
    $('#dialogDeleteBtn').click(function() {
        document.frmList_ohrmListComponent.submit();
    });
    $('#dialogCancelBtn').click(function() {
        $("#deleteConfirmation").dialog("close");
    });

    $('#btnCreate').click(function(e){
        e.preventDefault();
        if($('#frmCreateEvent').valid()){
            $('#frmCreateEvent').submit();
            $('#frmCreateEvent').resetForm();

        }
    });

})

