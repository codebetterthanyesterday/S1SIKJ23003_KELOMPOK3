@extends('layout.app3')

@section('title', 'Admin Table')

@section('content')
    <div class="bg-[#fbfbfb] w-full p-7 rounded-lg shadow-md border-[1px] border-[#eeeeee] my-10">
        <div class="w-full flex gap-3 justify-end mb-3">
            <div class="max-w-[250px] flex-[1]">
                <select id="underline_select" name="filter_table"
                    onchange="location.href = this.options[this.selectedIndex].dataset.url"
                    class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option data-url="{{ route('admin.table', 'customer') }}"
                        {{ $data['entity'] === 'customer' ? 'selected' : '' }}>Customer
                    </option>
                    <option data-url="{{ route('admin.table', 'product') }}"
                        {{ $data['entity'] === 'product' ? 'selected' : '' }}>Product
                    </option>
                    <option data-url="{{ route('admin.table', 'seller') }}"
                        {{ $data['entity'] === 'seller' ? 'selected' : '' }}>Seller
                    </option>
                    <option data-url="{{ route('admin.table', 'store') }}"
                        {{ $data['entity'] === 'store' ? 'selected' : '' }}>Store</option>
                    <option data-url="{{ route('admin.table', 'product-categories') }}"
                        {{ $data['entity'] === 'product-categories' ? 'selected' : '' }}>Product Category</option>
                </select>
            </div>
            <div class="max-w-[150px] flex-[1]">
                <form method="GET" action="">
                    <select name="per_page" onchange="this.form.submit()"
                        class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', $data['rows']->perPage()) == $size ? 'selected' : '' }}>
                                {{ $size }} per page
                            </option>
                        @endforeach
                    </select>
                    @foreach(request()->except('per_page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>
            </div>
        </div>

        <x-admin.table :entity="$data['entity']" :title="$data['title']" :columns="$data['columns']" :AInumber="$data['AInumber']" :fields="$data['fields']" :rows="$data['rows']" />
        <div class="mt-4" id="pagination-table">
            {{ $data['rows']->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
