@extends('layouts.app')

@section('content')
  <div id="content" class="site-content">
    @include('partials.header-archive')
    <div class="clear"></div>
    <div class="blog-holder block center-relative">
      @while(have_posts()) @php the_post() @endphp
        <article @php post_class('animate relative blog-item-holder') @endphp>
            <div class="entry-holder">
              <div class="entry-info">
                <div class="entry-date published">
                  {!! get_the_date() !!}
                </div>
              </div>
              <h2 class="entry-title">
                <a href="{!! get_the_permalink() !!}">{!! the_title() !!}</a>
              </h2>
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
    </div>
  </div>
@endsection
