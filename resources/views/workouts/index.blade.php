<!-- /resources/views/workouts/index.blade.php -->
@extends('app')

@section('content')
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--12-col">
        <h2>{{ ucfirst(trans_choice('jrl.workouts',2)) }}</h2>
    </div>

@if( !$workouts->count() ) 
        <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
            <div class="alert alert-info">{!! trans('jrl.no_workouts_defined', [ 'url' => URL::route('workouts.create') ] ) !!}</div>
        </div>
@else
    @foreach( $workouts as $workout )
    <div class="demo-cards mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-grid mdl-grid--no-spacing">
        <div class="mdl-card mdl-shadow--8dp">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300" style="height: 180px;">
                <h2 class="mdl-card__title-text">{{ $workout->name }}</h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <h3 class="mdl-card__subtitle-text">{{ $workout->route }}</h3>

                {{ date('d-m-Y', strtotime($workout->date)) }} - {{ $workout->distance }} km - {{ $workout->time }}
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="{{ route('workouts.show', $workout->slug)}}" class="mdl-button mdl-js-button mdl-js-ripple-effect">
                    {{ trans('app.readmore') }}
                </a>
            </div>
        </div>
    </div>

    @endforeach
</div>
{!! $workouts->render() !!}
@endif

@endsection