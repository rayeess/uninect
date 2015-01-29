<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]> <html class="no-js">
<![endif]-->
<head>
      <meta charset="utf-8" />
      <title>{{isset($title)?$title.' | ':''}} LARAVEL Q & A</title>
      {{ HTML::style('assets/css/style.css') }}
</head>
<body>
      {{-- We include the top menu view here --}}
      @include('template.topmenu')

      <div class="centerfix" id="header">
            <div class="centercontent">
                  <a href="{{URL::route('index')}}">{{HTML::image('assets/img/header/logo.png')}}</a>
            </div>
      </div>
      <div class="centerfix" id="main" role="main">
            <div class="centercontent clearfix">
                  <div id="contentblock">
                        {{-- Showing the Error and Success Messages--}}
                        @if(Session::has('error'))
                        <div class="warningx wredy">
                              {{Session::get('error')}}
                        </div>
                        @endif
                        @if(Session::has('success'))
                        <div class="warningx wgreeny">
                              {{Session::get('success')}}
                        </div>
                        @endif
                        {{-- Content section of the template --}}
                        @yield('content')
                  </div>
            </div>
      </div>
      {{-- JavaScript Files --}}
      {{ HTML::script('assets/js/libs.js') }}
      {{ HTML::script('assets/js/plugins.js') }}
      {{ HTML::script('assets/js/script.js') }}

      {{-- Each page's custom assets (if available) will be yielded here --}}
      @yield('footer_assets')
</body>
</html>
