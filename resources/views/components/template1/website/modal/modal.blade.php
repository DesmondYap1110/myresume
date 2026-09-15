<!--====================================================
                    BLOG MODAL
======================================================-->
<div class="modal fade post-modal" id="portfolioModal" tabindex="-1" role="dialog" aria-labelledby="blog-title" aria-hidden="true">
    <div class="modal-dialog post-dialog" role="document">
        <div class="modal-content post-panel">
            <div class="post-progress" aria-hidden="true"><span></span></div>

            <button type="button" class="post-close" data-dismiss="modal" aria-label="Close">
                <span></span><span></span>
            </button>

            <div class="post-grid">
                <aside class="post-media">
                    <div class="post-media-frame">
                        <span class="post-corner tl"></span><span class="post-corner tr"></span>
                        <span class="post-corner bl"></span><span class="post-corner br"></span>
                        <img id="blog-image" src="" alt="">
                    </div>
                    <div class="post-media-caption">
                        <span class="post-live"></span>
                        <span id="blog-index">01 / 01</span>
                    </div>
                </aside>

                <article class="post-body">
                    <div class="post-meta">
                        <span class="post-tag">// blog</span>
                        <span><i class="fa fa-calendar-o"></i> <span id="blog-date"></span></span>
                        <span><i class="fa fa-clock-o"></i> <span id="blog-read"></span></span>
                    </div>

                    <h2 id="blog-title" class="post-title"></h2>
                    <div class="post-divider" aria-hidden="true"></div>

                    <div class="post-content" id="blog-content"></div>

                    <nav class="post-nav" aria-label="More posts">
                        <button type="button" class="post-nav-btn prev" data-step="-1">
                            <i class="fa fa-arrow-left"></i>
                            <span><small>Previous</small><b id="blog-prev-title"></b></span>
                        </button>
                        <button type="button" class="post-nav-btn next" data-step="1">
                            <span><small>Next</small><b id="blog-next-title"></b></span>
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </nav>
                </article>
            </div>
        </div>
    </div>
</div>
