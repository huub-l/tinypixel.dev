<div class="plugin-archive content-960 center-relative">
  <div class="label">Tiny Pixel OSS</div>
  <h1>Packages</h1>
  <span class="plugin-description has-medium-font-size">{!! $plugin->description ?? '' !!}</span>
</div>

@if (get_option('cocobasic_title_image') !== '' && get_option('cocobasic_title_image') !== false)
  <img class="title-logo center-relative block" src="{!! get_option('cocobasic_title_image') !!}" alt="{!! get_the_title_attribute() !!}" />
@endif
