    <div class="col-lg-3">
        <div class="btn-group" role="group" >
            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-save"></i> 
                {{ ucfirst(trans('app.save')) }}
            </button>
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-lg-9">
        <div class="form-group">
            {!! Form::label('start_date', ucfirst(trans('jrl.start_date')).':',['class' => 'control-label']) !!}
            {!! Form::input('date','start_date',$start_date,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('start_date', ucfirst(trans('jrl.end_date')).':',['class' => 'control-label']) !!}
            {!! Form::input('date','end_date',$end_date,['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="form-group">
            {!! Form::label('description', ucfirst(trans('jrl.description')).':',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor', 'rows' => '5']) !!}
        </div>
    </div>
</div>
