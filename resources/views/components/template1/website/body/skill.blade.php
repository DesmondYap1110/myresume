@props(['skill'])
{{-- Skills as tags. Only template 4 shows the level; here the name is enough. --}}

<section class="resume-section p-3 p-lg-5 d-flex flex-column" id="skills">
    <div class="row my-auto">
        <div class="col-12">
            <h2 class="text-center">Skills</h2>
            <div class="mb-5 heading-border"></div>
        </div>
    </div>
    <div class="row my-auto">
        {{-- theme.js adds the reveal classes; hardcoding them here would hide
             the tags on browsers where the observer never runs. --}}
        <div class="col-12">
            <ul class="skill-tags">
                @foreach($skill as $item)
                <li>{{ $item->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
