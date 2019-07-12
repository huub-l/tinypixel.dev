<div class="single-content-wrapper content-960 center-relative">
  @include('partials.entry-meta')
  <div class="entry-content">
    @php the_content() @endphp
    @php wp_link_pages([
        'before' => '<p class="wp-link-pages top-50"><span>Pages: </span>',
        'after' => '</p>',
    ]) @endphp
    @if(has_tag()) <div class="tags-holder">@php the_tags('', '') @endphp</div> @endif
  </div>
  <div class="clear"></div>
</div>
