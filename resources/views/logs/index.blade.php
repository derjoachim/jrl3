<!-- /resources/views/routes/index.blade.php -->
@extends('app')

@section('content')
<h2>{{ ucfirst(trans_choice('jrl.logs',2)) }}</h2>
@if( !$logs->count() ) 
<div class="alert alert-info">{!! trans('jrl.no_logs_defined', [ 'url' => URL::route('logs.create') ] ) !!}</div>
<div>{!! link_to_route('logs.create', ucfirst(trans('app.new')).' '.ucfirst(trans_choice('jrl.logs',1))
    ,array(),array('class' => 'btn btn-default')) !!}</div>
@else
<div class="row-fluid">
    <table class="table table-condensed table-striped">
        <thead>
            <th></th>
            <th>{{ ucfirst(trans('jrl.start_date')) }}</th>
            <th>{{ ucfirst(trans('jrl.end_date')) }}</th>
            <th></th>
        </thead>
        <tfoot>
            <th colspan='4'>&nbsp;</th>
            <th>{!! link_to_route('logs.create', ucfirst(trans('app.new')).' '.ucfirst(trans_choice('jrl.logs',1))
                ,array(),array('class' => 'btn btn-default')) !!}</th>
        </tfoot>
        <tbody>
            @foreach( $logs as $log )
                <tr>
                    <td/>
                    <td>{{ date('d-m-Y', strtotime($log->start_date)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($log->end_date)) }}</td>
                    <td>
                        <div class="pull-right">
                            {!! Form::open(array('id' => 'form-delete-'.$log->id, 'class'=>'form-inline', 'method'=>'DELETE', 'route'=> array('logs.destroy', $log))) !!}
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <a href="/logs/{{ $log->id }}/download" target="_blank"><i class="glyphicon glyphicon-download"></i></a>&nbsp;
                            <a href="{{ route('logs.edit', ['id' => $log->id]) }}"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;
                            <a href="#" onclick="dothedeletethingy({{ $log->id }});"><i class="glyphicon glyphicon-trash"></i></a>
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<script type="text/javascript">
    // @TODO: Put this in a nice modal
    function dothedeletethingy(id) {
        if(confirm('Als een bestaand logboek wordt verwijderd, wordt het downloadbare PDF-bestand verwijderd, alsmede de bijbehorende aantekeningen. Weet u zeker dat u dit logboek wilt verwijderen?')) {
            $("#form-delete-"+id).submit();
        }
    }
</script>

@endsection