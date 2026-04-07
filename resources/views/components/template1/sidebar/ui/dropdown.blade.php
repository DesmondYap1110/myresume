<li class="nav-item">
    <a data-bs-toggle="collapse" href="#sidebarLayouts">
        <i class="{{ $icon }}"></i>
        <p>{{ $title }}</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="sidebarLayouts">
        <ul class="nav nav-collapse">
        @foreach($menulist as $list)
        <x-template1.sidebar.ui.dropdown-list
            text="{{ $list['text'] }}"
            url="{{ $list['url'] }}"
        />
        @endforeach
        </ul>
    </div>
</li>
