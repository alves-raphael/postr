
var publish = $('#publish');
var dateTimeInputs = [$('#release-date'), $('#release-hour')];

$('#send-now').change(function(){
    if (this.value == 'true'){
        disableMany(dateTimeInputs);
        publish.prop("disabled", true);
    } else {
        enableMany(dateTimeInputs);
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