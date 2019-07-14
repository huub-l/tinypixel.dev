<header class="header-holder">
  <div class="menu-wrapper center-relative relative">

    <div class="header-logo">
      @if($header->logo)
        <a href="/">
          @svg('logo-horizontal')
        </a>
      @endif
    </div>

    @include('components/nav.hamburger')

    <div class="menu-holder">
      {!! $navigation !!}
    </div>

    <div class="clear"></div>
  </div>
</header>
