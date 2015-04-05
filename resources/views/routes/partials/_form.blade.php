<div class="form-group">
    {!! Form::label('name', 'Naam:') !!}
    {!! Form::text('name') !!}
</div>
<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug') !!}
</div>
<div class="form-group">
    {!! Form::label('distance', 'Afstand:') !!}
    {!! Form::text('distance') !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Omschrijving:') !!}
    {!! Form::textarea('description') !!}
</div>
<div class="form-group">
    {!! Form::label('lon', 'Longitude:') !!}
    {!! Form::text('lon') !!}
</div>
<div class="form-group">
    {!! Form::label('lat', 'Latitude:') !!}
    {!! Form::text('lat') !!}
</div>
<div class="form-group">
    {!! Form::submit($submit_text, ['class'=>'btn btn-primary']) !!}
</div>