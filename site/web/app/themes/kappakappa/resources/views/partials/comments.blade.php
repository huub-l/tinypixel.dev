@php
  if(post_password_required()) {
    return;
  }

 /**
  * kappa_kappa_comment
  *
  * @param mixed $comment
  * @param mixed $args
  * @param mixed $depth
  * @return void
  */
  function kappa_kappa_comment($comment, $args, $depth)
  {
    @endphp
    <li {!! comment_class() !!} id="li-comment-{!! comment_ID()  !!}">
      <div id="comment-{!! comment_ID() !!}" class="single-comment-holder">
        @if($comment->comment_approved == '0')
          <em>{!! __('Your comment is awaiting moderation.', 'sage') !!}</em>
          <br /><br />
        @endif

        @php
          $get_comment_ID = get_comment_ID();
          $comment_id = get_comment($get_comment_ID);
          $parent_comment_id = $comment_id->comment_parent;
          if ($parent_comment_id != 0) :
              $get_parent_author_name = get_comment_author($parent_comment_id);
          endif;
        @endphp

        <div class="float-left vcard">
          @if($args['avatar_size'] != 0)
            {!! get_avatar($comment, 70) !!}
          @endif
        </div>

        <div class="comment-right-holder">
            <ul class="comment-author-date-replay-holder">
                <li class="comment-author">
                    {!! comment_author() !!}
                </li>
            </ul>
            <p class="comment-date">
                {!! get_comment_date('') !!}
                @php comment_reply_link(array_merge($args, [
                                'add_below' => '',
                                'depth' => $depth,
                                'max_depth' => $args['max_depth'],
                                'before' => '- '
                ])) @endphp
            </p>

            <div class="comment-text">
                @if ($parent_comment_id != 0)
                  <span class="replay-at-author">@{!! esc_html($get_parent_author_name) !!}</span>
                @endif
                {!! comment_text() !!}
            </div>
        </div>
        <div class="clear"></div>
      </div>
@php } @endphp

<div id="comments" class="comments-holder">
  <div id="comments-wrapper">
    <div class="block center-relative content-570">
      <ol class="comments-list-holder">
        @php wp_list_comments([
          'max_depth' => 4,
          'avatar_size' => 48,
          'callback' => 'kappa_kappa_comment',
          'short_ping' => true])
        @endphp
      </ol>
      <div class="comments-pagination-wrapper top-20 bottom-20">
        <div class="comments-pagination">
          @php paginate_comments_links([
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;'])
          @endphp
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>

  @if(comments_open())
    <div class="comment-form-holder">
      <div class="block center-relative content-570">
        @if (!isset($aria_req)) @php $aria_req = '' @endphp @endif
        @php comment_form([
          'fields' => [
            'author' => '<input id="author" name="author" type="text" placeholder="'. __('NAME', 'kapena-wp') .'" value="'. esc_attr($commenter['comment_author']) .'" size="20"'. $aria_req .' />',
            'email' => '<input id="email" name="email" type="text" placeholder="'. __('EMAIL', 'kapena-wp') .'" value="'. esc_attr($commenter['comment_author_email']) .'" size="20"'. $aria_req .' />'
          ],
          'comment_field' => '<textarea id="comment" placeholder="'. __('COMMENT', 'sage') .'" name="comment" cols="45" rows="12" aria-required="true"></textarea>',
          'title_reply' => '',
          'comment_notes_before' => '',
          'comment_notes_after' => '',
          'label_submit' => __('PUBLISH COMMENT', 'sage')])
        @endphp
      </div>
    </div>
  @endif
  <div class="clear"></div>
</div>