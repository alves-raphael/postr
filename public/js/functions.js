function enable(input){
    input.removeClass('disabled');
    input.children(":disabled").prop("disabled", false);
}

function disable(input){
    input.addClass('disabled');
    input.children("input").first().prop("disabled", true);
}

function disableMany(inputs){
    inputs.forEach((input) => {
        input.addClass('disabled');
        input.children("input").first().prop("disabled", true);
    });    
}

function enableMany(inputs){
    inputs.forEach((input) => {
        input.removeClass('disabled');
        input.children(":disabled").prop("disabled", false);
    });
}

function hide(input) {
    input.addClass('hidden');
}

function show(input) {
    input.removeClass('hidden');
}

function showMany(inputs) {
    inputs.forEach((input) => {
        show(input);
    });
}

function hideMany(inputs) {
    inputs.forEach((input) => {
        hide(input);
    });
}