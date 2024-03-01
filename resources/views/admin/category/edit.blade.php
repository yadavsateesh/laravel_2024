@extends('admin.layout.main')

@section('title') {{ 'Add Category| '.env('APP_NAME') }} @endsection

@push('after-css')
@endpush
@section('content')
<div class="content-wrapper">
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
				<h3 class="box-title">Category</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<form role="form" action="{{ route('category.update',$category->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							<label>Category<span class="text-red">*</span></label>
								<input type="text" class="form-control" name="category_name" value="{{$category->category_name}}" id="exampleInputEmail1" placeholder="Enter Category">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>status<span class="text-red">*</span></label>
						<select class="form-control" name="status" id="status">
							<option value="">--Select status--</option>
							<option value="1" @if($category->status == 1) selected="selected" @endif >Active</option>
							<option value="0" @if($category->status == 0) selected="selected" @endif >Inactive</option>
						</select>
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