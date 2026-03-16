@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-semibold">Latest News</h1>

    <a href="{{ route('admin.news.create') }}"
       class="px-4 py-2 bg-gray-700 text-white rounded">
        + Add News
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 p-3 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow rounded">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-3 text-left">Title</th>
                <th>Status</th>
                <th>Order</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($news as $item)
            <tr class="border-t">
                <td class="p-3">
                    @if($item->file_path)
                        <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank"
                           class="text-blue-600 underline">
                            {{ $item->title }}
                        </a>
                    @else
                        {{ $item->title }}
                    @endif
                </td>
                <td class="text-center">
                    {{ $item->status ? 'Active' : 'Inactive' }}
                </td>
                <td class="text-center">
                    {{ $item->sort_order }}
                </td>
                <td class="text-right p-3">
                    <form method="POST" action="{{ route('admin.news.destroy', $item) }}">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection
