<header class="header-holder">
  <div class="menu-wrapper center-relative relative">

    <div class="header-logo">
      @if($data->header->logo)
        <a href="/">
          <img src="{!! $data->header->logo !!}" alt="{!! $site_name !!}" />
        </a>
      @endif
    </div>

    @include('components/nav.hamburger')

    <div class="menu-holder">
      {!! $primary_navigation !!}
    </div>

    <div class="clear"></div>
  </div>
</header>