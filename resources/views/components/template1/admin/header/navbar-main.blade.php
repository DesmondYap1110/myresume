@php
    $inbox_nav = $inboxUnread;
@endphp
<!-- Navbar Header -->
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a
                    class="nav-link dropdown-toggle"
                    href="javascript:void(0);"
                    id="messageDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                <i class="fa fa-envelope"></i>
                @if(count($inbox_nav))
                <span class="notification">{{count($inbox_nav)}}</span>
                @endif
                </a>

                <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                    <li>
                        <div class="dropdown-title d-flex justify-content-between align-items-center">
                            Messages
                            <a href="{{route('inbox.status3')}}" class="small">{{ __('admin.ui.mark_all_as_read') }}</a>
                        </div>
                    </li>
                    <li>

                        <div class="message-notif-scroll scrollbar-outer">
                            <div class="notif-center" id="topbarInboxList">
                                @if(count($inbox_nav))
                                @foreach ($inbox_nav as $item)
                                <a href="{{route('inbox.view.message',$item->id)}}">
                                    <div class="notif-img">
                                        <img src="{{asset("assets/admin/img/default.jpg")}}" alt="{{ __('admin.ui.profile_image') }}"/>
                                    </div>
                                    <div class="notif-content">
                                        <span class="subject">{{$item->name}}</span>
                                        <span class="block"> {{\Illuminate\Support\Str::words($item->subject, 4, '...')}} </span>
                                        <span class="time">{{$item->created_at->diffForHumans()}}</span>
                                    </div>
                                </a>

                                @endforeach

                                @else

                                <a href="javascript:void(0);" class="d-flex justify-content-center align-items-center">
                                    <div class="notif-content">
                                        <span class="block">{{ __('admin.ui.no_message') }} </span>
                                    </div>
                                </a>
                                @endif

                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="{{route('inbox.view')}}">
                        See all messages
                        <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>

            @push('script')
            <script>
            (function () {
                var badgeLink = document.getElementById('messageDropdown');
                var listEl = document.getElementById('topbarInboxList');
                var sidebarBadge = document.getElementById('sidebarInboxBadge');
                if (!badgeLink || !listEl) return;

                var url = @json(route('inbox.unread'));
                var defaultImg = @json(asset('assets/admin/img/default.jpg'));
                var pollMs = 25000;
                var timer = null;

                function esc(s) {
                    var d = document.createElement('div');
                    d.textContent = s == null ? '' : s;
                    return d.innerHTML;
                }

                function render(data) {
                    var badge = badgeLink.querySelector('.notification');
                    if (data.count > 0) {
                        if (!badge) {
                            badge = document.createElement('span');
                            badge.className = 'notification';
                            badgeLink.appendChild(badge);
                        }
                        badge.textContent = data.count;
                    } else if (badge) {
                        badge.remove();
                    }

                    if (sidebarBadge) {
                        sidebarBadge.textContent = data.count;
                        sidebarBadge.style.display = data.count > 0 ? '' : 'none';
                    }

                    if (!data.items.length) {
                        listEl.innerHTML = '<a href="javascript:void(0);" class="d-flex justify-content-center align-items-center">'
                            + '<div class="notif-content"><span class="block">{{ __('admin.ui.no_message') }} </span></div></a>';
                        return;
                    }

                    listEl.innerHTML = data.items.map(function (item) {
                        return '<a href="' + esc(item.url) + '">'
                            + '<div class="notif-img"><img src="' + esc(defaultImg) + '" alt="{{ __('admin.ui.profile_image') }}"/></div>'
                            + '<div class="notif-content">'
                            + '<span class="subject">' + esc(item.name) + '</span>'
                            + '<span class="block"> ' + esc(item.subject) + ' </span>'
                            + '<span class="time">' + esc(item.time) + '</span>'
                            + '</div></a>';
                    }).join('');
                }

                function poll() {
                    fetch(url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                        .then(function (r) { return r.ok ? r.json() : null; })
                        .then(function (data) { if (data) render(data); })
                        .catch(function () { /* quiet - the next tick retries */ });
                }

                // The page already rendered fresh data server-side, so the
                // first poll waits a full interval; only a tab regaining
                // focus (where the count may be stale) polls immediately.
                function start(immediate) {
                    if (timer) return;
                    if (immediate) poll();
                    timer = setInterval(poll, pollMs);
                }

                function stop() {
                    if (!timer) return;
                    clearInterval(timer);
                    timer = null;
                }

                document.addEventListener('visibilitychange', function () {
                    if (document.hidden) { stop(); } else { start(true); }
                });

                if (!document.hidden) start(false);
            })();
            </script>
            @endpush

            {{-- Same choice as the public site: it is stored in the session,
                 so switching here switches there too. --}}
            @php
                $bolocales = (array) config('locales.supported', []);
                $bocurrent = app()->getLocale();
            @endphp
            @if(count($bolocales) > 1)
            <li class="nav-item">
                <div class="bo-lang" role="group" aria-label="{{ __('site.label.language') }}">
                    @foreach($bolocales as $code => $meta)
                        @if($code === $bocurrent)
                        <span class="bo-lang-item is-active" aria-current="true">{{ $meta['flag'] ?? strtoupper($code) }}</span>
                        @else
                        <a class="bo-lang-item" href="{{ request()->fullUrlWithQuery(['lang' => $code]) }}"
                           title="{{ $meta['native'] ?? $code }}">{{ $meta['flag'] ?? strtoupper($code) }}</a>
                        @endif
                    @endforeach
                </div>
            </li>
            @endif

            <li class="nav-item topbar-user dropdown hidden-caret">
                <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                >
                    <div class="avatar-sm">
                        <img
                            @if(!Auth::user()->image)
                            src="{{asset("assets/admin/img/default.jpg")}}"
                            @else
                             src="{{Auth::user()->image}}"
                            @endif
                            alt="{{Auth::user()->name}}"
                            class="avatar-img rounded-circle"

                        />
                    </div>
                    <span class="profile-username">
                        <span class="op-7">{{ __('admin.label.hi') }}</span>
                        <span class="fw-bold">{{Auth::user()->name}}</span>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img
                                        @if(!Auth::user()->image)
                                        src="{{asset("assets/admin/img/default.jpg")}}"
                                        @else
                                        src="{{Auth::user()->image}}"
                                        @endif

                                        alt="image profile"
                                        class="avatar-img rounded-circle"
                                    />
                                </div>
                                <div class="u-text">
                                    <h4>{{Auth::user()->name}}</h4>
                                    <p class="text-muted">{{\Illuminate\Support\Str::limit(Auth::user()->email,20)}}</p>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('profile.view')}}">{{ __('admin.ui.my_profile') }}</a>
                            <a class="dropdown-item" href="{{route('inbox.view')}}">Inbox</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('setting.view')}}">{{ __('admin.ui.account_setting') }}</a>

                            <div class="dropdown-divider"></div>

                            <a
                                class="dropdown-item"
                                href="{{ route('login.logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                            >
                                Logout
                            </a>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- End Navbar -->
