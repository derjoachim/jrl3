<!-- /resources/views/logs/create.blade.php -->
@extends('app')

@section('content')
<div class="row">
    {!! Form::model(new App\Models\Log, ['route' => 'logs.store', 'class'=>'form-horizontal']) !!}
    <div class="col-lg-9">
        <div class="page-header">
            <h2>{{ ucfirst(trans('app.create_new')) }} {{ trans_choice('jrl.logs',1) }}</h2>
        </div>
    </div>
    @include('logs/partials/_form',['start_date' => null, 'end_date'=>null])
    {!! Form::close() !!}
</div>
@endsection