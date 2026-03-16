<div class="box-inner">

    {{-- Optional Heading --}}
    @if(!empty($content['title']))
        <h3>{{ $content['title'] }}</h3>
    @endif

    {{-- Static HTML Content --}}
    <div class="Corporate-box">
        {!! $content['body'] !!}
    </div>

</div>
