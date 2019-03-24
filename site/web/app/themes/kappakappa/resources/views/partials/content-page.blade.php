
@php the_content() @endphp
@php wp_link_pages([
    'before' => '<p class="wp-link-pages top-50"><span>'. esc_html__('Pages:', 'kapena-wp') . '</span>',
    'after' => '</p>'
  ])
@endphp