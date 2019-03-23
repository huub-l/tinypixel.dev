<div class="article-list-item" style="background-image:url('{!! get_the_post_thumbnail_url() !!}');">
<div class="has-overlay w-full py-8">
  <div class="block max-w-lg w-full mx-auto py-16">
    <h2 class="py-0 my-0"><a href="{!! get_the_permalink() !!}">{{ get_the_title() }}</a></h2>
    <blockquote>
      <p class="text-white text-left">
        {!! strip_tags(the_excerpt()) !!}
      </p>
    </blockquote>
    <p class="button md:text-left mt-8"><a class="mx-0 text-white border-white border rounded 
                      text-sm text-center no-underline px-4 py-2 font-sans uppercase
                      hover:border-white hover:bg-white hover:text-indigo" href="{!! get_the_permalink() !!}">
                      Let's get started
            </a></p>
  </div>
</div>
</div>
