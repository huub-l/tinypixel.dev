@if (get_post_meta($post->ID, "page_show_title", true) != 'no')
  <h1 class="entry-title page-title block content-1170 center-relative">
    @if(get_post_meta($post->ID, "page_custom_title", true) != '')
      @php do_shortcode(get_post_meta($post->ID, "page_custom_title", true)) @endphp
    @else
      {!! get_the_title() !!}
    @endif
  </h1>
  @if (get_option('cocobasic_title_image') !== '' && get_option('cocobasic_title_image') !== false)
    <img class="title-logo center-relative block" src="{!! get_option('cocobasic_title_image') !!}" alt="{!! get_the_title_attribute() !!}" />
  @endif
@endif
