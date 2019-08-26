@extends('layouts.app')

@section('content')
  <div id="content" class="site-content center-relative">

    @while(have_posts()) @php the_post() @endphp
      <article id="post-{!! get_the_id() !!}" @php post_class() @endphp>
        @include('partials.header-' . get_post_type())
        @include('partials.content-single-' . get_post_type())
      </article>

      @include('partials.nav-links')
    @endwhile

  </div>
@endsection
