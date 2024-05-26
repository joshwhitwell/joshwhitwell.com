<nav>
  <ul>
    <li>
      <a href="{{ route('joshwhitwell') }}"> Josh Whitwell </a>
    </li>
    <li>
      <a href="{{ route('me') }}"> Me </a>
    </li>
    <li>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a
          href="{{ route('logout') }}"
          onclick="event.preventDefault(); this.closest('form').submit();"
        >
          Log Out
        </a>
      </form>
    </li>
  </ul>
</nav>
