{{--
    Resume PDF, rendered by dompdf (App\Services\ResumePdf).

    dompdf supports CSS 2.1 and a little of CSS3: no flexbox or grid, and a
    single table row cannot split across pages. So the long sections run in
    one column, only short blocks sit side by side, and each job is kept
    whole on a page. All text is escaped; it is plain text by now anyway.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ $name }} - Resume</title>
<style>
    @page { margin: 38px 42px 48px; }
    /* No "* { margin: 0 }" reset: dompdf takes page margins from the root
       element, so a universal reset would wipe out @page margins. */
    body, h2, p, ul, li, div, table, td { margin: 0; padding: 0; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 9.2pt; line-height: 1.5; color: #2c2f33; }

    /* Header card */
    .header { background: #1c1f24; border-radius: 10px; padding: 20px 22px; }
    .header td { vertical-align: middle; }
    .photo { width: 92px; }
    .photo img { width: 80px; height: 80px; }
    .name { font-size: 21pt; font-weight: bold; color: #ffffff; line-height: 1.15; }
    .role { margin-top: 4px; font-size: 8.4pt; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; color: {{ $accent }}; }
    .contact { margin-top: 10px; font-size: 7.9pt; color: #c8ccd2; line-height: 1.7; }
    .contact span { white-space: nowrap; }
    .dot { color: {{ $accent }}; padding: 0 5px; }
    .bar { height: 3px; background: {{ $accent }}; border-radius: 3px; margin: 0 28px; }

    /* Sections */
    h2 { margin: 18px 0 8px; padding-bottom: 5px; font-size: 9.6pt; letter-spacing: 1.8px; text-transform: uppercase;
         color: #1c1f24; border-bottom: 1.5px solid {{ $accent }}; }
    .summary { text-align: justify; color: #3a3d42; }
    table { width: 100%; border-collapse: collapse; }

    /* Skills and strengths, side by side (both short). */
    .split td { vertical-align: top; }
    .split .left { width: 55%; padding-right: 16px; }
    .chip { display: inline-block; margin: 0 4px 5px 0; padding: 2px 8px; font-size: 7.9pt; color: #2c2f33;
            background: #f4f4f1; border: 1px solid #e3e2da; border-radius: 9px; }
    .strength { margin-bottom: 6px; }
    .strength b { color: #1c1f24; }
    .strength span { display: block; font-size: 8.1pt; color: #5b5f66; }

    /* Experience */
    .job { margin-bottom: 11px; page-break-inside: avoid; }
    .job-head td { vertical-align: bottom; }
    .job-role { font-size: 10.2pt; font-weight: bold; color: #1c1f24; }
    .job-period { width: 34%; text-align: right; font-size: 8pt; color: #6b6f76; white-space: nowrap; }
    .job-company { font-size: 8.8pt; font-weight: bold; color: {{ $ink }}; margin-top: 1px; }
    ul { margin: 4px 0 0 14px; padding: 0; }
    li { margin-bottom: 2px; color: #3a3d42; }
    .job p { margin-top: 3px; color: #3a3d42; }

    /* Education */
    .edu { margin-bottom: 8px; page-break-inside: avoid; }
    .edu-year { width: 52px; vertical-align: top; font-weight: bold; color: {{ $ink }}; }
    .edu-title { font-weight: bold; color: #1c1f24; }
    .edu-school { color: #3a3d42; }
    .edu-note { font-size: 8.1pt; color: #6b6f76; }

    .footer { position: fixed; bottom: -30px; left: 0; right: 0; font-size: 7.2pt; color: #9a9ea5; text-align: center; }
</style>
</head>
<body>

<div class="footer">{{ $name }} &middot; {{ $website }} &middot; Updated {{ $generated }}</div>

{{-- ═══ Header ═══ --}}
<div class="header">
    <table>
        <tr>
            @if($photo)
            <td class="photo"><img src="{{ $photo }}" alt=""></td>
            @endif
            <td>
                <div class="name">{{ $name }}</div>
                @if($role)<div class="role">{{ $role }}</div>@endif
                <div class="contact">
                    @php
                        $bits = array_values(array_filter([$email, $phone, $address, $linkedin]));
                    @endphp
                    @foreach($bits as $bit)<span>{{ $bit }}</span>@if(!$loop->last)<span class="dot">&bull;</span>@endif @endforeach
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="bar"></div>

{{-- ═══ Summary ═══ --}}
@if($summary)
<h2>Profile</h2>
<p class="summary">{{ $summary }}</p>
@endif

{{-- ═══ Skills + strengths ═══ --}}
@if(count($skills) || count($services))
<table class="split">
    <tr>
        @if(count($skills))
        <td class="{{ count($services) ? 'left' : '' }}">
            <h2>Skills</h2>
            @foreach($skills as $skill)<span class="chip">{{ $skill }}</span> @endforeach
        </td>
        @endif
        @if(count($services))
        <td>
            <h2>Core Strengths</h2>
            @foreach($services as $item)
            <div class="strength"><b>{{ $item['title'] }}</b>@if($item['description'])<span>{{ \Illuminate\Support\Str::limit($item['description'], 110) }}</span>@endif</div>
            @endforeach
        </td>
        @endif
    </tr>
</table>
@endif

{{-- ═══ Experience ═══ --}}
@if(count($experience))
<h2>Experience</h2>
@foreach($experience as $job)
<div class="job">
    <table class="job-head">
        <tr>
            <td class="job-role">{{ $job['role'] }}</td>
            <td class="job-period">{{ $job['period'] }}</td>
        </tr>
    </table>
    <div class="job-company">{{ $job['company'] }}</div>
    @if(count($job['bullets']))
    <ul>
        @foreach($job['bullets'] as $line)<li>{{ $line }}</li>@endforeach
    </ul>
    @elseif($job['text'])
    <p>{{ $job['text'] }}</p>
    @endif
</div>
@endforeach
@endif

{{-- ═══ Projects ═══ --}}
@if(count($projects))
<h2>Projects</h2>
@foreach($projects as $item)
<div class="job">
    <table class="job-head">
        <tr>
            <td class="job-role">{{ $item['name'] }}</td>
            <td class="job-period">{{ $item['period'] }}</td>
        </tr>
    </table>
    @if($item['company'])<div class="job-company">{{ $item['company'] }}</div>@endif
    @if($item['text'])<p>{{ $item['text'] }}</p>@endif
</div>
@endforeach
@endif

{{-- ═══ Education ═══ --}}
@if(count($education))
@php $hasYears = collect($education)->pluck('year')->filter()->isNotEmpty(); @endphp
<h2>Education</h2>
@foreach($education as $edu)
<table class="edu">
    <tr>
        {{-- The year column only exists when at least one entry has a year. --}}
        @if($hasYears)<td class="edu-year">{{ $edu['year'] ?: '' }}</td>@endif
        <td>
            <div class="edu-title">{{ $edu['certificate'] }}</div>
            <div class="edu-school">{{ $edu['institution'] }}</div>
            @if($edu['achievement'])<div class="edu-note">{{ $edu['achievement'] }}</div>@endif
        </td>
    </tr>
</table>
@endforeach
@endif

</body>
</html>
