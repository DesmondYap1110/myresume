@push('script')
<x-template1.admin.blog.filepond-init
    :label="__('admin.ui.add_more_media').' <span class=\'filepond--label-action\'>'.__('admin.ui.browse').'</span>'" />

<script>
(function () {
    var list = document.getElementById('gallery-list');
    if (!list) return;

    function refresh() {
        var items = list.querySelectorAll('.gallery-row');
        var visible = 0;
        items.forEach(function (row, i) {
            var removed = row.querySelector('.remove-toggle').checked;
            row.classList.toggle('is-removed', removed);
            row.querySelector('.move-up').disabled = i === 0;
            row.querySelector('.move-down').disabled = i === items.length - 1;
            var badge = row.querySelector('.cover-badge');
            badge.hidden = removed || visible !== 0;
            if (!removed) visible++;
        });
    }

    list.addEventListener('click', function (e) {
        var btn = e.target.closest('button');
        if (!btn) return;
        var row = btn.closest('.gallery-row');
        if (btn.classList.contains('move-up') && row.previousElementSibling) {
            list.insertBefore(row, row.previousElementSibling);
        }
        if (btn.classList.contains('move-down') && row.nextElementSibling) {
            list.insertBefore(row.nextElementSibling, row);
        }
        refresh();
    });

    list.addEventListener('change', refresh);
    refresh();
})();
</script>
@endpush

@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

        <x-template1.admin.blog.form-styles />

        <div class="col-12">
            <form action="{{route("blog.update",request()->id)}}" method="post" enctype="multipart/form-data" class="blog-form">
                @csrf

                {{-- One column, capped for readability. A second column held only
                     the links box once the pictures moved into the tabs, and
                     left most of its height empty. --}}
                <div class="blog-column">
                    <div class="card blog-card">
                        <div class="card-header">
                            <div class="card-title">{{ __('admin.ui.edit_blog') }}</div>
                        </div>
                        <div class="card-body">
                            <x-template1.admin.blog.status-switch :blog="$blog" />

                            {{-- Title, description and that language's pictures
                                 together, so all three tabs read the same. --}}
                            <x-template1.admin.lang-fields
                                :model="$blog"
                                extra="admin.template1.blog.partials.locale-images"
                                :extraData="['blog' => $blog]"
                                :fields="[
                                    'title' => ['label' => __('admin.ui.title'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                    'description' => ['label' => __('admin.ui.description'), 'type' => 'rich', 'required' => true],
                                ]" />
                        </div>
                    </div>

                    {{-- Links are the same whichever language the post is read
                         in, so they sit outside the tabs. Were only on the add
                         form before, so they could be set but never changed. --}}
                    <div class="card blog-card">
                        <div class="card-body">
                            <x-template1.admin.blog.media-links :urls="$blog->mediaUrls()" />
                        </div>

                        {{-- Part of the card rather than a bar floating under
                             it, so the buttons belong to the form they save. --}}
                        <div class="card-action blog-actions">
                            <a href="{{ route('blog.view') }}" class="btn btn-light">{{ __('admin.ui.cancel') }}</a>
                            <button class="btn btn-success"><i class="fas fa-check me-1"></i> {{ __('admin.ui.submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

</x-template1.admin.master.master-layout>
