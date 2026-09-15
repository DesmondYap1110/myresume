<section class="resume-section p-3 p-lg-5 d-flex flex-column" id="blog">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Blog</h2>
        <div class="mb-5 heading-border"></div>
        </div>

    </div>
    <div class="row my-auto">
        <?php $__currentLoopData = $blog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-sm-4 blog-item filter finance">
            <a class="blog-link" href="#post-<?php echo e($data->id); ?>" data-index="<?php echo e($loop->index); ?>" aria-label="Read: <?php echo e($data->title); ?>">
                <div class="caption-port">
                    <div class="caption-port-content">
                        <i class="fa fa-search-plus fa-3x"></i>
                    </div>
                </div>
                <?php if($data->images->count() > 1): ?>
                <span class="blog-count"><i class="fa fa-clone"></i> <?php echo e($data->images->count()); ?></span>
                <?php endif; ?>
                <img class="img-fluid" src="<?php echo e(optional($data->images->first())->url ?: $data->image); ?>" alt="<?php echo e($data->title); ?>">
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</section>

<!--====================================================
                    BLOG MODAL
======================================================-->
<?php if (isset($component)) { $__componentOriginalf1a18a487b70dfb757bb0fe437f9fce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf1a18a487b70dfb757bb0fe437f9fce1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.modal.modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.modal.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf1a18a487b70dfb757bb0fe437f9fce1)): ?>
<?php $attributes = $__attributesOriginalf1a18a487b70dfb757bb0fe437f9fce1; ?>
<?php unset($__attributesOriginalf1a18a487b70dfb757bb0fe437f9fce1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf1a18a487b70dfb757bb0fe437f9fce1)): ?>
<?php $component = $__componentOriginalf1a18a487b70dfb757bb0fe437f9fce1; ?>
<?php unset($__componentOriginalf1a18a487b70dfb757bb0fe437f9fce1); ?>
<?php endif; ?>

<?php
    // Only what the modal needs: id, title, description, date and image URLs.
    $postsData = $blog->map(function ($b) {
        $images = $b->images->pluck('url')->filter()->values()->all();

        return [
            'id' => $b->id,
            'title' => $b->title,
            'description' => $b->description,
            'created_at' => optional($b->created_at)->toIso8601String(),
            'images' => $images ?: array_values(array_filter([$b->image])),
        ];
    })->values();
?>
<script>
(function () {
    'use strict';

    var posts = <?php echo json_encode($postsData, 15, 512) ?>;

    var current = 0;
    var currentImage = 0;

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

    // Keeps a shareable link in the address bar; never allowed to block the modal.
    function setUrl(hash) {
        try {
            history.replaceState(null, '', hash || location.pathname + location.search);
        } catch (e) { /* e.g. sandboxed or file:// pages */ }
    }

    function showImage(index) {
        var post = posts[current];
        var images = post.images;
        if (!images.length) return;

        currentImage = (index + images.length) % images.length;
        var url = images[currentImage];
        var img = document.getElementById('blog-image');

        img.classList.remove('is-changing');
        void img.offsetWidth;
        img.classList.add('is-changing');
        img.src = url;
        img.alt = post.title + (images.length > 1 ? ' - image ' + (currentImage + 1) : '');
        document.getElementById('blog-image-link').href = url;
        document.getElementById('blog-image-count').textContent = (currentImage + 1) + ' / ' + images.length;

        document.querySelectorAll('#blog-thumbs .post-thumb').forEach(function (thumb, i) {
            var active = i === currentImage;
            thumb.classList.toggle('is-active', active);
            thumb.setAttribute('aria-current', active ? 'true' : 'false');
        });
    }

    function render(index) {
        var post = posts[index];
        if (!post) return;
        current = index;

        var total = posts.length;
        var prev = posts[(index - 1 + total) % total];
        var next = posts[(index + 1) % total];
        var modal = document.getElementById('portfolioModal');
        var multi = post.images.length > 1;

        document.getElementById('blog-title').textContent = post.title;
        // Written by the site owner in the admin editor.
        document.getElementById('blog-content').innerHTML = post.description;
        document.getElementById('blog-date').textContent = formatDate(post.created_at);
        document.getElementById('blog-read').textContent = readingTime(post.description);
        document.getElementById('blog-index').textContent = pad(index + 1) + ' / ' + pad(total);
        document.getElementById('blog-prev-title').textContent = prev.title;
        document.getElementById('blog-next-title').textContent = next.title;
        modal.querySelector('.post-nav').hidden = total < 2;

        // Gallery thumbnails
        var thumbs = document.getElementById('blog-thumbs');
        thumbs.innerHTML = '';
        post.images.forEach(function (url, i) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'post-thumb';
            btn.setAttribute('aria-label', 'Show image ' + (i + 1));
            var img = document.createElement('img');
            img.src = url;
            img.alt = '';
            btn.appendChild(img);
            btn.addEventListener('click', function () { showImage(i); });
            thumbs.appendChild(btn);
        });
        thumbs.hidden = !multi;
        modal.classList.toggle('has-gallery', multi);
        showImage(0);

        modal.classList.remove('is-switching');
        void modal.offsetWidth; // restart the content animation
        modal.classList.add('is-switching');

        modal.querySelector('.post-panel').scrollTop = 0;
        modal.querySelector('.post-body').scrollTop = 0;
        updateProgress();

        setUrl('#post-' + post.id);
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

        modal.querySelectorAll('.post-gallery-arrow').forEach(function (btn) {
            btn.addEventListener('click', function () {
                showImage(currentImage + parseInt(btn.getAttribute('data-image-step'), 10));
            });
        });

        modal.querySelector('.post-body').addEventListener('scroll', updateProgress, { passive: true });
        modal.querySelector('.post-panel').addEventListener('scroll', updateProgress, { passive: true });

        // Arrow keys flip through this post's images.
        document.addEventListener('keydown', function (e) {
            if (!modal.classList.contains('show')) return;
            if (e.key === 'ArrowRight') showImage(currentImage + 1);
            if (e.key === 'ArrowLeft') showImage(currentImage - 1);
        });

        jQuery(modal).on('hidden.bs.modal', function () { setUrl(''); });

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
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/website/body/blog.blade.php ENDPATH**/ ?>