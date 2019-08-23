<div class="post-info-wrapper">
  <div class="entry-info">
    @isset($plugin)

      <div class="plugin-meta">
        <span class="meta-label">
          {!! __('WordPress Plugin', 'sage') !!}
        </span>

        @if($plugin->name)
          <div class="plugin-name">
            <span>
              {!! $plugin->name !!}
            </span>
          </div>
        @endif

        @if($git['description'])
          <div>
            <span class="plugin-description">
              {!! $git['description'] !!}
            </span>
          </div>
        @endif

        <div>
          <span><a class="plugin-download" href="{!! $git['html_url'] !!}" title="Download {!! $plugin->name !!}">
            <i class="white">@svg('fa/solid/download')</i>
            {{ __('Download Plugin', 'sage') }}
          </a></span>
        </div>

        <div class="fields">
          @if($git['stargazers_count'] > 10)
            <div class="field plugin-license">
              <span class="field-label">
                {{ __('🤩 Stars', 'sage') }}:
              </span>
              <span class="field-value">
                {!! $git['stargazers_count'] !!} stargazers
              </span>
            </div>
          @endif

          @isset($git['license']['name'])
            <div class="field plugin-license">
              <span class="field-label">
                {{ __('📚 License', 'sage') }}:
              </span>
              <span class="field-value">
                {!! $git['license']['name'] !!}
              </span>
            </div>
          @endisset

          <div class="field plugin-source">
            <span class="field-label">
              {{ __('💻 Source', 'sage') }}:
            </span>
            <span class="field-value">
              <a href="{!! $git['url'] !!}">
                {!! __('Github', 'sage') !!}
              </a>
            </span>
          </div>

          <div class="pt">
            @include('components.plugin.requirements')
          </div>
        </div>
      </div>

    @endisset
  </div>
</div>
