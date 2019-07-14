@extends('layouts.app')

@section('content')
  @include('partials.header-archive-plugin')
  @while(have_posts()) @php the_post() @endphp
    <article @php post_class('animate relative content-960 center-relative') @endphp>
        <div class="entry-holder">
          <h2 class="entry-title">
            <a href="{!! get_the_permalink() !!}">{!! the_title() !!}</a>
          </h2>
          {!! get_the_excerpt() !!}
        </div>
        @if(has_post_thumbnail() || get_post_meta(get_the_id(), "post_blog_featured_image", true) !== '')
          <div class="post-thumbnail">
            @if (get_post_meta(get_the_id(), "post_blog_featured_image", true) !== '')
              <a href="{!! get_the_permalink() !!}">
                <img src="{!! get_post_meta(get_the_id(), "post_blog_featured_image", true) !!}" alt="{!! get_the_title() !!}" />
              </a>
            @else
              <a href="{!! get_the_permalink() !!}">{!! get_the_post_thumbnail() !!}</a>
            @endif
          </div>
        @endif
        <div class="clear"></div>
    </article>
  @endwhile
  <div class="clear"></div>
  <div class="pagination-holder">
    @php the_posts_pagination() @endphp
  </div>
@endsection
