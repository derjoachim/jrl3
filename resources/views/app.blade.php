<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Joachims Running Log - Third Movement</title>

        <link href="{{ asset('/css/material.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/jrl.css') }}">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('/js/material.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/all.js') }}"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&lang=en" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
                <div class="mdl-layout-icon"></div>
                <div class="mdl-layout__header-row">
                    <!-- Title -->
                    <span class="mdl-layout-title">JRL3 - Third movement</span>
                    <!-- Add spacer, to align navigation to the right -->
                    <div class="mdl-layout-spacer"></div>
                    <!-- Navigation. We hide it in small screens. -->
                    <nav class="mdl-navigation mdl-layout--large-screen-only">
                        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored" id="hdrbtn">
                            <i class="material-icons">add</i>
                        </button>
                        <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
                            <li class="mdl-menu__item"><a href="{{ url('/routes/create') }}">
                                    {{ ucfirst(trans('app.new')) }} {{ trans_choice('jrl.routes',1) }}</a></li>
                            <li class="mdl-menu__item"><a href="{{ url('/workouts/create') }}">
                                    {{ ucfirst(trans('app.new')) }} {{ trans_choice('jrl.workouts',1) }}</li>
                            <li class="mdl-menu__item"><a href="{{ url('upload') }}">
                                    {{ ucfirst(trans('app.upload')) }} {{ trans_choice('jrl.workout_files',1)}}</a></li>
                            <li class="mdl-menu__item"><a href="{{ url('/strava/getlatest') }}">
                                    {{ ucfirst(trans('app.import_from')) }} Strava</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
                <header class="demo-drawer-header nomdl-layout__header ">
                    <img class="demo-avatar" style="background-color:teal;"/>
                    <div class="demo-avatar-dropdown">
                        @if (!Auth::guest())
                        <span>{{ ucfirst(Auth::user()->name) }}</span>
                        @else
                        <span>{{ ucfirst(trans('app.login')) }}</span>
                        @endif
                    <div class="mdl-layout-spacer"></div>
                    <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons" role="presentation">arrow_drop_down</i>
                        <span class="visuallyhidden">Accounts</span>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                        @if (Auth::guest())
                        <li class="mdl-menu__item" tabindex="-1"  style="transition-delay: 0.012s;">
                            <a href="{{ url('/auth/login') }}">{{ ucfirst(trans('app.login')) }}</a>
                        </li>
                        <li class="mdl-menu__item" tabindex="-1" style="transition-delay: 0.084s;">
                            <a href="{{ url('/auth/register') }}">{{ ucfirst(trans('app.register')) }}</a>
                        </li>
                        @else
                        <li class="mdl-menu__item" tabindex="-1" style="transition-delay: 0.012s;">
                            <i class="material-icons">account circle</i><a href="{{ url('/auth/logout') }}">{{ ucfirst(trans('app.logout')) }}</a>
                        </li>
                        @endif
                    </ul>
                </header>
                <nav class="demo-navigation mdl-navigation  mdl-color--blue-grey-800">
                    <a class="mdl-navigation__link" href="{{ url('/') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{ ucfirst(trans('app.home')) }}</a>
                    @if (!Auth::guest())
                    <a class="mdl-navigation__link" href="{{ url('/routes') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">map</i>{{ ucfirst(trans('app.show_all')) }} {{ trans_choice('jrl.routes',2) }}</a>
                    <a class="mdl-navigation__link" href="{{ url('/workouts') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">directions_run</i>{{ ucfirst(trans('app.show_all')) }} {{ trans_choice('jrl.workouts',2) }}</a>
                    <div class="mdl-layout-spacer"></div>
                    @endif
                </nav>
            </div>
            <main class="mdl-layout__content mdl-color--grey-100">
                <div class="page-content">
                    @if (Session::has('message'))
                    <div class="flash alert-info">
                        <p>{{ Session::get('message') }}</p>
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class='flash alert-danger'>
                        @foreach ( $errors->all() as $error )
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
        <script type="text/javascript" src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    </body>
</html>
