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
				<h3 class="box-title">Product</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<form role="form" action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Product<span class="text-red">*</span></label>
								<input type="text" class="form-control" name="product_name" value="{{$product->product_name}}" id="exampleInputEmail1" placeholder="Enter Product">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Category<span class="text-red">*</span></label>
						<select class="form-control" name="category_id" id="status" onChange="getsubcategory(this.value);">
							<option value="">-- select_category --</option>
							@foreach($category as $value)
							<option value="{{ $value->id }}" @if($value->id == $product->category_id ) selected="selected" @endif>{{ $value->category_name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>SubCategory<span class="text-red">*</span></label>
						<select class="form-control" name="subcategory_id[]" id="multi-value-subcategory" multiple="multiple">
							<option value="">-- select_subcategory --</option>
							@foreach($subcategory as $value)
							<option value="{{ $value->id }}" @if(in_array($value->id, explode(',',$product->subcategory_id))) selected="selected" @endif>{{ $value->subcategory_name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>status<span class="text-red">*</span></label>
						<select class="form-control" name="status" id="status">
							<option value="">--Select status--</option>
							<option value="1" @if($product->status == 1) selected="selected" @endif >Active</option>
							<option value="0" @if($product->status == 0) selected="selected" @endif >Inactive</option>
						</select>
					</div>
					<div class="form-group">
						<label class="text-label">Product Image<span class="text-red"></span></label>
						<input type="file" class="form-control" name="image[]" value="{{ old('image') }}" multiple>
						@if ($errors->has('image'))
						<span class="validation" style="color:red;">
							{{ $errors->first('image') }}
						</span>
						@endif
					</div>
				</div>
				@if(!empty($images))
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th><strong>Id</strong></th>
									<th><strong>Image</strong></th>
									<th><strong>Action</strong></th>
								</tr>
							</thead>
							<tbody>
								@foreach($images as $value)
								<tr>
									<td><strong>{{$value['id']}}</strong></td>
									<td><div class="d-flex align-items-center"><img src="{{ asset('storage/product/'. $value['image'])}}" class="rounded-lg mr-2" width="50px" height="50px" alt=""/> </div></td>
									<td>
										<div class="d-flex">
											<a href="{{route('image.delete',$value['id'])}}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
										</div>
									</td>
								</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
				</div>
				@endif
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
	function getsubcategory(val) {
		$.ajax({
			type: 'POST',
			url: "{{ route('get-subcategory') }}",
			data: {
				'category_id': val,
			},
			success: function(result) {
				$("#multi-value-subcategory").html(result);
			},
			error: function() {
				//location.reload(true);
			}
		});
	}
</script>
@endpush