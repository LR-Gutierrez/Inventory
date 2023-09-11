$(document).ready(function () {
    var timeout = null;
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
    $('#search-dni').on("keyup", function(){
        let dni = $(this).val().replace(/\s+/g, ''); // "Hola,mundo!"
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            $.post({
                url: '/dashboard/customers/search-customers/',
                type: 'POST',
                data: {dni: dni},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        $('#search_product').focus();
                        Swal.fire({
                            position: 'top-end',
                            icon: response.status,
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#client-info').text('Client name: ' + response.data.name).removeClass('hidden').attr('data-id', response.data.id);
                        for (var i = 0; i < response.orders.length; i++) {
                            var row = $('<tr>').addClass('bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600').attr('data-id', response.orders[i].products.id);
                            var checkbox = $('<input>').attr({
                                type: 'checkbox',
                                class: 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600',
                                id: 'checkbox-table-search-' + response.orders[i].id
                            });
                            var label = $('<label>').attr('for', 'checkbox-table-search-' + response.orders[i].id).addClass('sr-only').text('checkbox');
                            var cell = $('<td>').addClass('w-4 p-4').append($('<div>').addClass('flex items-center').append(checkbox).append(label));
                            var name = $('<th>').addClass('px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white').attr('scope', 'row').text(response.orders[i].products.name);
                            var quantity = $('<td>').addClass('px-6 py-4').append($('<input>').attr({
                                type: 'number',
                                id: 'item_quantity',
                                class: 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 input-number',
                                value: response.orders[i].item_quantity
                            }));
                            var category = $('<td>').addClass('px-6 py-4').text(response.orders[i].products.item_category.description);
                            var price = $('<td>').addClass('px-6 py-4').text('$' + response.orders[i].products.price);
                            var remove = $('<td>').addClass('px-6 py-4').append($('<a>').attr({
                                href: '#',
                                'data-id': response.orders[i].products.id,
                                title: 'Remove product'
                            }).addClass('font-medium text-red-600 dark:text-red-500 hover:underline removeFromCart').append($('<i>').addClass('fa-solid fa-trash-can')));
                            row.append(cell).append(name).append(quantity).append(category).append(price).append(remove);
                            $('#table-body').append(row);
                        }
                        
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
                    }else{
                        $('#client-info').text('Client name: ').addClass('hidden');
                        $('#products-table tr').not(':first').remove();
                    }
                }, fail: function(error){
                }
            });
        }, 400);
    });
    $('#search_product').on("keyup", function(){
        clearTimeout(timeout);
        let search_field = $(this);
        timeout = setTimeout(function() {
            if ($('#search-dni').val() == '') {
                $("#search-dni").focus();
                Swal.fire({
                    icon: 'info',
                    title: 'Whoops',
                    text: "First enter the customer's ID number"
                });
            } else {
                    $.post({
                        url: '/dashboard/products/search-products/',
                        type: 'POST',
                        data: {search_field: search_field.val(), dni: $('#search-dni').val()},
                        dataType: 'json',
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                var found = false;
                                $('#table-body tr').each(function() {
                                    var name = search_field.find('th').text();
                                    var input = search_field.find('.input-number');
                                    if (name === response.data.name) {
                                        input.val(parseInt(input.val()) + 1);
                                        found = true;
                                        return false;
                                    }
                                });
                                if (!found) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: response.status,
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(function(){
                                        var row = $('<tr>').addClass('bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600').attr('data-id', response.data.id);
                                        var checkbox = $('<input>').attr({
                                            type: 'checkbox',
                                            class: 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600',
                                            id: 'checkbox-table-search-1'
                                        });
                                        var label = $('<label>').attr('for', 'checkbox-table-search-1').addClass('sr-only').text('checkbox');
                                        var cell = $('<td>').addClass('w-4 p-4').append($('<div>').addClass('flex items-center').append(checkbox).append(label));
                                        var name = $('<th>').addClass('px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white').attr('scope', 'row').text(response.data.name);
                                        var quantity = $('<td>').addClass('px-6 py-4').append($('<input>').attr({
                                            type: 'number',
                                            id: 'item_quantity',
                                            class: 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 input-number',
                                            value: '1'
                                        }));
                                        var category = $('<td>').addClass('px-6 py-4').text(response.data.item_category.description);
                                        var price = $('<td>').addClass('px-6 py-4').text('$'+response.data.price);
                                        var remove = $('<td>').addClass('px-6 py-4').append($('<a>').attr({
                                            href: '#',
                                            'data-id': response.data.id,
                                            title: 'Remove product'
                                        }).addClass('font-medium text-red-600 dark:text-red-500 hover:underline removeFromCart').append($('<i>').addClass('fa-solid fa-trash-can')));
                                        row.append(cell).append(name).append(quantity).append(category).append(price).append(remove);
                                        $('#table-body').append(row);
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
                                    });
                                }
                            }
                        }, fail: function(error){
                    
                        }
                    });
            }
        }, 400);    
    });
    $(document).on("click", ".removeFromCart", function(){
        $.post({
            url: '/dashboard/sales/remove-product/'+ $(this).data('id'),
            type: 'POST',
            data: {product_id: $(this).data('id'), customer_id: $('#client-info').data('id')},
            dataType: 'json',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#products-table').find('tr[data-id="' + $('.removeFromCart').data('id') + '"]').remove();
                }
                Swal.fire({
                    position: 'top-end',
                    icon: response.status,
                    title: response.title,
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(function(){
                    $('#search_product').focus();
                });
            }, fail: function(error){
          
            }
        });
    });
    $(document).on('click', '#item_quantity', function() {
        this.select();
    });
    $(document).on('change', '#item_quantity', function(){
        $.post({
            url: '/dashboard/sales/update-amount/'+ $(this).closest('tr').data('id'),
            type: 'POST',
            data: {product_id: $(this).closest('tr').data('id'), customer_id: $('#client-info').data('id'), item_quantity: $(this).val()},
            dataType: 'json',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: response.status,
                    title: response.title,
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }, fail: function(error){
        
            }
        });
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
