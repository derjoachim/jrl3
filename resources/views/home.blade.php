@extends('app')

@section('content')
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--10-col">
        <h2>{{ ucfirst(trans('app.home')) }}</h2>
    </div>
    <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--8-col">
        <h4>TODO</h4>
        <ul>
            <li>Latest N workouts</li>
            <li>Favourite standard routes</li>
            <li>PRs by favourite standard route</li>
        </ul>
    </div>
    <div class="demo-cards mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet mdl-grid mdl-grid--no-spacing">
        <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300" style="height: 180px;">
                <h2 class="mdl-card__title-text">To the in-laws</h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                13-11-2015 - 13,6 kilometer - 1:12:30
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Lees meer</a>
            </div>
        </div>
        <div class="demo-separator mdl-cell--1-col"></div>
    </div>
</div>
@endsection
