<h1 class="entry-title block content-1170 center-relative">
  {!! $title !!}
</h1>
@if (get_option('cocobasic_title_image') !== '' && get_option('cocobasic_title_image') !== false)
  <img class="title-logo center-relative block" src="{!! get_option('cocobasic_title_image') !!}" alt="{!! get_the_title_attribute() !!}" />
@endif
