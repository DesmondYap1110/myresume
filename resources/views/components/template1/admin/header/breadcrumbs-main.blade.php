
<div class="page-header">
    <h3 class="fw-bold mb-3">{{ $breadcrumbs['CurrentPage']}}</h3>
    @if(isset($breadcrumbs['isDashboard']))
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ $breadcrumbs['homeUrl'] }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ $breadcrumbs['CurrentUrl']}}">{{ $breadcrumbs['CurrentPage']}}</a></li>
        @if(isset($breadcrumbs['list']))
        @foreach($breadcrumbs['list'] as $list)
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ $list['url'] }}">{{ $list['text']}}</a></li>
        @endforeach
        @endif
    </ul>
    @endif
</div>
