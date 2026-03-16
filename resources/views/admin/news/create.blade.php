@extends('admin.layouts.app')

@section('content')

<h1 class="text-2xl mb-6">Add News</h1>

<form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="text" name="title" placeholder="Title" class="border p-2 w-full mb-4">

    <input type="date" name="publish_date" class="border p-2 w-full mb-4">

    <input type="file" name="file" class="border p-2 w-full mb-4">

    <select name="status" class="border p-2 w-full mb-4">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>

    <button class="bg-gray-700 text-white px-4 py-2 rounded">
        Save
    </button>
</form>

@endsection
