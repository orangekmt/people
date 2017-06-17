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
        <h2>List</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- Window title -->

      <!-- Window content -->
      <div class="x_content">
        <br />
						@if ($message = Session::get('success'))
							<div class="alert alert-success alert-dismissible">
								<button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
								{{ $message }}
							</div>
						@endif
						@if ($message = Session::get('error'))
							<div class="alert alert-danger alert-dismissible">
								<button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
								{{ $message }}
							</div>
						@endif
					<table class="display table-bordered table-hover table-responsive" cellspacing="0" width="100%">
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Description</th>
							<th width="280px">
								@permission('role-create')
									<a data-toggle="tooltip" title="Create new" href="{{ route('roles.create') }}" class="btn btn-info btn-xs" align="right"><span class="glyphicon glyphicon-plus"> New</span></a>
								@endpermission
							</th>

						</tr>
					@foreach ($roles as $key => $role)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $role->display_name }}</td>
						<td>{{ $role->description }}</td>
						<td>
							@permission('role-edit')
							<a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
							@endpermission
							@permission('role-delete')
							{!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
				            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
				        	{!! Form::close() !!}
				        	@endpermission
						</td>
					</tr>
					@endforeach
					</table>
					{!! $roles->render() !!}
      </div>
      <!-- Window content -->

    </div>
  </div>
</div>
<!-- Window -->

@endsection
