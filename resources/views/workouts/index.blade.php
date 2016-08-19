<!-- /resources/views/workouts/index.blade.php -->
@extends('app')

@section('content')
<h2>{{ ucfirst(trans_choice('jrl.workouts',2)) }}</h2>
@if( !$workouts->count() ) 
<div class="alert alert-info">{!! trans('jrl.no_workouts_defined', [ 'url' => URL::route('workouts.create') ] ) !!}</div>
@else
<!--<div class="row-fluid">-->
    <table class="table table-condensed table-striped">
        <thead>
            <th>{{ ucfirst(trans('app.date')) }}</th>
            <th>{{ ucfirst(trans('jrl.name')) }}</th>
            <th>{{ ucfirst(trans_choice('jrl.routes',2)) }}</th>
            <th>{{ ucfirst(trans('jrl.distance')) }}</th>
            <th>{{ ucfirst(trans('jrl.finish_time')) }}</th>
            <th></th>
        </thead>
        <tfoot>
            <th colspan='5'>&nbsp;</th>
            <th>{!! link_to_route('workouts.create', ucfirst(trans('app.new')).' '.trans_choice('jrl.workouts',1)
                ,array(),array('class' => 'btn btn-default')) !!}</th>
        </tfoot>
        <tbody>
            @foreach( $workouts as $workout )
                <tr>
                    <td>{{ date('d-m-Y', strtotime($workout->date)) }}
                    <td><a href="{{ route('workouts.show', $workout->slug)}}">{{ $workout->name }}</a></td>
                    <td>{{ $workout->route }}</td>
                    <td>{{ $workout->distance }} </td>
                    <td>{{ $workout->time }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            {!! Form::open(array('class'=>'form-inline', 'method'=>'DELETE', 'route'=> array('workouts.destroy', $workout->slug))) !!}
                            {!! link_to_route('workouts.edit',ucfirst(trans('app.edit')), array($workout->slug), array('class' => 'btn btn-default')) !!}
                            {!! Form::submit(ucfirst(trans('app.delete')),array('class' => 'btn btn-default')) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<!--</div>-->
{!! $workouts->render() !!}
@endif

@endsection