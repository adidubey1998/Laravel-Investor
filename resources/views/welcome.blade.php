<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
</head>



<body>

@include('layouts.partials.navbar')
<h1 style="margin-left: 120px;"> INVESTORS </h1>

<div class="container investors-sec mt-4">
    <div class="row">

        {{-- LEFT: Investor Menu --}}
        <div class="col-md-3">
            <div id="slide-out" class="nav-mobile">
                @include('layouts.investor-menu', [
    'tabs' => $tabs,
    'level' => 0,
    'numbering' => '',
    'context' => 'welcome',
])

            </div>
        </div>

        {{-- CENTER: Tab Content --}}
      {{-- CENTER: Tab Content --}}
<div class="col-md-6">
    <div class="tab-content">

        @php
            // Check if any tab is active
            $anyTabActive = false;
        @endphp

        @foreach($tabs as $tab)
            @include('layouts.investor-content', [
                'tab' => $tab,
                'isActive' => false
            ])
        @endforeach

        {{-- 🔥 NEWS BLOCK (hidden by default) --}}
        <div id="news-default" class="tab-pane show active">
            <h2>Latest News</h2>

            @foreach($latestNews as $news)
                <div class="mb-3">
                 @if($news->file_path)
                  <a href="{{ asset('storage/'.$news->file_path) }}" target="_blank"><strong>{{ $news->title }}</strong>

                        </a>
                    @endif



                </div>
            @endforeach
        </div>

    </div>
</div>

        {{-- RIGHT: Stock Widget --}}
        <div class="col-md-3">
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





<script>
function toggleMenu(id, el) {
    const menu = document.getElementById(id);
    if (!menu) return;

    const isOpen = menu.style.display === "block";
    menu.style.display = isOpen ? "none" : "block";
    el.classList.toggle("open", !isOpen);
}
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const tabLinks = document.querySelectorAll('[data-bs-toggle="pill"]');
    const newsBlock = document.getElementById('news-default');

    tabLinks.forEach(link => {
        link.addEventListener('click', function () {
            newsBlock.classList.remove('show', 'active');
        });
    });

});
</script>





</body>
</html>
