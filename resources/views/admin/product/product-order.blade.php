@extends('admin.layout.main')

@section('title') {{ 'Add Category | '.env('APP_NAME') }} @endsection

@push('after-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.2.7/jquery.nestable.css" integrity="sha512-sG2Mn2Z5U3x34i16O/MYDDVCHnyvrY16jPKxRxOe4WjsCisrVIA/qp4k74tXZj342ozG7646DAuINHBlWjHZVg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="content-wrapper">
    <section class="content-header">
		<h1>
			Product Order
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
			<form role="form" action="{{ route('product-order') }}" method="post">
				@csrf
				<div class="box-body">
					<div class="form-group">
						<label>Category<span class="text-red">*</span></label>
						<select class="form-control media" name="category_id" id="category_id">
							<option value="">-- select_category--</option>
							@foreach($category as $value)
							<option data-atr="{{ $value->category_name }}" value="{{ $value->id }}" @if((old('category_id') == $value->id ) || ($value->id == $category_id)) selected="selected" @endif>{{ $value->category_name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="box-footer">
					<a href="{{ route('product.index') }}" class="btn btn-default">Cancel</a>
					<button type="submit" class="btn btn-primary pull-right">Save</button>
				</div>
			</form>
		</div>
		@if(!empty($product))
		<div class="box-footer clearfix no-border" style="padding-top: 20px;">
			<div class="cf nestable-lists">
				<form role="form" action="{{ route('product-order-save') }}" method="POST">
					@csrf
					<div class="dd" id="nestable">
						<ol class="dd-list">
							@foreach($product as $value)
							<li class="dd-item" data-id="{{ $value->id }}">
								<input type="hidden" value="{{ $value->id }}" name="row_order[]" id="widget_output">
								<div class="dd-handle">{{$value->order}}.{{ $value->product_name }}</div>
							</li>
							@endforeach
						</ol>
					</div>
					<button type="submit" class="btn mr-2 btn-primary">submit</button>
					<a href="{{ route('product.index') }}" class="btn btn-default">Reset</a>
				</div>
			</form>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>
			$(document).ready(function()
			{
				var updateOutput = function(e)
				{
					var list   = e.length ? e : $(e.target),
					output = list.data('output');
					if (window.JSON) {
						output.val(window.JSON.stringify(list.nestable('serialize')));
						} else {
						output.val('JSON browser support required for this demo.');
					}
				};
				updateOutput($('#nestable').data('output', $('#nestable-output')));
				
			});
		</script>
		@endif
	</section>
</div>    
@endsection
@push('after-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.2.7/jquery.nestable.min.js" integrity="sha512-gg00YAa6WTyGCALtj/Mor3Pu7rIezp23VLX2ZcS2ISIjSTI3/TVJke3KSCE7tH854QjJaR4mRnFg1OZdpXLqdw==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
@endpush
