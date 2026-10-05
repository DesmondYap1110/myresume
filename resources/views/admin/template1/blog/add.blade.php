@push('script')
<x-template1.admin.blog.filepond-init
    :max-files="\App\Http\Controllers\admin\Blog\BlogController::maxImages"
    :label="__('admin.ui.drag_drop_media').' <span class=\'filepond--label-action\'>'.__('admin.ui.browse').'</span><br><small>'.__('admin.ui.first_media_cover_short').'</small>'" />
@endpush

@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

        <x-template1.admin.blog.form-styles />

        <div class="col-12">
            <form action="{{route("blog.create")}}" method="post" enctype="multipart/form-data" class="blog-form">
                @csrf

                {{-- One column, capped for readability. A second column held only
                     the links box once the pictures moved into the tabs, and
                     left most of its height empty. --}}
                <div class="blog-column">
                    <div class="card blog-card">
                        <div class="card-header">
                            <div class="card-title">{{ __('admin.ui.add_blog') }}</div>
                        </div>
                        <div class="card-body">
                            <x-template1.admin.blog.status-switch />

                            {{-- Title, description and that language's pictures
                                 together, so all three tabs read the same. --}}
                            <x-template1.admin.lang-fields
                                :model="new \App\Models\Blog()"
                                extra="admin.template1.blog.partials.locale-images"
                                :fields="[
                                    'title' => ['label' => __('admin.ui.title'), 'type' => 'text', 'required' => true, 'width' => 'col-12', 'placeholder' => __('admin.ui.enter_title')],
                                    'description' => ['label' => __('admin.ui.description'), 'type' => 'rich', 'required' => true],
                                ]" />
                        </div>
                    </div>

                    {{-- Links are the same whichever language the post is read
                         in, so they sit outside the tabs. --}}
                    <div class="card blog-card">
                        <div class="card-body">
                            <x-template1.admin.blog.media-links />
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
