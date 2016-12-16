@extends('app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ ucfirst(trans('app.home')) }}</div>

        <div class="panel-body">
            {{ trans('jrl.welcome_to_jrl') }}
        </div>
    </div>
    <div><a href="https:/darksky.net/poweredby" target="_blank">
            <img src="{{ asset('/img/poweredby.png') }}" style="width:160px"/>
        </a></div>
@endsection
