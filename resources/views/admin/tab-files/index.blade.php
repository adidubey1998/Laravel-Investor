@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">
            Files for: {{ $tab->name }}
        </h1>
        <p class="text-gray-500 text-sm">
            Upload and manage documents
        </p>
    </div>

    <a href="{{ route('admin.tabs.index') }}"
       class="px-4 py-2 bg-gray-200 rounded-lg">
        ← Back
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

{{-- Upload Form --}}
<div class="bg-white rounded-xl shadow p-6 mb-8">
    <form method="POST"
          action="{{ route('admin.tabs.files.store', $tab->id) }}"
          enctype="multipart/form-data"
          class="grid grid-cols-1 md:grid-cols-4 gap-4">

        @csrf

        <input type="text" name="title"
               placeholder="File title"
               class="rounded-lg border-gray-300">

        <input type="file" name="file" id="fileInput"
               class="rounded-lg border-gray-300">
               <input type="hidden" name="file_name" id="file_name">


        <select name="status" class="rounded-lg border-gray-300">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>

<button class="bg-gray-600 text-black dark:text-white rounded-lg px-4 py-2">
            Upload
        </button>
    </form>
</div>

{{-- File List --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($files as $file)
                <tr class="border-t">
                    <td class="px-4 py-3">
                        <a href="{{ asset($file->file_path) }}"
                           target="_blank"
                           class="text-blue-600 underline">
                            {{ $file->title }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-center">
                        {{ $file->status ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST"
                              action="{{ route('admin.tabs.files.destroy', $file->id) }}"
                              onsubmit="return confirm('Delete this file?')">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center p-6 text-gray-500">
                        No files uploaded yet
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    var resumable = new Resumable({
        target: "{{ route('admin.tabs.files.chunk', $tab->id) }}",
        query: {
            _token: "{{ csrf_token() }}",
            title: document.querySelector('input[name="title"]').value,
            status: document.querySelector('select[name="status"]').value
        },
        chunkSize: 2 * 1024 * 1024, // 5MB per chunk
        simultaneousUploads: 3,
        testChunks: false
    });

    resumable.assignBrowse(document.getElementById('fileInput'));

    resumable.on('fileAdded', function(file) {
        resumable.upload();
    });

    resumable.on('fileSuccess', function(file, response) {
        alert('Upload Complete!');
        location.reload();
    });

    resumable.on('fileError', function(file, response) {
        alert('Upload Failed');
        console.log(response);
    });

});
</script>
