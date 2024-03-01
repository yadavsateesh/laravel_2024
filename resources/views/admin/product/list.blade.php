@extends('admin.layout.main')

@section('title') {{ 'Product | '.env('APP_NAME') }} @endsection

@push('after-css')
@endpush
@section('content')
<div class="content-wrapper">
    <section class="content-header">
		<h1>
			Product List
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Tables</a></li>
			<li class="active">Data tables</li>
		</ol>
	</section>
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Product List</h3>
						<a type="button" href="{{ route('product.create') }}" class="btn btn-primary">Add</a>
						<a type="button" href="{{ route('product-order') }}" class="btn btn-danger">Product Order</a>
						<a type="button" class="btn btn-danger delete_all">Product All Delete</a>
						<a type="button" class="btn btn-danger status_all" data-type="active" data-status="1">Active</a>
						<a type="button" class="btn btn-danger status_all" data-type="inactive" data-status="0">Inactive</a>
					</div>
					<div class="box-body">
						<table id="product_lists" class="table table-bordered table-striped">
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@push('after-js')
<script>
	$('#product_lists').DataTable({
		ajax: {
			url: "{{ route('product-list') }}",
			type: 'POST',
		},
		
		serverSide: false,
		bAutoWidth: false,
		order: [],
		columns: [
		
		{ data: 'checkbox', title: '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="checkAll" onchange="checkAll($(this))"><label class="custom-control-label" for="checkAll"></label></div>' , sWidth: '1%' },
		{ data: 'product_name', title: "Name" },
		{ data: 'category', title: "Category" },
		{ data: 'subcategory', title: "Subcategory" },
		{ data: 'is_block', title: 'Block' },
		{ data: 'status', title: "Status" },
		{ data: 'created_at', title: "Created At" },
		{ data: 'action', title: "Action" },
		],
		"columnDefs": [ {
			"targets": [0,3],
			"orderable": false,
		}],
		
		
	});
	
	function confirm_click() {
		return confirm('Are you sure you want to delete');
	}
	function checkAll(checkAll) {
		$(".product-checkbox").prop('checked',checkAll.is(":checked"));
	}
	
	$(".delete_all").click(function (event) {
		event.preventDefault();
		var ids = [];
		
		
		$(".product-checkbox").each(function () {
			
			if(this.checked == true)
			{
				ids.push($(this).data('id'));
			}
			
		}); 
		if(ids.length > 0)
		{
			if(confirm("Are you Sure want to do this ?"))
			{
				$.ajax({
					type: "POST",
					url: "all-product-delete",
					data: {
						'id': ids,
					},
					success: function(result) {
						$('#product_lists').DataTable().ajax.reload();
						$("#checkAll").prop('checked',false);
					},
				});
			}
			else{
				return false;
			}
		}
		else
		{
			alert('No row selected.');
			return false;
		}
	}); 
	
	
	//status
	$(".status_all").click(function (event) {
		event.preventDefault();
		var type = $(this).data('type');
		var status = $(this).data('status');
		var id = [];
		
		$('.select-status-checkbox').each(function(){
			if(this.checked == true)
			{
				id.push($(this).data('id'));
			}
		});
		
		if(id.length > 0)
		{
			if(confirm("Are you Sure want to do this ?"))
			{
				$.ajax({
					type: 'POST',
					url: "{{ route('status.multiple.active') }}",
					data: {
						'id': id,
						'type': type,
						'status': status,
					},
					success: function(result) {
						//location.reload(true);
						$('#product_lists').DataTable().ajax.reload();
						$("#checkAll").prop('checked',false);
					},
					error: function(result) {
						//location.reload(true);
					}
				});
			}
			else{
				return false;
			}
		}
		else
		{
			alert('No row selected.');
			return false;
		}
		
		
	}); 
	
</script>
@endpush