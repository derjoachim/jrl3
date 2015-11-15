<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Joachims Running Log - Third Movement</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <script type="text/javascript" src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="{{ elixir('js/all.js') }}"></script>
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    <nav class="navbar navbar-default">
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
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">{{ ucfirst(trans('app.home')) }}</a></li>
                    @if (!Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ ucfirst(trans_choice('jrl.standard_routes',2)) }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/routes') }}">
                                        {{ ucfirst(trans('app.show_all')) }} {{ trans_choice('jrl.routes',2) }}
                                    </a></li>
                                <li><a href="{{ url('/routes/create') }}">{{ ucfirst(trans('app.new')) }} {{ trans_choice('jrl.routes',1) }}</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ ucfirst(trans_choice('jrl.workouts',2)) }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
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
                        </li>
                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/auth/login') }}">{{ ucfirst(trans('app.login')) }}</a></li>
                        <li><a href="{{ url('/auth/register') }}">{{ ucfirst(trans('app.register')) }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/auth/logout') }}">{{ trans('app.logout') }}</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
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
        <!-- Scripts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </body>
</html>
