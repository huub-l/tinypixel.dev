@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <p class="center-text error-text-help-first"><strong>Oops!</strong></p>
    <p class="center-text error-text-help-second">The page you were looking for could not be found.</p>
    <p class="center-text error-text-404">404</p>
    <div class="center-text error-search-holder">{!! get_search_form(false) !!}</div>
    <p class="center-text error-text-home">... or return to <a href="{!! $site_url !!}">the front page</a>.</p>
    {!! get_search_form(false) !!}
  @endif
@endsection
