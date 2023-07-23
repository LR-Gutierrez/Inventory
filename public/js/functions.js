$(document).ready(function () {
    $('.liveIDnumber').val(function (index, value) {
        return value
            .replace(/\D/g, "")
            .replace(/([0-9])([0-9]{3})$/, "$1 $2")
            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, " ");
    });
    $('.liveIDtext').text(function (index, value) {
        return value
            .replace(/\D/g, "")
            .replace(/([0-9])([0-9]{3})$/, "$1 $2")
            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, " ");
    });
    $(".IDnumber").on({
        focus: function (event) {
            $(event.target).select();
        },
        keyup: function (event) {
            $(event.target).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{3})$/, "$1 $2")
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, " ");
            });
        },
    });
    $(".numbers").on({
        focus: function (event) {
            $(event.target).select();
        },
        keyup: function (event) {
            $(event.target).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{3})$/, "$1,$2")
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
            });
        },
    });
    $('.UpperCase').on({
        focus: function (event) {
            $(event.target).select();
        },
        keyup: function (event){
            $(event.target).val(function (index, value){
                return value
                .toUpperCase();
            });
        },
    })
    $('.phone').mask('+00 (000) 000-0000');
});
