@extends('admin.layouts.app')

@section('content')

{{-- Page Header --}}
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">Investor Tabs</h1>
        <p class="text-gray-500 text-sm mt-1">
            Manage investor page structure and hierarchy
        </p>
    </div>

    <a href="{{ route('admin.tabs.create') }}"
       class="px-4 py-2 bg-blue-600 text-black rounded-lg hover:bg-blue-700 transition">
        ➕ Add New Tab
    </a>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-700">
        {{ session('success') }}
    </div>
@endif

{{-- Tabs Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

    <table class="w-full border-collapse">
       <thead class="bg-gray-50 border-b">
    <tr>
        <th class="px-4 py-3 text-sm font-semibold text-gray-600">
            S.No
        </th>

        <th class="text-left px-4 py-3 text-sm font-semibold text-gray-600">
            Tab Name
        </th>

        <th class="text-left px-4 py-3 text-sm font-semibold text-gray-600">
            Page Type
        </th>

        <th class="text-left px-4 py-3 text-sm font-semibold text-gray-600">
            Status
        </th>

        <th class="text-right px-4 py-3 text-sm font-semibold text-gray-600">
            Actions
        </th>
    </tr>
</thead>

        <tbody>
            @forelse($tabs as $index => $tab)
    @include('admin.partials.row', [
        'tab' => $tab,
        'level' => 0,
        'numbering' => ($index + 1)
    ])
@empty
                <tr>
                    <td colspan="4" class="text-center p-6 text-gray-500">
                        No tabs created yet.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>

@endsection
