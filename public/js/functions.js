function enable(input){
    input.removeClass('disabled');
    input.children(":disabled").prop("disabled", false);
}

function disable(input){
    input.addClass('disabled');
    input.children("input").first().prop("disabled", true);
}