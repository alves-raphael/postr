
var publish = $('#publish');
var releaseDate = $('#release-date');
var releaseHour = $('#release-hour');

$('#send-now').change(function(){
    if (this.value == 'true'){
        disable(releaseDate);
        disable(releaseHour);
        publish.prop("disabled", true);
    } else {
        enable(releaseDate);
        enable(releaseHour);
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