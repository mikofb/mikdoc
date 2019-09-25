<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="{{ config('mikdoc.seo.author') }}">
  <meta name="description" content="{{ config('mikdoc.seo.description') }}">
  <meta name="keywords" content="{{ config('mikdoc.seo.keywords') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="_token" content="{{ csrf_token() }}">
  <title>@yield('title'){{' | '.config('app.name')}}</title>
  <!-- Favicon -->
  <link href="{{ asset(config('mikdoc.settings.appearance.favicon')) }}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- CSS-->
  @include('mikdoc::partials.stylesheets')
  <!--Customized CSS-->
  @yield('css') 
</head>
<body>
  <!-- Sidenav -->
  <div class="preload"></div>
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="{{route(config('mikdoc.routes.prefix').'.index')}}">
        <img src="{{ asset(config('mikdoc.settings.appearance.logo')) }}" class="navbar-brand-img" alt="Logo">
      </a>
      <!-- User -->
      @if (Route::has('login'))
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="User avatar" src="{{ asset(config('mikdoc.settings.appearance.avatar')) }}">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            @auth
            <a href="{{route('home')}}" class="dropdown-item">
              <i class="ni ni-tv-2"></i>
              <span>@lang('mikdoc::messages.dashboard')</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#!" class="dropdown-item" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="ni ni-user-run"></i>
              <span>@lang('mikdoc::messages.logout')</span>
            </a>
            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
            @else
            <a href="{{route('login')}}" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>@lang('mikdoc::messages.login')</span>
            </a>
            @endauth
          </div>          
        </li>
      </ul>
      @endif
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="{{url('/')}}">
                <img src="{{ asset(config('mikdoc.settings.appearance.favicon')) }}">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        @if (Route::has('login'))
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="#account" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="account">
              <i class="ni ni-single-02 text-warning"></i>
              <span class="nav-link-text">@lang('mikdoc::messages.account')</span>
            </a>
            <div class="collapse" id="account">
              <ul class="nav nav-sm flex-column">
                @auth
                <li class="nav-item">
                  <a class="nav-link" href="{{route('home')}}">
                    <i class="ni ni-tv-2 text-default"></i>
                    <span class="nav-link-text"> @lang('mikdoc::messages.dashboard')</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#!" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                    <i class="ni ni-user-run text-default"></i>
                    @lang('mikdoc::messages.logout')
                  </a>
                </li>
                @else
                <li class="nav-item">
                  <a class="nav-link" href="{{route('login')}}">
                    <i class="ni ni-user-run text-default"></i>
                    @lang('mikdoc::messages.login')
                  </a>
                </li>
                @endauth
              </ul>
            </div>
          </li>
        </ul>
        @endif
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href=@yield('page-route')>
          @yield('page-title')
        </a>
        <!-- User -->
        @if (Route::has('login'))
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="User avatar" src="{{ asset(config('mikdoc.settings.appearance.avatar'))."" }}">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name ?? trans('mikdoc::messages.username') }}</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              @auth
              <a href="{{route('home')}}" class="dropdown-item">
                <i class="ni ni-tv-2"></i>
                <span>@lang('mikdoc::messages.dashboard')</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#!" class="dropdown-item" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="ni ni-user-run"></i>
              <span>@lang('mikdoc::messages.logout')</span>
            </a>
            @else
              <a href="{{route('login')}}" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>@lang('mikdoc::messages.login')</span>
              </a>
            @endauth
            </div>
          </li>
        </ul>
        @endif
      </div>
    </nav>
    <!-- Header -->
    <div class="header bg-gradient-info pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          @yield('page-header')
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      @yield('page-content')        
      <!-- Footer -->
      @include('mikdoc::partials.footer')
    </div>
  </div>
  @yield('components')
  <a href="#" class="cd-top js-cd-top text-white"></a>
  <!-- Argon Scripts -->
  <!--Customized JS-->
  @yield('js')
  <!-- Core -->
  @include('mikdoc::partials.main_js')  
</body>
</html>