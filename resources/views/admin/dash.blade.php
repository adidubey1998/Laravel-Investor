@extends('admin.layouts.app')

@section('content')

{{-- Page Title --}}
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">
        Admin Dashboard
    </h1>
    <p class="text-gray-500 mt-1">
        Overview of Investor CMS activity
    </p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Total Tabs --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Tabs</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">
                    {{ \App\Models\Tabs::count() }}
                </p>
            </div>
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                📂
            </div>
        </div>
    </div>

    {{-- Active Tabs --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Active Tabs</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">
                    {{ \App\Models\Tabs::where('status', 1)->count() }}
                </p>
            </div>
            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                ✅
            </div>
        </div>
    </div>

    {{-- Admin Users --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Admins</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">
                    {{ \App\Models\User::where('is_admin', 1)->count() }}
                </p>
            </div>
            <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                👤
            </div>
        </div>
    </div>

</div>

{{-- Quick Actions --}}
<div class="mt-10 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">
        Quick Actions
    </h2>

    <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.tabs.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-black rounded-lg hover:bg-blue-700 transition">
            ➕ Create New Tab
        </a>

        <a href="{{ route('admin.tabs.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition">
            📑 Manage Tabs
        </a>
    </div>
</div>

@endsection
