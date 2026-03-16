@php
    $currentNumber = $numbering ?? 1;
@endphp
<tr class="border-b hover:bg-gray-50">
<td class="px-4 py-3 text-sm text-gray-700 font-semibold">
        <span class="px-2 py-1 bg-gray-100 rounded-md text-xs">
            {{ $currentNumber }}
        </span>
    </td>
    <td class="px-4 py-3 text-gray-800">
        <div class="flex items-center" style="margin-left: {{ $level * 20 }}px;">
            @if($level > 0)
                <span class="mr-2 text-gray-400">↳</span>
            @endif

            <span class="font-medium">
                {{ $tab->name }}
            </span>
        </div>
    </td>

    <td class="px-4 py-3 text-sm text-gray-600">
        {{ ucfirst(str_replace('_', ' ', $tab->page_type)) }}
    </td>

    <td class="px-4 py-3">
        @if($tab->status)
            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                Active
            </span>
        @else
            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                Inactive
            </span>
        @endif
    </td>

    <td class="px-4 py-3 text-right">
        <div class="inline-flex gap-2">

            <a href="{{ route('admin.tabs.edit', $tab->id) }}"
               class="text-blue-600 hover:underline text-sm">
                Edit
            </a>

            <form method="POST"
                  action="{{ route('admin.tabs.destroy', $tab->id) }}"
                  onsubmit="return confirm('Are you sure you want to delete this tab?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="text-red-600 hover:underline text-sm">
                    Delete
                </button>
            </form>

        </div>
    </td>
    <td class="px-4 py-3 text-right">
    <div class="inline-flex items-center gap-3 text-sm">

        {{-- Files (only for leaf tabs) --}}
        @if(!$tab->has_hierarchy)
            <a href="{{ route('admin.tabs.files.index', $tab->id) }}"
               class="px-3 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200">
                📎 Files
            </a>
        @endif

        {{-- Edit --}}
        <a href="{{ route('admin.tabs.edit', $tab->id) }}"
           class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
            ✏️ Edit
        </a>

        {{-- Delete --}}
        <form method="POST"
              action="{{ route('admin.tabs.destroy', $tab->id) }}"
              onsubmit="return confirm('Delete this tab and all its data?')">
            @csrf
            @method('DELETE')
            <button
                class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
                🗑 Delete
            </button>
        </form>
        @if(!$tab->has_hierarchy)
    <a href="{{ route('admin.tabs.table-rows.index', $tab->id) }}"
       class="px-3 py-1 bg-purple-100 text-purple-700 rounded hover:bg-purple-200">
        📊 Table
    </a>
@endif


    </div>
</td>

</tr>


{{-- Render children recursively --}}
@if($tab->childrenRecursive && $tab->childrenRecursive->count())
   @foreach($tab->childrenRecursive as $childIndex => $child)
    @include('admin.partials.row', [
        'tab' => $child,
        'level' => $level + 1,
        'numbering' => $currentNumber . '.' . ($childIndex + 1)
    ])
@endforeach
@endif
