@extends('admin.layout.main')

@section('title') {{ 'SubCategory | '.env('APP_NAME') }} @endsection

@push('after-css')
@endpush
@section('content')
<div class="content-wrapper">
    <section class="content-header">
		<h1>
			SubCategory List
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Tables</a></li>
			<li class="active">Data tables</li>
		</ol>
	</section>
    <section class="content">
		@if (Session::get('success'))
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">{{ Session::get('success') }}</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fa fa-times"></i></button>
				</div>
			</div>
		</div>
		@endif
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">SubCategory List</h3>
						<a type="button" href="{{ route('subcategory.create') }}" class="btn btn-primary">Add</a>
						<a type="button" class="btn btn-primary delete_all">All Delete</a>
					</div>
					<div class="box-body">
						<table id="subcategory_lists" class="table table-bordered table-striped">
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
	$('#subcategory_lists').DataTable({
		ajax: {
			url: "{{ route('subcategory-list') }}",
			type: 'POST',
		},
		//serverSide: true,
		bAutoWidth: false,
		order: [],
		columns: [
		
		{ data: 'checkbox', title: '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="checkAll" onchange="checkAll($(this))"><label class="custom-control-label" for="checkAll"></label></div>' , sWidth: '1%' },
		{ data: 'subcategory_name', title: "Name" },
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
		$(".subcategory-checkbox").prop('checked',checkAll.is(':checked'));
	}
	
	$(".delete_all").click(function (event) {
		event.preventDefault();
		var ids = [];
		
		
		$(".subcategory-checkbox").each(function () {
			
			if(this.checked == true)
			{
				ids.push($(this).data('id'));
			}
			
		}); 
		if(ids.length > 0)
		{
			if(confirm("Are you Sure want to do this delete ?"))
			{
				$.ajax({
					type: "POST",
					url: "all-subcategory-delete",
					data: {
						'id': ids,
					},
					success: function(result) {
						$('#subcategory_lists').DataTable().ajax.reload();
						$("#checkAll").prop('checked',false)
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
	
</script>
@endpush