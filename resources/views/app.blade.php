<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Joachim's Running Log">
    <meta name="author" content="Joachim van de Haterd">
	<title>Joachims Running Log - Third Movement</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&subset=latin-ext" rel="stylesheet">
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ elixir('js/all.js') }}"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Joachims Runnnig Log</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/auth/login') }}">{{ ucfirst(trans('app.login')) }}</a></li>
                        <li><a href="{{ url('/auth/register') }}">{{ ucfirst(trans('app.register')) }}</a></li>
                    @else
                    {!! Form::open(['method'=>'POST', 'url'=>'/logout', 'id' => 'logout_form']) !!}
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" title='{{trans('app.logout')}}' onclick="$('#logout_form').submit();">{{ trans('app.logout') }}</a></li>
                            </ul>
                        </li>
                        {!! Form::close() !!}
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="{{ url('/') }}">{{ ucfirst(trans('app.home')) }}</a></li>
                </ul>
                @if (!Auth::guest())
                <ul class="nav nav-sidebar" role="menu">
                    <li class="sidebar-title">{{ ucfirst(trans_choice('jrl.standard_routes',2)) }}</li>
                    <li><a href="{{ url('/routes') }}">{{ ucfirst(trans('app.show_all')) }} {{ trans_choice('jrl.routes',2) }}</a></li>
                    <li><a href="{{ url('/routes/create') }}">{{ ucfirst(trans('app.new')) }} {{ trans_choice('jrl.routes',1) }}</a></li>
                </ul>
                <div class="divider">&nbsp;</div>
                <ul class="nav nav-sidebar" role="menu">
                    <li class="sidebar-title">{{ ucfirst(trans_choice('jrl.workouts',2)) }}</li>
                    <li><a href="{{ url('/workouts') }}">
                        {{ ucfirst(trans('app.show_all')) }} {{ trans_choice('jrl.workouts',2) }}
                    </a></li>
                    <li><a href="{{ url('/workouts/create') }}">
                        {{ ucfirst(trans('app.new')) }} {{ trans_choice('jrl.workouts',1) }}
                    </a></li>
                    <li><a href="{{ url('upload') }}">
                        {{ ucfirst(trans('app.upload')) }} {{ trans_choice('jrl.workout_files',1)}}
                    </a></li>
                    <li><a href="{{ url('/strava/getlatest') }}">{{ ucfirst(trans('app.import_from')) }} Strava</a></li>
                </ul>
                <div class="divider">&nbsp;</div>
                <ul class="nav nav-sidebar" role="menu">
                    <li class="sidebar-title">{{ucfirst(trans_choice('jrl.logs',2)) }}</li>
                    <li><a href="{{url('logs')}}">{{ucfirst(trans_choice('jrl.logs',2)) }}</a></li>
                </ul>
                @endif
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
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
    </div>
    <footer>
        <nav class="navbar navbar-collapse">
            <div class="container-fluid">
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="https://strava.com/" target="_blank" class="navbar-link">
                                <img alt="Powered by Strava" src="{{ asset('/img/api_logo_pwrdBy_strava_stack_light.png') }}" style="height:40px"/>
                            </a>
                        </li>
                        <li>
                            <a class="navbar-link" href="https://darksky.net/poweredby" target="_blank">
                                <img src="{{ asset('/img/poweredby.png') }}" style="height:40px"/>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </footer>
    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>
