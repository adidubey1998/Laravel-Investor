<ul class="{{ $level === 0 ? 'nav nav-pills flex-column investor-menu' : 'sub-menu list-unstyled ms-3' }}">

@foreach($tabs as $index => $tab)

@php
    $tabId = 'tab-'.$tab->id;

    $currentNumber = ($level === 0)
    ? ($rootIndex ?? ($index+1))
    : $numbering.'.'.($index+1);
        

    $hasChildren = $tab->childrenRecursive->count() > 0;
    $hasContent  = $tab->hasContent();

    $isActive = ($activeTabId ?? null) == $tab->id;

    // Only show:
    // 1. Current tab
    // 2. Parent chain
    // 3. Children of current
    $showTab = false;

    if(isset($activeTabId)) {
        if($tab->id == $activeTabId) {
            $showTab = true;
        }

        elseif($tab->childrenRecursive->pluck('id')->contains($activeTabId)) {
            $showTab = true;
        }

        elseif($tab->parentRecursive && $tab->parentRecursive->id == $activeTabId) {
            $showTab = true;
        }
    } else {
        $showTab = true; // welcome page fallback
    }
@endphp


@if(!$showTab)
    @continue
@endif


{{-- 🚫 Hide empty same_page leaf --}}

@if($tab->page_type === 'new_page' && $tab->has_hierarchy && !$hasContent)
    @continue
@endif

<li class="{{ $hasChildren ? 'menu-item-has-children' : 'nav-item' }}">

    {{-- ================= SAME PAGE LEAF ================= --}}
    @if($tab->page_type === 'same_page' && !$hasChildren)

        <a class="nav-link {{ $isActive ? 'active' : '' }}"
           data-bs-toggle="pill"
           href="#{{ $tabId }}">
            {{ $currentNumber }}. {{ $tab->name }}
        </a>


    {{-- ================= SAME PAGE PARENT ================= --}}
    @elseif($tab->page_type === 'same_page' && $hasChildren)

        <a class="nav-link disabled"
           href="#"
           onclick="return false;">
            {{ $currentNumber }}. {{ $tab->name }}
        </a>


    {{-- ================= NEW PAGE ================= --}}
   @elseif($tab->page_type === 'new_page')

    @php
        $hasFiles = $tab->files && $tab->files->count();
    @endphp

    {{-- CASE 1: new_page + no hierarchy + has files → open as pill --}}
    @if(!$tab->has_hierarchy && $hasFiles)

        <a class="nav-link {{ $isActive ? 'active' : '' }}"
           data-bs-toggle="pill"
           href="#{{ $tabId }}">
            {{ $currentNumber }}. {{ $tab->name }}
        </a>

    {{-- CASE 2: normal new_page with slug → redirect --}}
    @elseif($tab->slug)

        <a href="{{ route('investors.slug', $tab->slug) }}"
           class="nav-link {{ $isActive ? 'active' : '' }}">
            {{ $currentNumber }}. {{ $tab->name }}
        </a>

    @endif

    @endif


    {{-- ================= CHILDREN ================= --}}
    @if($hasChildren)

        @php
            $showChildren = false;

            if($tab->id == ($activeTabId ?? null)) {
                $showChildren = true;
            }

            elseif($tab->childrenRecursive->pluck('id')->contains($activeTabId ?? null)) {
                $showChildren = true;
            }
        @endphp

        @if($showChildren)
            @include('layouts.partials.sidebar', [
                'tabs' => $tab->childrenRecursive,
                'level' => $level + 1,
                'numbering' => $currentNumber,
                'activeTabId' => $activeTabId ?? null
            ])
        @endif

    @endif

</li>

@endforeach

</ul>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Find first visible pill tab inside main menu
    var firstTab = document.querySelector(
        '.main-menu a[data-bs-toggle="pill"]'
    );

    if(firstTab){
        var tab = new bootstrap.Tab(firstTab);
        tab.show();
    }

});
</script>
