@php
    $inbox_nav = \App\Models\Inbox::getInboxByUseridStatus(Auth::user()->id);

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
                            <a href="{{route('inbox.status3')}}" class="small">Mark all as read</a>
                        </div>
                    </li>
                    <li>

                        <div class="message-notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                @if(count($inbox_nav))
                                @foreach ($inbox_nav as $item)
                                <a href="{{route('inbox.view.message',$item->id)}}">
                                    <div class="notif-img">
                                        <img src="{{asset("assets/admin/img/default.jpg")}}" alt="Img Profile"/>
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
                                        <span class="block">No Message </span>
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
                        <span class="op-7">Hi,</span>
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
                            <a class="dropdown-item" href="{{route('profile.view')}}">My Profile</a>
                            <a class="dropdown-item" href="{{route('inbox.view')}}">Inbox</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('setting.view')}}">Account Setting</a>

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
