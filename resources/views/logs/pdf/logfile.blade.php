<html>
    <head>
        <title>{{trans_choice('jrl.logs',1) }}</title>
    </head>
    <body>
        <article>
            <section>
                <h1>{{ucfirst(trans_choice('jrl.logs', 1)) }} {{ $user->name }}</h1>
                <h2>Periode {{ date('d-m-Y', strtotime($log->start_date))}} tot {{ date('d-m-Y', strtotime($log->end_date))}}</h2>
                {!! $log->description !!}
                <hr/>
            </section>
            @if ($routes->count())
            <section>
                <h2>{{ucfirst(trans_choice('jrl.routes', 2))}}</h2>
                @foreach( $routes as $route) 
                <h3><a name='route-{{$route->id}}'/>{{$route->name}}</h3>
                <dl>
                    <dt>{{ucfirst(trans('jrl.distance'))}}:</dt>
                    <dd>{{$route->distance}}  {{ trans('jrl.kilometers') }}</dd>
                    <dt>{{ ucfirst(trans('jrl.grade')) }}:</dt>
                    <dd>{{ $route->rating}} / 5</dd>
                    <dt>{{ ucfirst(trans('jrl.description')) }}:</dt>
                    <dd>{!! $route->description !!}</dd>
                </dl>
                @endforeach
                <hr/>
            </section>
            @endif
            @if ($workouts->count())
            <section><h2>{{ucfirst(trans_choice('jrl.logs', 1))}}</h2></section>
            @foreach( $workouts as $workout)
            <h3>{{ date('d-m-y', strtotime($workout->date))}} - {{ $workout->name }}</h3>
            @unless (empty($workout->route_id))
            <a href="#route-{{$workout->route_id}}">{{$workout->route->name}}</a>
            @endunless
            {!! $workout->description !!}

            @if ($workout->workouts_fitness_services->fitness_service_remote_identifier)
            <a href="https://strava.com/activities/{{$workout->workouts_fitness_services->fitness_service_remote_identifier}}">Strava</a>
            @endif
            @endforeach
            @endif
        </article>
    </body>
</html>