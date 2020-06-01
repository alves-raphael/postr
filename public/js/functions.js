function enable(input){
    input.removeClass('disabled');
    input.children(":disabled").prop("disabled", false);
}

function disable(input){
    input.addClass('disabled');
    input.children("input").first().prop("disabled", true);
}

function disableMany(inputs){
    for(input in inputs){
        input.addClass('disabled');
        input.children("input").first().prop("disabled", true);
    }
}

function enableMany(inputs){
    for(input in inputs){
        input.removeClass('disabled');
        input.children(":disabled").prop("disabled", false);
    }
}