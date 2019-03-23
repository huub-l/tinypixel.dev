@section('content')
  <div id="content" class="site-content">
    <div class="header-content center-relative block archive-title">
      <h1 class="entry-title">{!! $title !!}</h1>
    </div>
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
                <a href="{!! the_permalink($post->ID) !!}">{!! the_title() !!}</a>
              </h2>
            </div>
            @if (has_post_thumbnail($post->ID) || get_post_meta($post->ID, "post_blog_featured_image", true) !== '') : ?>
              <div class="post-thumbnail">
                @if (get_post_meta($post->ID, "post_blog_featured_image", true) !== '')
                  <a href="{!! get_the_permalink($post->ID) !!}">
                    <img src="{!! get_post_meta($post->ID, "post_blog_featured_image", true) !!}" alt="{!! get_the_title() !!}" />
                  </a>
                @else
                  <a href="{!! get_the_permalink($post->ID) !!}">{!! get_the_post_thumbnail() !!}</a>
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