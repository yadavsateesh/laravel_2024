@extends('admin.layout.main')

@section('title') {{ 'Change Password | '.env('APP_NAME') }} @endsection

@push('after-css')
@endpush
@section('content')
<div class="content-wrapper">
    <section class="content-header">
		<h1>
			Change Password
			<small>Preview</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Admin</li>
		</ol>
	</section>
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Change Password</h3>
					</div>
					<form role="form" class="form-horizontal" action="{{ route('admin.profile.update') }}" method="POST">
						@csrf
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
								
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name"  placeholder="Name" id="inputName" value="{{ auth()->guard('admin')->user()->name }}">
									@if ($errors->has('name'))
									<span class="validation" style="color:red;">
										{{ $errors->first('name') }}
									</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
								
								<div class="col-sm-10">
									<input type="email" class="form-control" id="inputEmail" name="email" value="{{ auth()->guard('admin')->user()->email }}" placeholder="Email">
									@if ($errors->has('email'))
									<span class="validation" style="color:red;">
										{{ $errors->first('email') }}
									</span>
									@endif
								</div>
							</div>
							
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button type="submit" class="btn btn-danger">Submit</button>
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
								Chnage password
							</button>
						</div>
						<!-- /.box-footer -->
					</form>
				</div>
			</div>
		</div>
	</section>
</div>

<!--change password modal-->
<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<form role="form" action="{{ route('admin.change.password.update') }}" id="change_password" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Change Password</h4>
				</div>
				<div class="modal-body">
					<input type="password" class="form-control" id="password_data" name="password" value="" placeholder="Old Password">
				</div>
				<div class="modal-body">
					<input type="password" class="form-control" name="confirm_password" value="" placeholder="New Password">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save Password</button>
				</div>
			</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endsection

@push('after-js')
<script>
	$("#change_password").validate({
		rules: {
			password: {
				required: true,
				minlength : 5
			},
			confirm_password: {
				required: true,
				minlength : 5,
				equalTo : "#password_data"
			}, 
			
		},
		messages: {
			password: {
				required: "Please enter password",
				minlength : "Password should have atleast 5 characters"
			},
			confirm_password: {
				required: "Please enter confirm password",
				minlength : "Password should have atleast 5 characters",
				equalTo : "Password is not matching please check it"
			},
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
</script>
@endpush