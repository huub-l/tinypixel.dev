<div class="nav-links">
  <div class="content-1170 center-relative">
    @if(is_a(get_previous_post(), 'WP_Post'))
      <div class="nav-previous">
        @php previous_post_link('%link') @endphp
        <div class="arrow-holder">&#8592;</div>
        <div class="clear"></div>
      </div>
    @endif

    @if(is_a(get_next_post(), 'WP_Post'))
      <div class="nav-next">
          <?php next_post_link('%link') ?>
          <div class="arrow-holder">&#8594;</div>
          <div class="clear"></div>
      </div>
    @endif

    <div class="clear"></div>
  </div>
</div>
