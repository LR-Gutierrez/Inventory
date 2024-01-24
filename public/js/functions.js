var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
});
$(document).ready(function () {
    $('#business_manager-dropdown, #info_supplier-dropdown, #info_supplier-dropdown, .customer-info').hide();
    $('#search-dni').focus();
    $('#search-dni, #search_product').val('');
    $("#search_product").on("click", function(){
        this.select();
    });
    $('.input-number').on('keydown', function(e) {
        if (e.keyCode == 40 && $(this).val() < 1 || e.keyCode == 13) {
            e.preventDefault();
            this.val(1);
        }
    });
    $('.input-number').on('input', function() {
        if ($(this).val() < 1) {
          $(this).val(1);
        }
        if ($(this).val() > 999) {
            $(this).val(999);
        }
    });
    
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
                    .replace(/([0-9])([0-9]{2})$/, "$1.$2")
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
            });
        },
    });
    $('.onlyNumbers').on({
        focus: function (event) {
            $(event.target).select();
        },
        keyup: function (event){
            $(event.target).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/([0-9])([0-9])$/, "$1$2");
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
    });
    $('.phone').mask('+00 (000) 000-0000');
    // $('.url').mask('https://S?{*.}');
    // $('.url').mask('AAA 000-S0S');
    /*$('.url').on("input", function() {
        let checker = 'https://';
        let inputValue = $(this).val();
        let check = inputValue.startsWith("https://")
        if(e.keyCode === 8 && $(this).val().length <= 8){
            e.preventDefault();
        }
        if(inputValue.substring(0,8) != 'https://'){
            $(this).val('https://' + inputValue);
        }
        if (check == true) {
            console.log(check +'d | ' +$('.url').val());
            $(this).val(checker);
        }else{
            console.log(check +' | ' +$('.url').val());
            $(this).val(checker + inputValue);
        }
    });*/
    $('.url').on('input', function(){
        let val = $(this).val();
        if(!val.startsWith('https://')){
          $(this).val('https://' + val);
        }
    });
    $('.url').on('keydown', function(e){
        if(e.keyCode === 8 && $(this).val() === 'https://'){
            e.preventDefault();
        }
    });
    $('.showOneTime').slideDown();
    /*********************************/
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
    $('#item_category_id').on("change", function(){
        if ($(this).val() != "") {
            if ($(this).val() == "new") {
                $("#new_category_wrapper").slideDown();
                // data
            }else{
                $("#new_category_wrapper").slideUp();
                $("#new_category").val('');
                // clear data
            }
        } else {
            $("#new_category_wrapper").slideUp();
            $("#new_category").val('');
        }
    });
    $('#supplier_id').on("change", function(){
        if ($(this).val() != "") {
            if ($(this).val() == "new") {
                $("#info_supplier-dropdown").slideDown();
                // data
            }else{
                $("#info_supplier-dropdown").slideUp();
                // $("#new_category").val('');
                // clear data
            }
        } else {
            $("#info_supplier-dropdown").slideUp();
            // $("#new_category").val('');
        }
    });
    /* $("#search_product").autocomplete({
        source: function(request, response) {
          $.ajax({
            url: "/dashboard/products/search-products/",
            type: "POST",
            dataType: "json",
            data: {
              search_field: request.term
            },
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
              response($.map(data, function(item) {
                return {
                  label: item.name,
                  value: item.id
                }
              }));
            }
          });
        },
        minLength: 1,
        select: function(event, ui) {
          // Aquí puedes agregar el código que se ejecutará cuando el usuario seleccione una sugerencia
        }
    }); */
});
