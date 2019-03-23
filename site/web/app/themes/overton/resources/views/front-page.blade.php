@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <header class="max-w-full overflow-hidden bg-indigo">
      <div class="flex flex-grow sm:flex-row-reverse flex-wrap max-w-lg w-full 
                   pt-0 pb-6 px-4 items-center mx-auto">
        <div class="w-full md:w-1/2 mx-auto py-0 md:py-12">
          <div class="mx-auto w-full relative md:static opacity-75">
            @svg('feature-board')
          </div>
        </div>
        <div class="w-full max-w-lg md:w-1/2 mx-auto bg-left-bottom bg-no-repeat bg-contain text-white mb-12 md:mb-0 items-center md:items-start" style="background:url('@asset('svg/squares.svg')');">
            <h1 class="md:max-w-sm w-full mb-4 pt-4 text-2xl md:text-2xl lg:text-3xl text-center md:text-left">{!! $site_description !!}</h1>
            <p class="md:max-w-md  mb-8 text-center md:text-left">Tiny Pixel partners with progressive non-profits to create meaningful digital experiences that 
              inspire change.</p>
            <p class="md:text-left mx-auto self-center items-center text-center block"><a class="mx-auto text-white border-white border rounded 
                      text-sm text-center no-underline px-4 py-2 font-sans uppercase
                      hover:border-white hover:bg-white hover:text-indigo hover:rounded" href="/get-started">
                      Let's get started
            </a></p>
        </div>
      </div>
    </header>
    <div class="wave-container">
      <div class="wave"></div>
    </div>
    <header class="max-w-2xl flex flex-grow flex-wrap w-full overflow-hidden 
                   pt-0 pb-20 px-12 mx-auto items-center">
      <div class="max-w-md w-full md:w-3/5 mx-auto pb-10 pt-10 md:pt-20 md:pr-20">
        <div class="mx-auto w-screen-120 md:w-full relative md:static" style="opacity: 0.9; right: 20%;">
          @svg('wireframe-caty')
        </div>
      </div>
      <div class="w-full md:w-2/5 pb-10 pt-10 md:pt-20 mx-auto">
        <h2 class="w-full mb-4">We Build for Tomorrow</h2>
        <h3 class="w-full mb-4 font-normal font-mono">Our partners' projects never stop evolving, because our team never stops learning.</h3>
      </div>
    </header>
    <div class="skew skew-top"></div>
    <header class="bg-blue-lightest">
      <div class="max-w-2xl flex flex-grow md:flex-row-reverse flex-wrap w-full overflow-hidden 
                   pt-0 pb-20 px-12 mx-auto items-center">
        <div class="w-full md:w-3/5 mx-auto pb-10">
          <div class="w-full mx-auto w-screen-140 relative md:static md:w-full opacity-100" style="right:40%">
            @svg('web-frame-caty')
          </div>
        </div>
        <div class="w-full max-w-lg md:w-2/5 pt-10 pb-20 mx-auto">
          <h2 class="w-full mb-2">Partners, Not Clients</h2>
          <h3 class="w-full mb-4 font-normal font-mono">When we take on a project, we're friends for life. That means tutorials, 24/7 support, and cake on your birthday.</h3>
        </div>
      </div>
    </header>
    <div class="skew skew-btm"></div>
    <header class="bg-white">
      <div class="max-w-2xl flex flex-grow md:flex-row-reverse flex-wrap w-full overflow-hidden 
                   md:pt-10 pb-20 px-12 md:pr-12 mx-auto items-center">
        <div class="w-full max-w-lg md:w-2/5 md:pl-12 pb-10 pt-10 mx-auto">
          <h2 class="w-full mb-2">Accessibility matters</h2>
          <h3 class="w-full mb-4 font-normal font-mono">We believe the web should work for <em>everyone</em> &mdash; not just those who move, see, or think
          in specific ways.</h3>
        </div>
        <div class="w-full md:w-3/5 mx-auto pt-10 pb-10">
          <div class="w-full mx-auto w-screen-140 relative md:static md:w-full opacity-100 md:mr-20 md:position-r-20" style="right:40%">
            @svg('accessible')
          </div>
        </div>
      </div>
    </header>
  @endwhile
@endsection
