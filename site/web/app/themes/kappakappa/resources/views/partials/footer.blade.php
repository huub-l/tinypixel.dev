<footer class="footer">
  <div class="footer-content center-relative">

    @if(is_active_sidebar('footer-sidebar'))
      <ul id="footer-sidebar" class="content-1170 center-relative">
        @php dynamic_sidebar('footer-sidebar') @endphp
      </ul>
    @endif

    @isset($data->footer->image)
      <img class="footer-logo" src="{!! $data->footer->image !!}" alt="{!! $site_name !!}" />
    @endisset

    @isset($data->footer->copyright_content)
      <div class="copyright-holder content-1170 center-relative">
         {!! $data->footer->copyright_content !!}
      </div>
    @endisset

    @isset($data->footer->social_content)
      <div class="social-holder content-1170 center-relative">
        {!! $data->footer->social_content !!}
      </div>
    @endisset

  </div>
</footer>