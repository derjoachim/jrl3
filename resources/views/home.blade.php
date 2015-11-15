@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ ucfirst(trans('app.home')) }}</div>

				<div class="panel-body">
					{{ trans('jrl.welcome_to_jrl') }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
