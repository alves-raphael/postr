
var publish = $('#publish');
var dateTimeInputs = [$('#release-date'), $('#release-hour')];

$('#send-now').change(function(){
    if (this.value == 'imediato'){
        hideMany(dateTimeInputs);
        hide($('#assunto'));
        publish.prop("disabled", true);
    } else if (this.value == 'agendado') {
        showMany(dateTimeInputs);
        hide($('#assunto'));
        publish.prop("disabled", false);
    } else if (this.value == 'assunto') {
        show($('#assunto'));
        hideMany(dateTimeInputs);
        publish.prop("disabled", false);
    }
});

$('.ui.form').form({
    fields: {
        title: 'empty',
        sendnow: 'empty',
        body: 'empty',
        date: 'empty',
        social_media_id: 'empty'
    }
});

$('#date').change(function(){
    publish.val(publish.val().replace(/\d{4}-\d{2}-\d{2}/g, this.value));
});

$('#time').change(function(){
    publish.val(publish.val().replace(/\d{2}:\d{2}/g, this.value));
});