@extends('layouts.main')

@section('title') {{ 'Add Category| '.env('APP_NAME') }} @endsection

@push('after-css')
@endpush
@section('content')
    <section class="content-header">
		<h1>
			Advanced Form Elements
			<small>Preview</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Category</li>
		</ol>
	</section>
    <section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
			<button type="submit" class="btn btn-primary pull-right" id="addCategory">Add more</button>
				<h3 class="box-title">Category</h3>
				
				<div class="box-tools pull-right">
					
				</div>
			</div>
			<form role="form" action="{{ route('category.store') }}" method="post">
				@csrf
			<div class="box-body">
				<div class="row">
					<div class="col-md-12 categoryContainer">
						<div class="form-group">
							<label for="exampleInputEmail1">Category</label>
							<input type="text" class="form-control" name="name[]" id="exampleInputEmail1" placeholder="Enter Category">
							@if ($errors->has('name'))
							<span class="validation" style="color:red;">
								{{ $errors->first('name') }}
							</span>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn btn-primary pull-right">Save</button>
			</div>
			</form>
		</div>
	</section>
</div>
@endsection

@push('after-js')
<script>

	// Add more input fields on button click
	var maxFields = 3;
	$("#addCategory").click(function() {
		if($(".addedCategory").length < maxFields){
		var newInput = '<div class="row addedCategory"><div class="col-md-12"><div class="form-group"><label for="exampleInputEmail1">Category</label><input type="text" class="form-control" name="name[]" placeholder="Enter Category"></div></div><div class="col-md-12"><button type="button" class="btn btn-danger removeCategory">Remove</button></div></div>';
		$(".categoryContainer").append(newInput);
		 } else {
			alert("Maximum limit reached (03 fields).");
		}
	});
	
 // Remove input fields on remove button click
	$(".categoryContainer").on("click", ".removeCategory", function() {
		$(this).closest(".addedCategory").remove();
	});
</script>
@endpush





