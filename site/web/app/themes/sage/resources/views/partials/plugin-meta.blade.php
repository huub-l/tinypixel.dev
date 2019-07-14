<div class="post-info-wrapper">
  <div class="entry-info">

    @isset($plugin)
      <div class="plugin-meta">
        <div class="meta-label">{{ __('WordPress Plugin', 'sage') }}</div>
        <div class="plugin-name">
          <span>{!! $plugin->name !!}</span>
        </div>
        <div>
          <span class="plugin-description">{!! $plugin->description !!}</span>
        </div>
        <div>
          <span>
            <a class="plugin-download" href="{!! $plugin->downloadUrl !!}" title="Download {!! $plugin->name !!}">
              Download Plugin
            </a>
          </span>
        </div>
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
              <span class="field-value"><a href="{!! $plugin->sourceCode !!}">Github</a></span>
            </div>
          @endif
          @if($plugin->requirements)
            <div class="field plugin-requirements">
              <span class="field-label">Requires:</span>
              @foreach($plugin->requirements as $requirement)
                <span class="fieldset">
                  <span class="field-label">{!! $requirement['technology'] !!}</span>
                  <span class="field-value">{!! $requirement['version'] !!}</span>
                </span>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    @endisset

  </div>
</div>
