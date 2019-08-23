@if($plugin->requirements)
  <div class="field plugin-requirements">
    <span class="field-label">{{ __('Requires', 'sage') }}:</span>

    @foreach($plugin->requirements as $requirement)
      <span class="fieldset">

        @if($requirement['technology'])
          <span class="field-label">
            @if(strtolower($requirement['technology'])=='wordpress')
              <i class="tech-icon" width="16px">@svg('fa/brands/wordpress-simple')</i>
            @elseif(strtolower($requirement['technology'])=='php')
              <i class="tech-icon" width="16px">@svg('fa/brands/php')</i>
            @endif
            <span>{!! $requirement['technology'] !!}</span>
          </span>
        @endif

        @if($requirement['version'])
          <span class="field-value">
            {!! $requirement['version'] !!}
          </span>
        @endif
      </span>
    @endforeach

  </div>
 @endif
