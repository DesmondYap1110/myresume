@props(['blog'])

{{--
    The links saved under "Video & social links" on a post.

    These were being collected and stored but never shown anywhere, so a
    YouTube link on a post did nothing. Each provider gets the frame it needs:
    a 16:9 box for video, a taller one for Instagram, X's own widget for a
    post, and anything unrecognised is just a link.
--}}
@php
    $media = \App\Support\MediaEmbed::parseMany($blog->mediaUrls());
@endphp

@if($media)
<div class="media-embeds">
    @foreach($media as $item)
        @if($item['provider'] === 'link')
            <a class="media-embed-link" href="{{ $item['url'] }}" target="_blank" rel="noopener nofollow">
                {{ $item['url'] }}
            </a>
        @elseif($item['provider'] === 'twitter')
            {{-- X renders its own card from this markup; the script is loaded
                 below only when a post actually has one. --}}
            <blockquote class="twitter-tweet"><a href="{{ $item['url'] }}"></a></blockquote>
        @else
            <div @class([
                'media-embed',
                'is-portrait' => $item['provider'] === 'instagram',
            ])>
                <iframe src="{{ $item['embed'] }}"
                        title="{{ $item['label'] }}"
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
            </div>
        @endif
    @endforeach
</div>

@once
<style>
    .media-embeds { margin: 22px 0; display: grid; gap: 16px; }

    /* A ratio box rather than a fixed height, so the frame keeps its shape at
       any width. */
    .media-embed { position: relative; width: 100%; aspect-ratio: 16 / 9;
        border-radius: 10px; overflow: hidden; background: #000; }
    .media-embed.is-portrait { aspect-ratio: 9 / 13; max-width: 420px; background: transparent; }
    .media-embed iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }

    .media-embed-link { display: inline-block; word-break: break-all; }

    /* aspect-ratio is widely supported now, but an old browser would collapse
       the box to nothing without this. */
    @supports not (aspect-ratio: 16 / 9) {
        .media-embed { height: 0; padding-bottom: 56.25%; }
        .media-embed.is-portrait { padding-bottom: 144%; }
    }
</style>
@endonce

@once
    @if(\App\Support\MediaEmbed::needsTwitterScript($media))
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    @endif
@endonce
@endif
