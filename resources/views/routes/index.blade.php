<!-- /resources/views/routes/index.blade.php -->
@extends('app')

@section('content')
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--12-col">
        <h2>{{ ucfirst(trans_choice('jrl.standard_routes',2)) }}</h2>
    </div>
    <div class="mdl-cell mdl-cell--12-col">
        <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
            @if( !$routes->count() ) 
            <div class="alert alert-info">{!! trans('jrl.no_routes_defined', [ 'url' => URL::route('routes.create') ] ) !!}</div>
            @else
            <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp full-width">
              <thead>
                <tr>
                    <th></th>
                    <th class="mdl-data-table__cell--non-numeric full-width">{{ ucfirst(trans('jrl.name')) }}</th>
                    <th class="mdl-data-table__cell--non-numeric">{{ ucfirst(trans('jrl.distance')) }}</th>
                    <th>{{ ucfirst(trans('jrl.grade')) }}</th>
                    <th>{{ ucfirst(trans('app.delete')) }}</th>
                    <th>{{ ucfirst(trans('app.edit')) }}</th>
                </thead>
                <tfoot>
                    <th colspan='5'>&nbsp;</th>
                    <th><a href="{{ URL::route('routes.create')}}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--accent">
                            <i class="material-icons">add</i>
                        </a></th>
                </tfoot>
            <tbody>
            @foreach( $routes as $route )
                <tr>
                    <td/>
                    <td class="mdl-data-table__cell--non-numeric"><a href="{{ route('routes.show', $route->slug)}}">{{ $route->name }}</a></td>
                    <td noclass="mdl-data-table__cell--non-numeric">{{ $route->distance }} km</td>
                    <td>
                        @for ($i=1; $i<=5; $i++)
                        <i class="material-icons" style="font-size: 1em;">
                            @if ($i > $route->rating) 
                                star_border
                            @else
                                star
                            @endif
                        </i>                        
                        @endfor
                    </td>
                    <td>
                        {!! Form::open(array('method'=>'DELETE', 'route'=> array('routes.destroy', $route->slug))) !!}
                        <button class="mdl-button mdl-js-button mdl-button--icon" type="submit">
                            <i class="material-icons">remove</i>
                        </button>
                        {!! Form::close() !!}
                    </td>
                    <td>
                        <a href="{{ URL::route('routes.edit', array($route->slug))}}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
                            <i class="material-icons">edit</i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        </div>
    </div>
</div>
@endsection