@extends('..dashboard')

@section('title', 'Register sale')

@section('content')
    <nav class="flex pb-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
            <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
            Home
            </a>
        </li>
        <li>
            <div class="flex items-center">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <a href="{{ route('sales.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Sales</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Register sale</span>
            </div>
        </li>
        </ol>
    </nav>
    
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="px-6 mt-4 md:mt-6 sm:px-8 flex justify-between">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
              Register sale
            </h1>
            <h1 id="client-info" class="text-xl font-semibold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white justify-end hidden">
              Client name:
            </h1>
        </div>
        <div class="px-6 pb-6 mb-4 md:mb-6 sm:px-8">
            @if (session('error'))
                <div class="mb-4 text-sm text-red-800 dark:text-red-400 rounded-lg bg-gray-50 border border-gray-300 sm:text-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 relative" role="alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}                   
                </div>
            @endif
            <form class="space-y-4 md:space-y-6" id="form_make_sell" method="post" action="{{ route('sales.store') }}">
                @if ($errors->any())
                    <div class="flex justify-center bg-red-500 text-white px-4 py-2 w-full rounded my-2" role="alert">
                        <ul class="list-disc">
                            @foreach ($errors->all() as $error)
                                <li>
                                    <span class="text-white">{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="search-dni" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DNI number *</label>
                        <input type="text" name="dni" id="search-dni" placeholder="Enter the DNI number" class="liveIDnumber IDnumber bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" maxlength="50">
                    </div>
                    {{-- <label for="search_product" class="sr-only">Search</label> --}}
                    <div>
                        <label for="dni" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Search product</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="search_product" class="block p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for a product">
                        </div>

                    </div>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg pb-4">
                    <table id="products-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <form action="{{ route('sales.removeAll') }}" method="post" id="removeAll" id="removeAll" name="removeAll"></form>
                                        <input type="hidden" name="selected" id="selected" value="">
                                            <input id="checkbox-all-search" name="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                        </form>
                                        <div id="trashIcon" class="ml-2 cursor-pointer">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </div>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Qty
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                    </table>
                </div>
                <div class="grid grid-cols-2">
                    <div>
                        <label for="coupon_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Have a acoupon code?</label>
                        <div class="flex">
                            <input type="text" name="coupon_code" id="coupon_code" class="rounded-none rounded-l-md bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter the coupon code">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-r-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                <i class="fa-solid fa-percent w-4 h-4 text-gray-500 dark:text-gray-400"></i> Off
                            </span>
                        </div>
                    </div>
                </div>
                <button type="button" id="makeSell" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="fa-solid fa-cash-register"></i> Make a Sell</button>
            </form>
        </div>
    </div>
    <script>
        var timeout = null;
        var checkbox = [];
        $(document).ready(function () {
            $("#checkbox-all-search").prop("checked", false);
            $('#search-dni').on("keyup", function(){
                let dni = $(this).val().replace(/\s+/g, '');
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    $.post({
                        url: '{{ route("customers.search") }}',
                        type: 'POST',
                        data: {dni: dni},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#search_product').focus();
                                Toast.fire({
                                    icon: response.status,
                                    title: response.message
                                });
                                $("#products-table tr:not(:first)").remove();
                                $("#checkbox-all-search").prop("checked", false);
                                $('#client-info').text('Client name: ' + response.data.name).removeClass('hidden').attr('data-id', response.data.id);
                                
                                for (var i = 0; i < response.orders.length; i++) {
                                    if ($('#table-body').find('tr[data-id="' + response.orders[i].product_id + '"]').length > 0) {
                                        return;
                                    }else{
                                        var row = $('<tr>').addClass('bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600').attr('data-id', response.orders[i].products.id);
                                        var checkbox = $('<input>').attr({
                                            name: 'body_checkbox[]',
                                        type: 'checkbox',
                                            class: 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 body-checkbox',
                                            id: 'checkbox-table-search-' + response.orders[i].id,
                                        value: response.orders[i].products.id
                                        });
                                        var label = $('<label>').attr('for', 'checkbox-table-search-' + response.orders[i].id).addClass('sr-only').text('checkbox');
                                        var cell = $('<td>').addClass('w-4 p-4').append($('<div>').addClass('flex items-center').append(checkbox).append(label));
                                        var name = $('<th>').addClass('px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white').attr('scope', 'row').text(response.orders[i].products.name);
                                        var quantity = $('<td>').addClass('px-6 py-4').append($('<input>').attr({
                                            type: 'number',
                                            id: 'item_quantity',
                                            name: 'item_quantity',
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
                                Toast.fire({
                                    icon: response.status,
                                    title: response.message
                                });
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
                                url: '{{ route("products.search") }}',
                                type: 'POST',
                                data: {search_field: search_field.val(), dni: $('#search-dni').val()},
                                dataType: 'json',
                                headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.status === 'success') {
                                        $("#products-table tr:not(:first)").remove();
                                        $("#checkbox-all-search").prop("checked", false);
                                        Toast.fire({
                                            icon: response.status,
                                            title: response.message
                                        });
                                        for (var i = 0; i < response.orders.length; i++) {
                                            var row = $('<tr>').addClass('bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600').attr('data-id', response.orders[i].products.id);
                                            var checkbox = $('<input>').attr({
                                                name: 'body_checkbox[]',
                                                type: 'checkbox',
                                                class: 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 body-checkbox',
                                                id: 'checkbox-table-search-' + response.orders[i].id,
                                                value: response.orders[i].products.id
                                            });
                                            var label = $('<label>').attr('for', 'checkbox-table-search-' + response.orders[i].id).addClass('sr-only').text('checkbox');
                                            var cell = $('<td>').addClass('w-4 p-4').append($('<div>').addClass('flex items-center').append(checkbox).append(label));
                                            var name = $('<th>').addClass('px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white').attr('scope', 'row').text(response.orders[i].products.name);
                                            var quantity = $('<td>').addClass('px-6 py-4').append($('<input>').attr({
                                                type: 'number',
                                                id: 'item_quantity',
                                                name: 'item_quantity',
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
                                        $("#table-body").append(row);
                                        $(".input-number").on(
                                            "keydown",
                                            function (e) {
                                                if (
                                                    (e.keyCode == 40 &&
                                                        $(this).val() < 1) ||
                                                    e.keyCode == 13
                                                ) {
                                                    e.preventDefault();
                                                    this.val(1);
                                                }
                                            }
                                        );
                                        $(".input-number").on("input", function () {
                                            if ($(this).val() < 1) {
                                                $(this).val(1);
                                            }
                                            if ($(this).val() > 999) {
                                                $(this).val(999);
                                            }
                                        });
                                    }else{
                                        Toast.fire({
                                            icon: response.status,
                                            title: response.message
                                        })
                                    }
                                }, fail: function(error){
                            
                                }
                            });
                    }
                }, 400);    
            });
            $(document).on("click", ".removeFromCart", function(){
                $.post({
                    url: '{{ route("sales.remove") }}',
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
                        Toast.fire({
                            icon: response.status,
                            title: response.message
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
                    url: '{{ route("sales.update_amount" ) }}',
                    type: 'POST',
                    data: {product_id: $(this).closest('tr').data('id'), customer_id: $('#client-info').data('id'), item_quantity: $(this).val()},
                    dataType: 'json',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: response.status,
                            title: response.message
                        });
                    }, fail: function(error){
                
                    }
                });
            });
            $('#checkbox-all-search').change(function() {
                if ($(this).is(':checked')) {
                    $('.body-checkbox').prop('checked', true);
                    checkbox.push($('.body-checkbox').val());
                    if($("input[name='body_checkbox[]']").length > 0){
                        $("#trashIcon i").addClass("text-red-600 !important");
                    }
                } else {
                    $("#trashIcon i").removeClass("text-red-600 !important");
                    $('.body-checkbox').prop('checked', false);
                }
            });
            $(document).on('change','input[name="body_checkbox[]"]', function() {
                let parent = $(this).closest('tr');
                let td_id = parent.data('id');
                $("#selected").val(td_id);
            });
            $("#trashIcon").on("click", function(){
                let dni = $("#search-dni").val().replace(/\s+/g, '');
                checkbox = $('input[name="body_checkbox[]"]:checked').serializeArray().filter(function(item) {
                    return item.value !== 'on';
                });
                if($("input[name='body_checkbox[]']").length > 0){
                    $.post({
                        url: " {{ route('sales.removeAll') }}",
                        data: {
                            body_checkbox: checkbox, dni:dni,
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Toast.fire({
                                icon: response.status,
                                title: response.message
                            });
                            $("#products-table tr:not(:first)").remove();
                            for (var i = 0; i < response.orders.length; i++) {
                                var row = $('<tr>').addClass('bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600').attr('data-id', response.orders[i].products.id);
                                var checkbox = $('<input>').attr({
                                    name: 'body_checkbox[]',
                                    type: 'checkbox',
                                    class: 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 body-checkbox',
                                    id: 'checkbox-table-search-' + response.orders[i].id,
                                    value: response.orders[i].products.id
                                });
                                var label = $('<label>').attr('for', 'checkbox-table-search-' + response.orders[i].id).addClass('sr-only').text('checkbox');
                                var cell = $('<td>').addClass('w-4 p-4').append($('<div>').addClass('flex items-center').append(checkbox).append(label));
                                var name = $('<th>').addClass('px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white').attr('scope', 'row').text(response.orders[i].products.name);
                                var quantity = $('<td>').addClass('px-6 py-4').append($('<input>').attr({
                                    type: 'number',
                                    id: 'item_quantity',
                                    name: 'item_quantity',
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
                        }, fail: function(error){
                        }
                    });
                }
            });
            $("#makeSell").on("click", function(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will make a sale with the added items.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sell!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post({
                            url: "{{ route('sales.store' )}}",
                            data: $("#form_make_sell").serialize(),
                            headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            }
                        }).done(function(response){
                            Toast.fire(
                                response.title,
                                response.message,
                                response.status
                            );
                            if (response.status === 'success') {
                                setTimeout(function() {
                                    $(location).prop("href", response.data.url);
                                }, 1000);
                            }
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            Toast.fire(
                                "Oops!",
                                "An error may have occurred",
                                "error"
                            );
                        });
                    }
                })
            });
        });
    </script>
@endsection
