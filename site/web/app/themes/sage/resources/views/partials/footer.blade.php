<footer class="footer">
    <div class="footer-content center-relative">
        @if(is_active_sidebar('footer-sidebar'))
            <ul id="footer-sidebar" class="content-1170 center-relative">
                @php dynamic_sidebar('footer-sidebar') @endphp
            </ul>
        @endif

        @isset($footer->image)
          @svg('logo-circle')
        @endisset

        @isset($footer->copyright)
        <div class="copyright-holder content-1170 center-relative">
            {!! $footer->copyright !!}
        </div>
        @endisset

        @isset($data->footer->social)
        <div class="social-holder content-1170 center-relative">
            {!! $footer->social !!}
        </div>
        @endisset
    </div>
</footer>
