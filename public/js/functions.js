$(document).ready(function () {
    $('#business_manager-dropdown, .customer-info').hide();
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
    $(".floatNumbers").on({
        focus: function (event) {
            $(event.target).select();
        },
        keyup: function (event) {
            $(event.target).val(function (index, value) {
				return value
					.replace(/\D/g, "")
					.replace(/([0-9])([0-9]{2})$/, "$1.$2")
					.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
			});
        },
    });
    $('.integerNumbers').on({
        focus: function (event) {
            $(event.target).select();
        },
        keyup: function (event){
            $(event.target).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{3})$/, "$1,$2")
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
            });
        },
    })
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
    });
    $('.phone').mask('+00 (000) 000-0000');
    $("#business_manager").change(function () {
        let business_manager_id = $(this).val();

        if (business_manager_id != "") {
            if (business_manager_id !== "new") {
                $.ajax({
                    url: "search-business_manager",
                    type: "POST",
                    data: { business_manager_id: business_manager_id },
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (data) {
                        $("#business_manager_name")
                        .val(data.name)
                        .removeClass("dark:text-white")
                        .addClass("cursor-not-allowed dark:text-gray-400")
                        .attr("readonly", true);
                        $("#business_manager_lastname")
                        .val(data.lastname)
                        .removeClass("dark:text-white")
                        .addClass("cursor-not-allowed dark:text-gray-400")
                        .attr("readonly", true);
                        $("#business_manager_email")
                        .val(data.email)
                        .removeClass("dark:text-white")
                        .addClass("cursor-not-allowed dark:text-gray-400")
                        .attr("readonly", true);
                        $("#business_manager_phone")
                        .val(data.phone)
                        .removeClass("dark:text-white")
                        .addClass("cursor-not-allowed dark:text-gray-400")
                        .attr("readonly", true);

                        $("#business_manager-dropdown").slideDown();
                    },
                });
            } else {
                $("#business_manager_name")
                    .val("")
                    .removeClass("cursor-not-allowed dark:text-gray-400")
                    .addClass("dark:text-white")
                    .removeAttr("readonly");
                $("#business_manager_lastname")
                    .val("")
                    .removeClass("cursor-not-allowed dark:text-gray-400")
                    .addClass("dark:text-white")
                    .removeAttr("readonly");
                $("#business_manager_email")
                    .val("")
                    .removeClass("cursor-not-allowed dark:text-gray-400")
                    .addClass("dark:text-white")
                    .removeAttr("readonly");
                $("#business_manager_phone")
                    .val("")
                    .removeClass("cursor-not-allowed dark:text-gray-400")
                    .addClass("dark:text-white")
                    .removeAttr("readonly");
                
                $("#business_manager-dropdown").slideDown();
            }
        } else $("#business_manager-dropdown").slideUp();
    });
    $('.showOneTime').slideDown();
    $('#search-dni').on("keyup", function(){
        console.log($(this).val())
    });
});
