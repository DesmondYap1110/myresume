{{--
    Shared look for the blog Add and Edit forms, so the two stay the same
    shape: one column of cards, each language's title, description and
    pictures together in that language's tab.
--}}
<style>
    /* Capped rather than full width: a line of text running the whole width of
       a desktop screen is hard to read back. */
    .blog-column { max-width: 1040px; }

    .blog-form .blog-card { margin-bottom: 18px; }
    /* Equal above and below the title: zeroing only the bottom left 14px of
       space over it and none under it. */
    .blog-form .blog-card .card-header { padding-top: 16px; padding-bottom: 16px; }
    .blog-form .blog-card .card-title { font-size: 1rem; font-weight: 600; }
    .blog-form .blog-card > .card-body { padding-top: 14px; }

    /* Inside the card it saves, not a bar floating beneath it.

       The theme gives .card-action 30px all round against the body's 1.25rem,
       so the buttons sat further in than the content above them and the strip
       was 102px tall for a 41px button. */
    .blog-form .card .card-action.blog-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 1rem 1.25rem;
        border-top: 1px solid #ebedf2;
    }

    .blog-actions .btn { min-width: 120px; }

    /* The pictures already on the post. Two lines - thumbnail and name, then
       the buttons - so a long file name still has room to show. */
    .gallery-list { list-style: none; padding: 0; margin: 0 0 12px; }
    .gallery-row { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; padding: 8px; margin-bottom: 8px;
        border: 1px solid #ebedf2; border-radius: 8px; background: #fff; transition: opacity .2s ease; }
    .gallery-row img, .gallery-row .gallery-thumb { width: 48px; height: 48px; object-fit: cover; border-radius: 6px; flex: 0 0 auto; }
    .gallery-row .meta { flex: 1 1 160px; min-width: 0; font-size: 13px; }
    .gallery-row .meta .name { display: block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #6c757d; }
    .gallery-row .actions { display: flex; align-items: center; justify-content: flex-end; gap: 4px; flex: 0 0 auto; }
    .gallery-row.is-removed { opacity: .45; }
    .gallery-row.is-removed img { filter: grayscale(1); }
    .cover-badge { display: inline-block; font-size: 11px; font-weight: 600; padding: 1px 8px; border-radius: 999px;
        background: var(--brand-primary, #212529); color: var(--brand-button-text, #FFD700); margin-bottom: 4px; }

    /* Each language's pictures, at the foot of that language's tab. */
    .lf-images { margin-top: 10px; padding-top: 14px; border-top: 1px solid #ebedf2; }
    .lf-images > label { font-weight: 600; }

    @media (max-width: 575px) {
        .blog-actions .btn { flex: 1; min-width: 0; }
        .gallery-row .actions { flex: 1 1 100%; }
    }
</style>
