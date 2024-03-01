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
			<form role="form" action="{{ route('category.store') }}" method="post">
				@csrf
				<div class="box-body">
					<div class="row">
						<div class="col-md-12" id="add-more-category">
							<div class="form-group">
								<label for="exampleInputEmail1">Category</label>
								<input type="text" class="form-control" name="category_name[]" id="exampleInputEmail1" placeholder="Enter Category">
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-default">Cancel</button>
					<button type="submit" class="btn btn-primary pull-right">Save</button>
					<a class="btn btn-danger pull-right addMore">Add More</a>
				</div>
			</form>
		</div>
	</section>
</div>
@endsection
@push('after-js')
<script>
	var max_field = 7;
	var x = 1;
	$('.addMore').click(function(e){
		e.preventDefault();
		if(x<max_field){
			var tr = '<div class="row" id="remove_'+x+'"><div class="col-md-12" ><div class="form-group"><label for="exampleInputEmail1">Category</label><input type="text" class="form-control _'+x+'" name="category_name[]" id="exampleInputEmail1" placeholder="Enter Category"></div></div><div class="col-md-3 col-sm-4 remove" data-doc-row="'+x+'"><i class="fa fa-fw fa-times"></i></div></div>';
			x++;
			
			$('#add-more-category').append(tr);
		}
		
	});
	
	$('#add-more-category').on('click','.remove',function(e){
		e.preventDefault();
		var document_row = $(this).attr("data-doc-row");
		$("#remove_"+document_row).remove();
		
		x--;
	});
	
</script>
@endpush