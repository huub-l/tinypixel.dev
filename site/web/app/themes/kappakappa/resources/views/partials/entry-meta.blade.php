<div class="post-info-wrapper">
  <div class="entry-info">
    {{-- Author --}}
    <div>
      <div class="text-holder">{{ __('AUTHOR', 'sage') }}</div>
      <div class="author-nickname">
        <p class="byline author vcard">
          {{ __('By', 'sage') }}
          <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">
            {{ get_the_author() }}
          </a>
        </p>
      </div>
    </div>

    {{-- Date --}}
    <div>
      <div class="text-holder">{{ __('DATE', 'sage') }}</div>
      <div class="entry-date published">
        <time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
      </div>
    </div>

    {{-- Category --}}
    <div>
      <div class="text-holder">{{ __('CATEGORY', 'sage') }}</div>
      <div class="cat-links">
        <ul>
            @foreach(get_the_category() as $category)
              <li><a href="{!! get_category_link($category->term_id) !!}">{!! $category->name !!}</a></li>
            @endforeach
        </ul>
      </div>
    </div>

    {{-- Comments --}}
    <div>
      <div class="text-holder">{{ __('COMMENTS', 'sage') }}</div>
      <div class="num-comments">
        <a href="@php comments_link() @endphp">
          @php comments_number('No Comments', '1 Comment', '% Comments') @endphp
        </a>
      </div>
    </div>
  </div>
</div>