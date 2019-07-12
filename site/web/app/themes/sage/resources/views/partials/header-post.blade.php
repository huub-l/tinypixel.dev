@if(get_post_meta(get_the_id(), "post_header_content", true) != '')
  <div class="single-post-header-content content-1170 center-relative">
    {!! do_shortcode(get_post_meta(get_the_id(), "post_header_content", true)) !!}
  </div>
@endif

<h1 class="entry-title">@php the_title() @endphp</h1>

@if(has_post_thumbnail())
  <div class="single-post-featured-image">
    @php the_post_thumbnail() @endphp
  </div>
@endif