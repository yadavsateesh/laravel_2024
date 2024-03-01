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
			<li class="active">SubCategory</li>
		</ol>
	</section>
    <section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">SubCategory</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<form role="form" action="{{ route('subcategory.store') }}" method="post">
				@csrf
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>SubCategory<span class="text-red">*</span></label>
								<input type="text" class="form-control" name="subcategory_name" value="" id="exampleInputEmail1" placeholder="Enter Category">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Category<span class="text-red">*</span></label>
						<select class="form-control media" name="category_id" id="subcategory">
							<option value="">-- select_category--</option>
							@foreach($category as $value)
							<option data-atr="{{ $value->category_name }}" value="{{ $value->id }}" @if(old('category_id') == $value->id ) selected="selected" @endif>{{ $value->category_name }}</option>
							@endforeach
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
<script>
	$('.media').change(function(){
	//alert("11");
var text = $("#subcategory option:selected").attr('data-atr');
	if(text == 'sateesh')
	{
		$("#subcategory option:selected").hide();
	}
		
});
	
</script>
@endpush