@extends('admin.layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Create New Tab</h1>
    <p class="text-gray-500 text-sm mt-1">
        Add a new investor section or sub-section
    </p>
</div>

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.tabs.store') }}" class="space-y-6">
    @csrf

    {{-- Tab Name --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Tab Name <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
               placeholder="e.g. Financial Results">
    </div>

    {{-- Parent Tab --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Parent Tab
        </label>
        <select name="parent_id"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="">— Main Tab —</option>
            @foreach($parentTabs as $parent)
                <option value="{{ $parent->id }}"
                    {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Page Type --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Page Type <span class="text-red-500">*</span>
        </label>
        <select name="page_type" id="page_type"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="same_page" {{ old('page_type') === 'same_page' ? 'selected' : '' }}>
                Same Page (AJAX)
            </option>
            <option value="new_page" {{ old('page_type') === 'new_page' ? 'selected' : '' }}>
                New Page (Slug URL)
            </option>
        </select>
    </div>

    {{-- Slug --}}
    <div id="slug-field" class="hidden">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Page Slug
        </label>
        <input type="text" name="slug" value="{{ old('slug') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
               placeholder="e.g. annual-reports">
    </div>

    {{-- Hierarchy --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Has Sub Tabs?
        </label>
        <select name="has_hierarchy" id="has_hierarchy"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="1" {{ old('has_hierarchy') == 1 ? 'selected' : '' }}>
                Yes
            </option>
            <option value="0" {{ old('has_hierarchy') == 0 ? 'selected' : '' }}>
                No (Leaf Node)
            </option>
        </select>
    </div>

    {{-- Page Heading --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Page Heading
        </label>
        <input type="text" name="page_heading" value="{{ old('page_heading') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
    </div>

    {{-- Page Description --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Page Description
        </label>
        <textarea name="page_description" rows="4" id="page_description"
                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            {{ old('page_description') }}
        </textarea>
    </div>

    {{-- SEO Section --}}
    <div class="border-t pt-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">
            SEO Settings
        </h2>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Meta Title
                </label>
                <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Meta Description
                </label>
                <textarea name="meta_description" rows="3"
                          class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    {{ old('meta_description') }}
                </textarea>
            </div>
        </div>
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Status
        </label>
        <select name="status"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option value="1" selected>Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>

    {{-- Actions --}}
    <div class="flex gap-4 pt-4">
        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-black rounded-lg hover:bg-blue-700 transition">
            Save Tab
        </button>

        <a href="{{ route('admin.tabs.index') }}"
           class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            Cancel
        </a>
    </div>

</form>

{{-- Page Type Toggle Script --}}
<script>
    function toggleSlugField() {
        const pageType = document.getElementById('page_type').value;
        document.getElementById('slug-field')
            .classList.toggle('hidden', pageType !== 'new_page');
    }

    document.getElementById('page_type').addEventListener('change', toggleSlugField);
    toggleSlugField();
</script>
<script>
$(document).ready(function() {

    $('#page_description').summernote({
        height: 250,
        placeholder: 'Write page description...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });

});
</script>

@endsection
