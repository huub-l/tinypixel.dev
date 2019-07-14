<div class="single-post-header-content content-960 center-relative">
  <div class="label">Tiny Pixel OSS</div>
  <h1 class="entry-title"><span class="inline-icon"">@svg('fa/solid/plug')</span> @php the_title() @endphp</h1>
  <span class="plugin-description has-medium-font-size">{!! $plugin->description ?? '' !!}</span>
</div>

@if(has_post_thumbnail())
  <div class="single-post-featured-image">
    @php the_post_thumbnail() @endphp
  </div>
@endif
