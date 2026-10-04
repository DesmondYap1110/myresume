@props(['label', 'maxFiles' => null])

{{--
    One FilePond setup for every file box on the blog forms, so the main
    picture box and the per-language ones behave and look the same.

    The per-language boxes live inside the language tabs. FilePond measures
    itself when it is built, and one built inside a hidden tab comes out the
    wrong size - the same reason the editor in those tabs is built lazily -
    so each is left until its tab is first opened.
--}}
<script>
(function () {
    var common = {
        allowMultiple: true,
        allowReorder: true,
        acceptedFileTypes: ['image/*', 'video/mp4', 'video/webm'],
        instantUpload: false,  // preview only, files are sent with the form
        storeAsFile: true
    };

    function build(input, options) {
        if (!input || input.dataset.pondReady) return;
        input.dataset.pondReady = '1';
        FilePond.create(input, Object.assign({}, common, options));
    }

    build(document.getElementById('imageInput'), {
        @if($maxFiles) maxFiles: {{ $maxFiles }}, @endif
        labelIdle: {!! json_encode($label) !!}
    });

    function buildPonds(root) {
        (root || document).querySelectorAll('.lf-pond').forEach(function (input) {
            build(input, { labelIdle: {!! json_encode(__('admin.ui.add_more_media').' <span class="filepond--label-action">'.__('admin.ui.browse').'</span>') !!} });
        });
    }

    // The tab that is already open, then the others as they are opened.
    buildPonds(document.querySelector('.lf-panes .tab-pane.active'));

    document.querySelectorAll('.lf-tabs [data-bs-toggle="tab"]').forEach(function (tab) {
        tab.addEventListener('shown.bs.tab', function () {
            buildPonds(document.querySelector(tab.dataset.bsTarget));
        });
    });
})();
</script>
