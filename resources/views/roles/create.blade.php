@extends('layouts.app')

@section('content')
<!-- Page title -->
<div class="page-title">
  <div class="title_left">
    <h3>Role</h3>
  </div>
</div>
<div class="clearfix"></div>
<!-- Page title -->

<!-- Window -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

      <!-- Window title -->
      <div class="x_title">
        <h2>Create</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
			            <div class="form-group">
			                <strong>Name:</strong>
			                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
			            </div>
			        </div>
					<div class="col-xs-12 col-sm-12 col-md-12">
			            <div class="form-group">
			                <strong>Display Name:</strong>
			                {!! Form::text('display_name', null, array('placeholder' => 'Display Name','class' => 'form-control')) !!}
			            </div>
			        </div>
			        <div class="col-xs-12 col-sm-12 col-md-12">
			            <div class="form-group">
			                <strong>Description:</strong>
			                {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','style'=>'height:100px')) !!}
			            </div>
			        </div>
			        <div class="col-xs-12 col-sm-12 col-md-12">
			            <div class="form-group">
			                <strong>Permission:</strong>
			                <br/>
			                @foreach($permission as $value)
			                	<label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
			                	{{ $value->display_name }}</label>
			                	<br/>
			                @endforeach
			            </div>
			        </div>
			        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
							<button type="submit" class="btn btn-primary">Submit</button>
			        </div>
				</div>
				{!! Form::close() !!}
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->
	
@endsection
