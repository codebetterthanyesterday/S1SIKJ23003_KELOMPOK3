@extends('layout.app3')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Welcome, <span class="text-green-500">{{ $getUser->username }}</span>!</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center" tabindex="0" aria-label="Users">
            <span class="text-4xl text-blue-500 mb-2">
                <i class="fas fa-users"></i>
            </span>
            <span class="text-xl font-semibold">1,234</span>
            <span class="text-gray-500">Users</span>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center" tabindex="0" aria-label="Orders">
            <span class="text-4xl text-green-500 mb-2">
                <i class="fas fa-shopping-cart"></i>
            </span>
            <span class="text-xl font-semibold">567</span>
            <span class="text-gray-500">Orders</span>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center" tabindex="0" aria-label="Revenue">
            <span class="text-4xl text-yellow-500 mb-2">
                <i class="fas fa-dollar-sign"></i>
            </span>
            <span class="text-xl font-semibold">$12,345</span>
            <span class="text-gray-500">Revenue</span>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center" tabindex="0" aria-label="Products">
            <span class="text-4xl text-purple-500 mb-2">
                <i class="fas fa-box"></i>
            </span>
            <span class="text-xl font-semibold">89</span>
            <span class="text-gray-500">Products</span>
        </div>
    </div>
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="bg-white rounded-lg shadow p-6 flex-1" tabindex="0" aria-label="Recent Activity">
            <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>
            <ul class="space-y-2">
                <li class="flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                    User <span class="font-semibold mx-1">John Doe</span> registered.
                </li>
                <li class="flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                    Order <span class="font-semibold mx-1">#1234</span> placed.
                </li>
                <li class="flex items-center">
                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                    Revenue updated.
                </li>
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex-1" tabindex="0" aria-label="Quick Actions">
            <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>
            <div class="flex flex-wrap gap-4">
                <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Add User</a>
                <a href="#" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">Add Order</a>
                <a href="#" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300">Add Product</a>
            </div>
        </div>
    </div>
</div>
@endsection
