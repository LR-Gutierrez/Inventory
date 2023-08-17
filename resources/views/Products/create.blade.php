@extends('..dashboard')

@section('title', 'Register Products')

@section('content')
    {{-- Breadcrumb --}}
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
            <a href="{{ route('products.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Products</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Register a product</span>
            </div>
        </li>
        </ol>
    </nav>
    
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Register a product
            </h1>
            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 dark:text-red-400 rounded-lg bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 relative" role="alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}                   
                </div>
            @endif
            <form class="space-y-4 md:space-y-6" method="post" action="{{ route('products.store') }}">
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
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter the product name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('name') }}" maxlength="50">
                    </div>
                    <div>
                        <label for="tin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <input type="text" name="description" id="description" placeholder="Enter the product description" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('description') }}" maxlength="50">
                    </div>
                    <div>
                        <label for="item_quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item quantity</label>
                        <input type="text" name="item_quantity" id="item_quantity" placeholder="Enter existing quantity" class="onlyNumbers bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('item_quantity') }}" maxlength="11">
                    </div>
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="text" name="price" id="price" class="integerNumbers bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter the product price" value="{{ old('price') }}" maxlength="11">
                    </div>
                    <div>
                        <label for="expiration_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiration date (Optional)</label>
                        <input type="date" name="expiration_date" id="expiration_date" title="Enter the product expiration date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('expiration_date') }}">
                    </div>
                    <div>
                        <label for="item_category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Category</label>
                        <select name="item_category_id" id="item_category_id" class="bg-gray-50 border border-gray-300 mb-3 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected>Select the item category</option>
                            @foreach ($itemCategories as $itemCategory)
                                <option value="{{ $itemCategory->id }}" class="text-center">{{ $itemCategory->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select  Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="bg-gray-50 border border-gray-300 mb-3 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected>Select the supplier</option>
                            <option value="none" class="text-center">No supplier</option>
                            <option value="new" class="text-center">Register new</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" title="{{ $supplier->company_name }} - TIN: {{ $supplier->tin }}" class="text-center">{{ $supplier->company_name }} TIN: {{ $supplier->tin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="new_category_wrapper" class="hidden">
                        <label for="new_category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Category</label>
                        <input type="text" name="new_category" id="new_category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter the category description" value="{{ old('new_category') }}" maxlength="11">
                    </div>
                </div>
                {{-- _asdfasdf --}}
                <div id="info_supplier-dropdown">
                    <div id="business_manager-title">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-1xl dark:text-white border-b border-gray-300 dark:border-gray-600 my-3">
                            General business manager information
                        </h1>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company Name</label>
                            <input type="text" name="company_name" id="company_name" placeholder="Enter the company name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('company_name') }}" maxlength="50">
                        </div>
                        <div>
                            <label for="tin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tax ID Number (TIN)</label>
                            <input type="text" name="tin" id="tin" placeholder="Enter the company TIN" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('tin') }}" maxlength="50">
                        </div>
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                            <textarea name="address" id="address" placeholder="Enter the company address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('address') }}</textarea>
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                            <input type="text" name="phone" id="phone" class="phone bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g. +1 (701) 267-2223" value="{{ old('phone') }}">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com" value="{{ old('email') }}">
                        </div>
                        <div>
                            <label for="website" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Website</label>
                            <input type="text" name="website" id="website" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g. https://mycompany.com" value="{{ old('website') }}">
                        </div>
                        <div>
                            <label for="business_manager" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a business manager</label>
                            <select name="business_manager" id="business_manager" class="bg-gray-50 border border-gray-300 mb-3 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" selected>Select the business manager</option>
                                <option value="new" class="text-center">Register new</option>
                                @foreach ($businessManagers as $businessManager)
                                    <option value="{{ $businessManager->id }}">{{ $businessManager->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div id="business_manager-dropdown">
                    <div id="business_manager-title">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-1xl dark:text-white border-b border-gray-300 dark:border-gray-600 my-3">
                            General business manager information
                        </h1>
                    </div>
                    <div id="business_manager-form" class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="name" name="business_manager_name" id="business_manager_name" placeholder="Enter your manager name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" maxlength="50">
                        </div>
                        <div>
                            <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lastname</label>
                            <input type="lastname" name="business_manager_lastname" id="business_manager_lastname" placeholder="Enter your manager lastname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" maxlength="50">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="business_manager_email" id="business_manager_email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com">
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                            <input type="text" name="business_manager_phone" id="business_manager_phone" class="phone bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g. +1 (701) 267-2223" minlength="13">
                        </div>
                    </div>
                </div>


                <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="fa-solid fa-plus"></i> Register</button>
            </form>
        </div>
    </div>
@endsection
