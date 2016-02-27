<!-- /resources/views/routes/create.blade.php -->
@extends('app')

@section('content')
 <div class="mdl-layout__tab-panel is-active" id="overview">
    <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
        <header id="map_canvas" class="section__play-btn mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--teal-100 mdl-color-text--white">
            <i class="material-icons">map</i>
        </header>
        <div class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">
            <div class="mdl-card__supporting-text">
                <h2>{{ ucfirst(trans('app.create_new')) }} {{ trans_choice('jrl.routes',1) }}</h2>
            </div>
        </div>
    </section>
   
    {!! Form::model(new Jrl3\Route, ['route' => 'routes.store']) !!}
    @include('routes/partials/_form', ['submit_text' => ucfirst(trans('app.create')), 'rating' => 3])
    {!! Form::close() !!}
@endsection