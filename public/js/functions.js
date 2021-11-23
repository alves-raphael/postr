function enable(input){
    show(input);
    input.removeClass('disabled');
    input.children(":disabled").prop("disabled", false);
}

function disable(input){
    input.addClass('disabled');
    input.children("input").first().prop("disabled", true);
    hide(input);
}

function disableMany(inputs){
    inputs.forEach((input) => {
        disable(input);
    });    
}

function enableMany(inputs){
    inputs.forEach((input) => {
        enable(input);
    });
}

function hide(input) {
    input.addClass('hidden');
}

function show(input) {
    input.removeClass('hidden');
}