document.addEventListener('DOMContentLoaded', function () {
    var radioButtons = document.querySelectorAll('input[type="radio"]');

    radioButtons.forEach(function (radioButton) {
        radioButton.addEventListener('click', function () {
            radioButtons.forEach(function (otherRadioButton) {
                if (otherRadioButton !== radioButton) {
                    otherRadioButton.checked = false;
                }
            });
        });
    });
});