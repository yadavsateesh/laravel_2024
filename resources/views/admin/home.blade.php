@extends('admin.layout.main')

@section('title') {{ 'Add Home | '.env('APP_NAME') }} @endsection

@push('after-css')
@endpush
@section('content')
<div class="content-wrapper">
    <section class="content-header">
		<h1>
			{{ __('messages.dashboard') }}
			<small>{{ __('messages.control_panel') }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
			<li class="active">{{ __('messages.dashboard') }}</li>
		</ol>
	</section>
    <section class="content">
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>{{$total_user}}</h3>
						
						<p>{{ __('messages.total_user') }}</p>
					</div>
					<div class="icon">
						<i class="ion ion-bag"></i>
					</div>
					<a href="#" class="small-box-footer">{{ __('messages.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>0<sup style="font-size: 20px">%</sup></h3>
						
						<p>{{ __('messages.bounce_rate') }}</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="#" class="small-box-footer">{{ __('messages.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>0</h3>
						
						<p>{{ __('messages.user_registrations') }}</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">{{ __('messages.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>0</h3>
						
						<p>{{ __('messages.unique_visitors') }}</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
					<a href="#" class="small-box-footer">{{ __('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@push('after-js')
@endpush
