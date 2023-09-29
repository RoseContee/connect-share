<aside class="right-sidebar">
    <nav class="bg-white">
        <ul class="nav nav-pills nav-sidebar flex-column">
            @foreach ($shortcuts as $shortcut)
                <li class="nav-item px-1 py-2">
                    <a href="{{ $shortcut['link'] }}" target="_blank">
                        <img src="{{ asset($shortcut['icon']) }}" alt="{{ $shortcut['title'] }}" class="icon-32">
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>
