<!-- /resources/views/logs/edit.blade.php -->
@extends('app')

@section('content')
<div class="row">
    {!! Form::model($log, ['method' => 'PATCH', 'route' => ['logs.update', $log->id], 'class'=>'form-horizontal']) !!}
    
    <div class="col-lg-9">
        <div class="page-header">
            <h2>{{ ucfirst(trans_choice('jrl.logs',1)) }} - <small>{{ ucfirst(trans('app.edit')) }}</small></h2>
        </div>
    </div>
    @include('logs/partials/_form', ['start_date' => $log->start_date, 'end_date' => $log->end_date])
    {!! Form::close() !!}
</div>
@endsection