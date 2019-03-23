<nav class="top-nav">
  <div class="max-w-lg w-full mx-auto flex flex-wrap flex-grow items-start justify-start md:justify-center">
    <div class="title">
      <a href="/">
        @svg('logo_horizontal_white')
      </a>
    </div>
    @if (has_nav_menu('primary_navigation'))
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
    @endif
  </div>
</nav>
  