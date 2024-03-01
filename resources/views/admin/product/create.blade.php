@extends('admin.layout.main')

@section('title') {{ 'Add Product| '.env('APP_NAME') }} @endsection

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
			<li class="active">Product</li>
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
			<form role="form" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="box-body">
					<div class="row">
						<div class="col-md-12" id="add-more-product">
							<div class="form-group">
								<label>Product<span class="text-red">*</span></label>
								<input type="text" class="form-control" name="product_name[]" value="" id="exampleInputEmail1" placeholder="Enter Product">
								<i class="fa fa-fw fa-plus addMore"></i>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Category<span class="text-red">*</span></label>
						<select class="form-control" name="category_id" id="status" onChange="getsubcategory(this.value);">
							<option value="">-- select_category--</option>
							@foreach($category as $value)
							<option data-atr="{{ $value->category_name }}" value="{{ $value->id }}" @if(old('category_id') == $value->id ) selected="selected" @endif>{{ $value->category_name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group" id="multi-subcategory">
						<label >SubCategory<span class="text-red">*</span></label>
						<select class="form-control" name="subcategory_id[]" id="multi-value-subcategory" multiple="multiple">
							<option value="">-- select_subcategory--</option>
							@foreach($subcategory as $value)
							<option value="{{ $value->id }}" @if(old('subcategory_id') == $value->id ) selected="selected" @endif>{{ $value->subcategory_name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label class="text-label">Product Image<span class="text-red">*</span></label>
						<input type="file" class="form-control" name="image[]" value="{{ old('image') }}" multiple>
						@if ($errors->has('image'))
						<span class="validation" style="color:red;">
							{{ $errors->first('image') }}
						</span>
						@endif
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
	function getsubcategory(val) {
		//alert("hlo");
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
		
		var text = $("#status option:selected").attr('data-atr');
		
		if(text == 'sateesh')
		{
			$("#multi-subcategory").hide();
		}
		else
		{
			$("#multi-subcategory").show();
		}
	}
	
	var max_field = 7 ;
	var x= 1;
	
	$('.addMore').click(function(e){
		e.preventDefault();
		
		if(x<max_field){
			
			var tr ='<div class="row" id="remove_'+x+'"><div class="col-md-12"><div class="form-group"><label>Product<span class="text-red">*</span></label><input type="text" class="form-control _'+x+'" name="product_name[]" value="" id="exampleInputEmail1" placeholder="Enter Product"><i class="fa fa-fw fa-times remove" data-doc-row="'+x+'"></i></div></div></div>';
			
			x++;
			
			$('#add-more-product').append(tr);
		}
	})
	
	$('#add-more-product').on('click','.remove',function(e){
		e.preventDefault();
		var document_row = $(this).attr("data-doc-row");
		$("#remove_"+document_row).remove();
		
		x--;
	});
</script>
@endpush	