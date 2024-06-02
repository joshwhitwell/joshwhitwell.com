<nav class="x-navigation">
  @auth
    <ul class="x-navigation-ul">
      @foreach ($navItems as $navItem)
        <li class="x-navigation-li">
          @if (!empty($navItem['action']))
            <x-form
              :action="$navItem['action']"
              :submit-button-text="$navItem['text']"
            />
          @else
            <a href="{{ $navItem['href'] }}" class="x-navigation-a">{{ $navItem['text'] }}</a>
          @endif
        </li>
      @endforeach
    </ul>
  @endauth
</nav>
