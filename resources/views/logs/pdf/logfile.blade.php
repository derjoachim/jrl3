<html>
    <head>
        <title>{{trans_choice('jrl.logs',1) }}</title>
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <article>
            <section>
                <h1>{{ucfirst(trans_choice('jrl.logs', 1)) }} {{ $user->name }}</h1>
                <h2>Periode {{ date('d-m-Y', strtotime($log->start_date))}} tot {{ date('d-m-Y', strtotime($log->end_date))}}</h2>
                {!! $log->description !!}
                <hr style="page-break-after: always"/>
            </section>
            @if ($routes->count())
            <section>
                <h2>{{ucfirst(trans_choice('jrl.routes', 2))}}</h2>
                @foreach( $routes as $route) 
                <h3><a name='route-{{$route->id}}'></a>{{$route->name}}</h3>
                <dl>
                    <dt>{{ucfirst(trans('jrl.distance'))}}:</dt>
                    <dd>{{$route->distance}}  {{ trans('jrl.kilometers') }}</dd>
                    <dt>{{ ucfirst(trans('jrl.grade')) }}:</dt>
                    <dd>{{ $route->rating}} / 5</dd>
                    <dt>{{ ucfirst(trans('jrl.description')) }}:</dt>
                    <dd>{!! $route->description !!}</dd>
                </dl>
                @endforeach
                <hr style="page-break-after: always"/>
            </section>
            @endif
            @if ($workouts->count())
            <section><h2>{{ucfirst(trans_choice('jrl.logs', 1))}}</h2></section>
            @foreach( $workouts as $workout)
            <h3>{{ date('d-m-y', strtotime($workout->date))}} - {{ $workout->name }}</h3>
            <table class="table table-condensed table-striped">
                <thead></thead>
                <tfoot></tfoot>
                <tbody>
                    <tr>
                        <th colspan="2">{{ ucfirst(trans('jrl.general_data')) }}</th>
                        <th colspan="2">{{ ucfirst(trans('jrl.weather')) }}</th>
                        <th colspan="2">{{ ucfirst(trans('jrl.vibe')) }}</th>
                    </tr>
                    <tr>
                        <td>{{ ucfirst(trans('app.date')) }}:</td>
                        <td>{{ $workout->date->format('d-m-Y') }}</td>
                        <td>{{ ucfirst(trans('jrl.temperature')) }}:</td>
                        <td>{{ $workout->temperature }}</td>
                        <td>{{ ucfirst(trans('jrl.finished')) }}:</td>
                        <td>@if ($workout->finished == 1)
                            {{ ucfirst(trans('app.yes')) }}
                            @else
                            {{ ucfirst(trans('app.no')) }}
                            @endif</td>
                    </tr>
                    <tr>
                        <td>{{ ucfirst(trans('app.time')) }}:</td>
                        <td>{{ $workout->start_time }}</td>
                        <td>{{ ucfirst(trans('jrl.humidity')) }}:</td>
                        <td>{{ $workout->humidity }}</td>
                        <td>{{ ucfirst(trans('jrl.mood')) }}:</td>
                        <td>{{ $workout->mood }}</td>
                    </tr>
                    <tr>
                        <td>{{ ucfirst(trans_choice('jrl.routes',2)) }}:</td>
                        <td>@if (empty($workout->route_id))
                            {{ ucfirst(trans('app.none')) }}
                            @else
                            <a href="#route-{{$workout->route_id}}">{{$workout->route->name}}</a>
                            @endif
                        </td>
                        <td>{{ ucfirst(trans('jrl.wind_speed')) }}:</td>
                        <td>{{ $workout->wind_speed }}</td>
                        <td>{{ ucfirst(trans('jrl.health')) }}:</td>
                        <td>{{ $workout->health }}</td>
                    </tr>
                    <tr>
                        <td>{{ ucfirst(trans('jrl.finish_time')) }}:</td>
                        <td>{{ $workout->getTime() }}</td>
                        <td>{{ ucfirst(trans('jrl.wind_direction')) }}:</td>
                        <td>{{ $workout->wind_direction }}</td>
                        <td>{{ ucfirst(trans('jrl.avg_hr')) }}:</td>
                        <td>{{ $workout->avg_hr }}</td>
                    </tr>
                    <tr>
                        <td>{{ ucfirst(trans('jrl.distance')) }}:</td>
                        <td>{{ $workout->distance }}</td>
                        <td>{{ ucfirst(trans('jrl.pressure')) }}:</td>
                        <td>{{ $workout->pressure }}</td>
                        <td>{{ ucfirst(trans('jrl.max_hr')) }}:</td>
                        <td>{{ $workout->max_hr }}</td>
                    </tr>
                </tbody>
            </table>
            <div style="page-break-after: avoid">
                <strong>{{ ucfirst(trans('jrl.description')) }}</strong>
            </div>
            <div style="page-break-inside: avoid">
                {!! $workout->description !!}
            </div>

            @if ($workout->workouts_fitness_services && $workout->workouts_fitness_services->fitness_service_remote_identifier)
            <a href="https://strava.com/activities/{{$workout->workouts_fitness_services->fitness_service_remote_identifier}}">Strava</a>
            @endif
            @endforeach
            @endif
        </article>
    </body>
</html>