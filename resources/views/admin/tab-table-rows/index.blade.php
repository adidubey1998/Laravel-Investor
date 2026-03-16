@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">
            Table Data: {{ $tab->name }}
        </h1>
        <p class="text-gray-500 text-sm">
            Manage table rows for this tab
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

{{-- Add Row --}}
<div class="bg-white rounded-xl shadow p-6 mb-8">

    <form method="POST"
          action="{{ route('admin.tabs.table-rows.store', $tab->id) }}"
          enctype="multipart/form-data"
          class="grid grid-cols-1 md:grid-cols-5 gap-4">

        @csrf

        {{-- Name of Director --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Name of the Director
            </label>

            <input type="text"
                   name="column_name"
                   placeholder="Enter Director Name"
                   class="w-full rounded-lg border-gray-300"
                   required>
        </div>


        {{-- Designation --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Designation
            </label>

            <input type="text"
                   name="column_value"
                   placeholder="Enter Designation"
                   class="w-full rounded-lg border-gray-300">
        </div>


        {{-- Profile Description --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Profile Description
            </label>

            <textarea name="profile_text"
                      id="summernote"
                      placeholder="Write director profile"
                      class="w-full rounded-lg border-gray-300"
                      rows="3"></textarea>
        </div>


        {{-- Status --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Status
            </label>

            <select name="status"
                    class="w-full rounded-lg border-gray-300">

                <option value="1">Active</option>
                <option value="0">Inactive</option>

            </select>
        </div>


        {{-- Submit --}}
        <div class="flex items-end">
            <button class="bg-gray-600 text-black rounded-lg px-4 py-2 w-full">
                Add Row
            </button>
        </div>

    </form>

</div>

{{-- Rows List --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">Column</th>
                <th class="px-4 py-3 text-left">Value</th>
                <th class="px-4 py-3 text-center">Profile</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rows as $row)
                <tr class="border-t">
                    <td class="px-4 py-3">
                        {{ $row->column_name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $row->column_value }}
                    </td>

                    {{-- PDF --}}
                    <td class="px-4 py-3 text-center">
                        @if($row->file_path)
                        <a href="#"
                        class="text-blue-600 "
                        data-profile="{{ $row->file_path }}">
                        {!! $row->file_path !!}
                        </a>
                        @else
                        <span class="text-gray-500">No Profile</span>
                        @endif
                        </td>

                    <td class="px-4 py-3 text-center">
                        {{ $row->status ? 'Active' : 'Inactive' }}
                    </td>

                    <td class="px-4 py-3 text-right">
                        <form method="POST"
                              action="{{ route('admin.tabs.table-rows.destroy', $row->id) }}"
                              onsubmit="return confirm('Delete this row?')">
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
                    <td colspan="5" class="text-center p-6 text-gray-500">
                        No table rows added yet
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


<script>
$('#summernote').summernote({
    height:200
});
</script>

@endsection
