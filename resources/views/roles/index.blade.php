@extends('layouts.app',['main_title' => 'Roles','second_title'=>'list','url'=>[['name'=>'home','url'=>route('home')],['name'=>'roles list','url'=>'#']]])

@section('content')
<div class="box box-info">
		<div class="box-header">
				<i class="fa fa-cloud-download"></i>
				<h3 class="box-title">Roles list</h3>
				<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
		</div>
		<div class="box-body">
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
	</div>
</div>
@endsection
