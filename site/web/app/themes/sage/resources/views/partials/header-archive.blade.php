<div class="plugin-archive content-960 center-relative">
  <h1 style="margin-top: 2rem; margin-bottom: 2rem;">{!! $title !!}</h1>
</div>

@if (get_option('cocobasic_title_image') !== '' && get_option('cocobasic_title_image') !== false)
  <img class="title-logo center-relative block" src="{!! get_option('cocobasic_title_image') !!}" alt="{!! get_the_title_attribute() !!}" />
@endif
