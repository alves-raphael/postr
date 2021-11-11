$('button#new').click(() => {
    $('.ui.modal').modal('show');
});

const form = $('form#create-new');

form
  .form({
    fields: {
      title : 'empty'
    }
  })
;

$('button#submit').click(() => {
    form.submit();
});