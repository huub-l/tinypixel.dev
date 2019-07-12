@extends('layouts.app')

@section('content')
<div @php post_class('portfolio-item-wrapper') @endphp>
  @if(have_posts())
    @while(have_posts()) @php the_post() @endphp
      <div class="portfolio-content center-relative content-1170">
        @php the_content() @endphp
      </div>
      @include('partials.nav-links')
    @endwhile
  @endif
</div>
@endsection
