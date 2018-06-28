<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <nav class="navbar has-shadow is-white is-border-top">
            <div class="container">
                <div class="navbar-brand">
                    @if(Auth::check())
                        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navMenubd-drawer">
                            <span aria-hidden="true"></span>
                            <span aria-hidden="true"></span>
                            <span aria-hidden="true"></span>
                        </a>
                    @endif
                    <a class="navbar-item" href="{{ url('/dashboard') }}">
                        <span class="logo">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <div id="navbarMenu" class="navbar-menu">
                    <div class="navbar-end">
                        @guest
                            <div class="navbar-item">
                                <div class="field is-grouped">
                                    <p class="control">
                                        <a class="button is-primary is-outlined" href="{{ route('login') }}">{{ __('common.login') }}</a>
                                    </p>
                                    <p class="control">
                                        <a class="button is-primary" href="{{ route('register') }}">{{ __('common.register') }}</a>
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="navbar-item has-dropdown is-hoverable">
                                <a class="navbar-link" href="#">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="navbar-dropdown is-boxed is-right">
                                    <a class="navbar-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('common.logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <div class="columns is-fullheight is-gapless">
            @if(!Request::is('login') && !Request::is('register') && Auth::check())
                <div  id="navMenubd-drawer" class="column is-sidebar-menu is-hidden-mobile">
                    <p class="menu-title">
                        {{ Auth::user()->selectedOrganization()->name }}
                    </p>
                    <aside class="menu">
                        <ul class="menu-list">
                            <li class="{{ Request::is('dashboard') ? 'is-active' : '' }}">
                                <a href="{{ route('dashboard') }}">{{ __('common.dashboard') }}</a>
                            </li>
                            <li class="{{ Request::is('client*') ? 'is-active' : '' }}">
                                <a href="{{ route('client.index') }}">{{ __('db.models.client') }}{{ __('common.admin') }}</a>
                            </li>
                            <li class="{{ Request::is('source*') ? 'is-active' : '' }}">
                                <a href="{{ route('source.index') }}">{{ __('db.models.source') }}{{ __('common.admin') }}</a>
                            </li>
                            <li class="{{ Request::is('invoice*') ? 'is-active' : '' }}">
                                <a href="{{ route('invoice.index') }}">{{ __('db.models.invoice') }}{{ __('common.admin') }}</a>
                            </li>
                        </ul>
                        <p class="menu-label">
                            {{ __('common.admin') }}
                        </p>
                        <ul class="menu-list">
                            <li class="{{ Request::is('member*') ? 'is-active' : '' }}">
                                <a href="{{ route('member.index') }}">{{ __('db.models.member') }}{{ __('common.admin') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('common.logout') }}
                                </a>
                            </li>
                        </ul>

                    </aside>
                </div>
            @endif
            <div class="column">
                <div class="is-main-content {{ str_replace('.', '-', Route::currentRouteName()) }}">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
