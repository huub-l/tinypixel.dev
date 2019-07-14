<div class="post-info-wrapper">
  <div class="entry-info">
    @isset($plugin)
      <div class="plugin-meta">
        <div class="meta-label">
          {{ __('WordPress Plugin', 'sage') }}
        </div>

        @if($plugin->name)
          <div class="plugin-name">
            <span>{!! $plugin->name !!}</span>
          </div>
        @endif

        @if($plugin->description)
        <div>
          <span class="plugin-description">
            {!! $plugin->description !!}
          </span>
        </div>
        @endif

        @if($plugin->downloadUrl)
        <div>
          <span>
            <a class="plugin-download" href="{!! $plugin->downloadUrl !!}" title="Download {!! $plugin->name !!}">
              {{ __('Download', 'sage') }} v{!! $plugin->downloadVersion !!}
            </a>
          </span>
        </div>
        @endif

        <div class="fields">
          @if($plugin->license)
            <div class="field plugin-license">
              <span class="field-label">{{ __('License', 'sage') }}:</span>
              <span class="field-value">{!! $plugin->license !!}</span>
            </div>
          @endif

          @if($plugin->sourceCode)
            <div class="field plugin-source">
              <span class="field-label">{{ __('Source', 'sage') }}:</span>
              <span class="field-value"><a href="{!! $plugin->sourceCode !!}">{{ __('Github', 'sage') }}</a></span>
            </div>
          @endif

          @if($plugin->requirements)
            <div class="field plugin-requirements">
              <span class="field-label">{{ __('Requires', 'sage') }}:</span>

              @foreach($plugin->requirements as $requirement)
                <span class="fieldset">
                  @if($requirement['technology'])
                    <span class="field-label">
                      {!! $requirement['technology'] !!}
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

        </div>
      </div>
    @endisset
  </div>
</div>
