<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    <div class="site-wrapper">
      <div class="doc-loader"></div>

      @include('partials.header')

      <main class="main" role="document">
        @yield('content')
      </main>

      @if (App\display_sidebar())
        <aside class="sidebar">
          @include('partials.sidebar')
        </aside>
      @endif

      @php do_action('get_footer') @endphp
      @include('partials.footer')

    </div>
    @php wp_footer() @endphp
  </body>
</html>
