<style>
.investor-menu .nav-link {
    color: #d0d0d0;
    padding: 8px 12px;
    transition: 0.2s ease;
}

.investor-menu .nav-link:hover {
    background: #2a2a2a;
    color: #ffffff;
}

.investor-menu .nav-link.active {
    background: #1e5eff;
    color: #fff;
    border-radius: 6px;
}

.menu-row {
    padding-right: 8px;
}

.toggle-icon {
    color: #aaa;
    font-size: 14px;
    transition: 0.3s ease;
    cursor: pointer;
}

.toggle-icon i.rotate {
    transform: rotate(180deg);
}

</style>
<ul class="{{ $level === 0 ? 'nav nav-pills flex-column investor-menu' : 'sub-menu list-unstyled ms-3' }}">

@foreach($tabs as $index => $tab)

@php
    $tabId = 'tab-'.$tab->id;

    $currentNumber = $numbering
        ? $numbering.'.'.($index+1)
        : ($index+1);

    $hasContent  = $tab->hasContent();
    $hasChildren = $tab->childrenRecursive->count() > 0;
@endphp


{{-- Hide empty leaf --}}
@if($tab->page_type === 'same_page' && !$hasContent && !$hasChildren)
    @continue
@endif


<li class="nav-item">

    <div class="d-flex justify-content-between align-items-center menu-row">

        {{-- SAME PAGE LEAF --}}
        @if($tab->page_type === 'same_page' && !$hasChildren)

            <a class="nav-link"
               data-bs-toggle="pill"
               href="#{{ $tabId }}">
                {{ $currentNumber }}. {{ $tab->name }}
            </a>

        {{-- SAME PAGE PARENT --}}
        @elseif($tab->page_type === 'same_page' && $hasChildren)

            <a class="nav-link disabled"
               href="#"
               onclick="return false;">
                {{ $currentNumber }}. {{ $tab->name }}
            </a>

        {{-- NEW PAGE --}}
        @elseif($tab->page_type === 'new_page' && $tab->slug)

            <a href="{{ route('investors.slug', $tab->slug) }}"
               class="nav-link">
                {{ $currentNumber }}. {{ $tab->name }}
            </a>

        @endif


        {{-- SINGLE CHEVRON ICON --}}
      @if($hasChildren && $tab->page_type === 'same_page')
    <span class="toggle-icon"
          onclick="toggleMenu('collapse-{{ $tab->id }}', this)">
        <i class="bi bi-chevron-down"></i>
    </span>
@endif

    </div>


    {{-- CHILDREN --}}
    @if($hasChildren && $tab->page_type === 'same_page')
    <ul class="sub-menu list-unstyled ms-3"
        id="collapse-{{ $tab->id }}"
        style="display:none;">

        @include('layouts.investor-menu', [
            'tabs' => $tab->childrenRecursive,
            'level' => $level + 1,
            'numbering' => $currentNumber
        ])

    </ul>
@endif


</li>

@endforeach

</ul>
<script>
function toggleMenu(id, el) {
    const menu = document.getElementById(id);
    if (!menu) return;

    const icon = el.querySelector("i");

    if (menu.style.display === "block") {
        menu.style.display = "none";
        icon.classList.remove("rotate");
    } else {
        menu.style.display = "block";
        icon.classList.add("rotate");
    }
}

</script>