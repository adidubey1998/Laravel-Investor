<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')

    <title>{{ $tab->page_heading ?? $tab->name }}</title>
</head>

<body>

@include('layouts.partials.navbar')
<h1 style="margin-left: 120px;"> INVESTORS </h1>
<div class="container investors-sec">
<div class="row">

{{-- ================= LEFT MENU ================= --}}
<div class="col-sm-3">

<div id="slide-out">
<div class="nav-mobile">
<div class="main-menu">
@php
    // If slug page → show only root + current branch
    if(($context ?? null) === 'slug'){
        $sidebarTabs = [$rootTab];
    } else {
        $sidebarTabs = [$rootTab];
    }
@endphp

@include('layouts.partials.sidebar', [
    'tabs' => $sidebarTabs,
    'level' => 0,
    'numbering' => $rootIndex ?? 1,
    'context' => 'slug',
    'currentTab' => $tab
])


</div>
</div>
</div>

</div>

{{-- ================= CONTENT ================= --}}
<div class="col-sm-6 shadow">

<div class="tab-content">

@include('layouts.partials.content', [
     'tab' => $rootTab,
    'activeTabId' => $activeTabId ?? null
])


</div>

</div>

{{-- ================= STOCK ================= --}}
<div class="col-sm-3">
<div class="Stock-box">
<h2>Stock Quote</h2>

<a href="https://www.nseindia.com/" target="_blank">
<img src="https://www.lemontreehotels.com/kimages/investorss1.gif"
class="img-fluid">
</a>

</div>
</div>

</div>
</div>

@include('layouts.partials.footer')
@include('layouts.partials.scripts')

</body>
</html>
