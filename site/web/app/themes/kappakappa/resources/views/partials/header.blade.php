<header class="header-holder">
  <div class="menu-wrapper center-relative relative">

    <div class="header-logo">
      @if($data->header->logo) :
        <a href="{!! $site_url !!}">
          <img src="{!! $data->header->logo !!}" alt="{!! $site_name !!}" />
        </a>
      @endif
    </div>

    <div class="toggle-holder">
      <div id="toggle" class="">
        <div class="first-menu-line"></div>
        <div class="second-menu-line"></div>
        <div class="third-menu-line"></div>
      </div>
    </div>

    <div class="menu-holder">
      {!! $custom_menu !!}
    </div>

    <div class="clear"></div>
  </div>
</header>