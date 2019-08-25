<div class="single-content-wrapper content-960 center-relative">
  @include('partials.plugin-meta')
  <div class="entry-content">

   {!! $readme !!}

    @if(has_tag())
      <div class="tags-holder">
        @php the_tags('', '') @endphp
      </div>
    @endif

  </div>
  <div class="clear"></div>
</div>
