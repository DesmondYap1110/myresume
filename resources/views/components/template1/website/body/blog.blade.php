<section class="resume-section p-3 p-lg-5 d-flex flex-column" id="blog">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Blog</h2>
        <div class="mb-5 heading-border"></div>
        </div>

    </div>
    <div class="row my-auto">
        @foreach($blog as $data)
        <div class="col-sm-4 blog-item filter finance">
            <a class="blog-link" href="#post-{{ $data->id }}" data-index="{{ $loop->index }}" aria-label="Read: {{ $data->title }}">
                <div class="caption-port">
                    <div class="caption-port-content">
                        <i class="fa fa-search-plus fa-3x"></i>
                    </div>
                </div>
                <img class="img-fluid" src="{{$data->image}}" alt="{{ $data->title }}">
            </a>
        </div>
        @endforeach

    </div>
</section>

<!--====================================================
                    BLOG MODAL
======================================================-->
<x-template1.website.modal.modal/>

<script>
(function () {
    'use strict';

    var posts = @json($blog->values());
    var current = 0;

    function pad(n) { return (n < 10 ? '0' : '') + n; }

    function readingTime(html) {
        var text = document.createElement('div');
        text.innerHTML = html || '';
        var words = (text.textContent || '').trim().split(/\s+/).filter(Boolean).length;
        return Math.max(1, Math.round(words / 200)) + ' min read';
    }

    function formatDate(value) {
        var d = value ? new Date(value) : null;
        return d && !isNaN(d) ? d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '';
    }

    function render(index) {
        var post = posts[index];
        if (!post) return;
        current = index;

        var total = posts.length;
        var prev = posts[(index - 1 + total) % total];
        var next = posts[(index + 1) % total];

        document.getElementById('blog-title').textContent = post.title;
        document.getElementById('blog-image').src = post.image;
        document.getElementById('blog-image').alt = post.title;
        // Written by the site owner in the admin editor.
        document.getElementById('blog-content').innerHTML = post.description;
        document.getElementById('blog-date').textContent = formatDate(post.created_at);
        document.getElementById('blog-read').textContent = readingTime(post.description);
        document.getElementById('blog-index').textContent = pad(index + 1) + ' / ' + pad(total);
        document.getElementById('blog-prev-title').textContent = prev.title;
        document.getElementById('blog-next-title').textContent = next.title;

        var modal = document.getElementById('portfolioModal');
        modal.querySelector('.post-nav').hidden = total < 2;
        modal.classList.remove('is-switching');
        void modal.offsetWidth; // restart the content animation
        modal.classList.add('is-switching');

        modal.querySelector('.post-panel').scrollTop = 0;
        modal.querySelector('.post-body').scrollTop = 0;
        updateProgress();

        if (history.replaceState) history.replaceState(null, '', '#post-' + post.id);
    }

    function updateProgress() {
        var modal = document.getElementById('portfolioModal');
        // Desktop scrolls the article column; phones scroll the whole panel.
        var el = window.matchMedia('(min-width: 992px)').matches ? modal.querySelector('.post-body') : modal.querySelector('.post-panel');
        var max = el.scrollHeight - el.clientHeight;
        modal.querySelector('.post-progress span').style.transform = 'scaleX(' + (max > 0 ? el.scrollTop / max : 0) + ')';
    }

    window.openPost = function (index) {
        render(index);
        jQuery('#portfolioModal').modal('show');
    };

    window.addEventListener('load', function () {
        var modal = document.getElementById('portfolioModal');
        if (!modal || !posts.length) return;

        document.querySelectorAll('#blog .blog-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                window.openPost(parseInt(link.getAttribute('data-index'), 10));
            });
        });

        modal.querySelectorAll('.post-nav-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var step = parseInt(btn.getAttribute('data-step'), 10);
                render((current + step + posts.length) % posts.length);
            });
        });

        modal.querySelector('.post-body').addEventListener('scroll', updateProgress, { passive: true });
        modal.querySelector('.post-panel').addEventListener('scroll', updateProgress, { passive: true });

        document.addEventListener('keydown', function (e) {
            if (!modal.classList.contains('show') || posts.length < 2) return;
            if (e.key === 'ArrowRight') render((current + 1) % posts.length);
            if (e.key === 'ArrowLeft') render((current - 1 + posts.length) % posts.length);
        });

        jQuery(modal).on('hidden.bs.modal', function () {
            if (history.replaceState) history.replaceState(null, '', location.pathname + location.search);
        });

        // Opening a shared link like /MQ==#post-3 shows that post straight away.
        var match = /^#post-(\d+)$/.exec(location.hash);
        if (match) {
            for (var i = 0; i < posts.length; i++) {
                if (String(posts[i].id) === match[1]) { window.openPost(i); break; }
            }
        }
    });
})();
</script>
