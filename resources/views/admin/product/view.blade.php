@extends('admin.layout.main')
@section('title') {{ 'Add Invoice | '.env('APP_NAME') }} @endsection
@push('after-css')
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			Invoice
			<small>#007612</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Invoice</li>
		</ol>
	</section>
	
    <div class="pad margin no-print">
		<div class="callout callout-info" style="margin-bottom: 0!important;">
			<h4><i class="fa fa-info"></i> Note:</h4>
			This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
		</div>
	</div>
	
    <!-- Main content -->
    <section class="invoice">
		<!-- title row -->
		<div class="row">
			<div class="col-xs-12">
				<h2 class="page-header">
					<i class="fa fa-globe"></i> AdminLTE, Inc.
					<small class="pull-right">Date: 2/10/2014</small>
				</h2>
			</div>
			<!-- /.col -->
		</div>
		<!-- info row -->
		@foreach($product as $value)
		<div class="row invoice-info">
			<div class="col-sm-4 invoice-col">
				{{$value->id}}
				<address>
					<strong>Admin, Inc.</strong><br>
					795 Folsom Ave, Suite 600<br>
					San Francisco, CA 94107<br>
					Phone: (804) 123-5432<br>
					Email: info@almasaeedstudio.com
				</address>
			</div>
			<!-- /.col -->
			<div class="col-sm-4 invoice-col">
				{{$value->product_name}}
				<address>
					<strong>John Doe</strong><br>
					795 Folsom Ave, Suite 600<br>
					San Francisco, CA 94107<br>
					Phone: (555) 539-1037<br>
					Email: john.doe@example.com
				</address>
			</div>
			<!-- /.col -->
			<div class="col-sm-4 invoice-col">
				{{$value->status}}
				<br>
				<b>Order ID:</b> 4F3S8J<br>
				<b>Payment Due:</b> 2/22/2014<br>
				<b>Account:</b> 968-34567
			</div>
			<!-- /.col -->
		</div>
		@endforeach
		<!-- this row will not appear when printing -->
		<div class="row no-print">
			<div class="col-xs-12">
				<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
				<button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
				</button>
				<a href="{{ route('product.generatepdf',$value->id) }}" target="_blank" class="btn btn-default pull-right"><i class="fa fa-download"></i> Generate PDF</a>
				<a href="{{ route('product.export') }}" target="_blank" class="btn btn-default"><i class="fa fa-download"></i> Export Exacel Sheet</a>
			</div>
			
		</div>
		<form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="file" name="file" class="form-control">
			<br>
			<button class="btn btn-success">Import Exacel Sheet</button>
		</form>
	</section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
@endsection
@push('after-js')
@endpush