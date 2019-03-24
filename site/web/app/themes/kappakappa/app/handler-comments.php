<?php

namespace App;

/**
 * kappa_kappa_comment
 *
 * @param [type] $comment
 * @param [type] $args
 * @param [type] $depth
 * @return void
 */
function kappa_kappa_comment($comment, $args, $depth)
{
    ?> <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="single-comment-holder">

            <?php if ($comment->comment_approved == '0') : ?>
                <em><?php echo esc_html__('Your comment is awaiting moderation.', 'kapena-wp'); ?></em>
                <br /> <br />
            <?php endif;

            $get_comment_ID = get_comment_ID();
            $comment_id = get_comment($get_comment_ID);
            $parent_comment_id = $comment_id->comment_parent;
            if ($parent_comment_id != 0) :
                $get_parent_author_name = get_comment_author($parent_comment_id);
            endif; ?>

            <div class="float-left vcard">
                <?php if ($args['avatar_size'] != 0) :
                    echo get_avatar($comment, 70);
                endif; ?>
            </div>

            <div class="comment-right-holder">
                <ul class="comment-author-date-replay-holder">
                    <li class="comment-author">
                        <?php echo comment_author(); ?>
                    </li>
                </ul>
                <p class="comment-date">
                    <?php echo get_comment_date(''); ?>
                    <?php
                        comment_reply_link(
                            array_merge($args, [
                                    'add_below' => '',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth'],
                                    'before' => '- '
                            ])
                        );
                    ?>
                </p>

                <div class="comment-text">
                    <?php if ($parent_comment_id != 0) :
                        echo '<span class="replay-at-author">@' . esc_html($get_parent_author_name) . '</span>';
                    endif;

                    comment_text(); ?>
                </div>

            </div>
            <div class="clear"></div>
        </div>
<?php } ?>