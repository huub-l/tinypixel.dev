(function ($) {

    "use strict";
    var count = 1;
    var currentPositionPosts = $(window).scrollTop();
    fixPullquoteClass();

    $(window).on('scroll', function () {
        var scrollPosts = $(window).scrollTop();
        if (scrollPosts > currentPositionPosts) { //Load only on scroll down
            loadMorePostsItemsOnScroll();
        }
        currentPositionPosts = scrollPosts;
    });

//Fix for Default menu
    $(".default-menu ul:first").addClass('sm sm-clean main-menu');

//Set menu
    $('.main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8,
        markCurrentTree: true
    });

    var $mainMenu = $('.main-menu').on('click', 'span.sub-arrow', function (e) {
        var obj = $mainMenu.data('smartmenus');
        if (obj.isCollapsible()) {
            var $item = $(this).parent(),
                    $sub = $item.parent().dataSM('sub');
            $sub.dataSM('arrowClicked', true);
        }
    }).bind({
        'beforeshow.smapi': function (e, menu) {
            var obj = $mainMenu.data('smartmenus');
            if (obj.isCollapsible()) {
                var $menu = $(menu);
                if (!$menu.dataSM('arrowClicked')) {
                    return false;
                }
                $menu.removeDataSM('arrowClicked');
            }
        }
    });

    loadMoreArticleIndex();

//Fix for No-Commnets
    $("#comments").each(function () {
        if ($.trim($(this).html()) === '')
        {
            $(this).remove();
        }
    });

    $('.single-post .num-comments a, .single-portfolio .num-comments a').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: $(this.hash).offset().top}, 2000);
        return false;
    });

//Blog show feature image
    showFirstBlogPostFeatureImge();
    showBlogPostFeatureImge();

//Placeholder show/hide
    $('input, textarea').on("focus", function () {
        $(this).data('placeholder', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    });
    $('input, textarea').on("blur", function () {
        $(this).attr('placeholder', $(this).data('placeholder'));
    });

//Fit Video
    $(".site-wrapper").fitVids();

//Show-Hide header sidebar
    $('#toggle').on('click', multiClickFunctionStop);

    $(window).on('load', function () {
        // Animate the elemnt if is allready visible on load
        animateElement();

        //Fix for hash
        var hash = location.hash;
        if ((hash !== '') && ($(hash).length))
        {
            $('html, body').animate({scrollTop: $(hash).offset().top - 77}, 1);
        }

        $('.doc-loader').fadeOut(300);


    });

    $(window).on('scroll', function () {
        animateElement();
    });




//------------------------------------------------------------------------
//Helper Methods -->
//------------------------------------------------------------------------


    function animateElement(e) {
        $(".animate").each(function (i) {
            var top_of_object = $(this).offset().top;
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            if ((bottom_of_window - 70) > top_of_object) {
                $(this).addClass('show-it');
            }
        });
    }


    function multiClickFunctionStop(e) {
        $('#toggle').off("click");
        $('#toggle, .toggle-holder, body').toggleClass("on");
        if ($('#toggle').hasClass("on"))
        {
            $('.menu-holder').addClass('show');
            $('#toggle').on("click", multiClickFunctionStop);
        } else
        {
            $('.menu-holder').removeClass('show');
            $('#toggle').on("click", multiClickFunctionStop);
        }
    }

    function loadMoreArticleIndex() {
        if (parseInt(ajax_var.posts_per_page_index) < parseInt(ajax_var.total_index)) {
            $('.more-posts').css('visibility', 'visible');
            $('.more-posts').animate({opacity: 1}, 1500);
        } else {
            $('.more-posts').css('display', 'none');
        }

        $('.more-posts:visible').on('click', function () {
            $('.more-posts').css('display', 'none');
            $('.more-posts-loading').css('display', 'inline-block');
            count++;
            loadArticleIndex(count);
        });
    }

    function loadArticleIndex(pageNumber) {
        $.ajax({
            url: ajax_var.url,
            type: 'POST',
            data: "action=infinite_scroll_index&page_no_index=" + pageNumber + '&loop_file_index=loop-index&security=' + ajax_var.nonce,
            success: function (html) {
                $('.blog-holder').imagesLoaded(function () {
                    $(".blog-holder").append(html);
                    setTimeout(function () {
                        animateElement();
                        showBlogPostFeatureImge();
                        if (count == ajax_var.num_pages_index)
                        {
                            $('.more-posts').css('display', 'none');
                            $('.more-posts-loading').css('display', 'none');
                            $('.no-more-posts').css('display', 'inline-block');
                        } else
                        {
                            $('.more-posts').css('display', 'inline-block');
                            $('.more-posts-loading').css('display', 'none');
                            $(".more-posts-index-holder").removeClass('stop-loading');
                        }
                    }, 100);
                });
            }
        });
        return false;
    }

    function loadMorePostsItemsOnScroll(e) {
        $(".more-posts-index-holder.scroll").not('.stop-loading').each(function (i) {
            var top_of_object = $(this).offset().top;
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            if ((bottom_of_window - 170) > top_of_object) {
                $(this).addClass('stop-loading');
                count++;
                loadArticleIndex(count);
                if (count <= ajax_var.num_pages_index)
                {
                    $('.more-posts-loading').css('display', 'inline-block');
                }
            }
        });
    }

    function showFirstBlogPostFeatureImge() {
        $(".blog-item-holder .entry-holder").first().addClass('active-post');
    }

    function showBlogPostFeatureImge() {
        $(".blog-item-holder .entry-holder").on('hover', function () {
            $(".blog-item-holder .entry-holder").removeClass('active-post');
            $(this).addClass('active-post');
        });
    }

    function fixPullquoteClass() {
        $("figure.wp-block-pullquote").find('blockquote').first().addClass('cocobasic-block-pullquote');
    }

    function is_touch_device() {
        return !!('ontouchstart' in window);
    }

})(jQuery);