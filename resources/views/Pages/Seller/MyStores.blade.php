@extends('layout.app2')

@section('title', 'My Stores')

@section('content')
    <div class="bg-[#fbfbfb] w-full p-7 rounded-lg shadow-md border-[1px] border-[#eeeeee] mt-10">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Store Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $store->store_name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ Str::limit($store->description, 50) ?? 'No description' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($store->store_address, 50) ?? 'No address' }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full {{ $store->store_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($store->store_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('seller.store.show', $store->id_store) }}"
                                    class="text-blue-600 hover:underline mr-2">Detail</a>
                                <a href="{{ route('seller.store.edit', $store->id_store) }}"
                                    class="text-orange-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('seller.store.destroy', $store->id_store) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:underline delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No stores found. <a href="{{ route('seller.creation', 'store') }}"
                                    class="text-blue-600 hover:underline">Create your first store</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Delete Store?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            btn.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
