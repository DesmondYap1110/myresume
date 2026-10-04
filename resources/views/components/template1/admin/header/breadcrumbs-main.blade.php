@php
    /*
     * Breadcrumb text is the module's own name - "Profile", "Add Education" -
     * so it is looked up by that name and left alone when there is no entry.
     * That keeps the parts that are not module names, like a member's own
     * name on the detail page, exactly as they are.
     */
    $crumb = function ($text) {
        $text = (string) $text;
        $slug = \Illuminate\Support\Str::snake(str_replace([' ', '-', '/'], '_', strtolower(trim($text))));

        foreach (['admin.menu.'.$slug, 'admin.ui.'.$slug] as $key) {
            $found = __($key);

            if ($found !== $key) {
                return $found;
            }
        }

        return $text;
    };
@endphp

<div class="page-header">
    <h3 class="fw-bold mb-3">{{ $crumb($breadcrumbs['CurrentPage']) }}</h3>
    @if(isset($breadcrumbs['isDashboard']))
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ $breadcrumbs['homeUrl'] }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ $breadcrumbs['CurrentUrl']}}">{{ $crumb($breadcrumbs['CurrentPage']) }}</a></li>
        @if(isset($breadcrumbs['list']))
        @foreach($breadcrumbs['list'] as $list)
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ $list['url'] }}">{{ $crumb($list['text']) }}</a></li>
        @endforeach
        @endif
    </ul>
    @endif
</div>
