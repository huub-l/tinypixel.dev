@extends('layouts.app')

@section('content')
  <div id="content" class="site-content">
    @while(have_posts()) @php the_post() @endphp
      <div @php post_class() @endphp>
        <div class="section-wrapper">
          <div class="content-wrapper block content-1170 center-relative">
            @include('partials.header-page')
            @include('partials.content-page')
            <div class="clear"></div>
          </div>
        </div>
      </div>
    @endwhile
  </div>
@endsection
