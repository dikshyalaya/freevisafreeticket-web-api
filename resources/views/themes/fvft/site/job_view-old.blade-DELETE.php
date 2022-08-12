@extends('themes.fvft.layouts.master')
@section('title', 'Job Detail')
@section('style')
<!-- jquery ui RangeSlider -->
<link href="{{asset('themes/fvft/')}}/assets/plugins/jquery-uislider/jquery-ui.css" rel="stylesheet">
@endsection
@section('main')
        @include('themes.fvft.site.components.header')
        <section class="sptb">
			<div class="container">
				<div class="row">
					<div class="col-xl-8 col-lg-12 col-md-12">
						<!--Jobs Description-->
						<div class="card overflow-hidden">
							{{-- <div class="ribbon ribbon-top-right text-danger"><span class="bg-danger">Urgent</span></div> --}}
							<div class="card-body h-100">
								<div class="row">
									<div class="col">
										<div class="profile-pic mb-0">
											<div class="d-md-flex">
												<img src="{{asset("/")}}{{$job->feature_image_url != null ? $job->feature_image_url : 'images/defaultimage.jpg'}}" class="w-20 h-20" alt="user">
												<div class="ml-4">
													<a href="/job/{{$job->id}}" class="text-dark"><h4 class="mt-3 mb-1 fs-20 font-weight-bold">{{ $job->title }}</h4></a>
													<div class="">
														<ul class="mb-0 d-flex">
															<li class="mr-3"><a href="#" class="icons"><i class="si si-briefcase text-muted mr-1"></i>  {{ $company->company_name}}</a></li>
															<li class="mr-3"><a href="#" class="icons"><i class="si si-location-pin text-muted mr-1"></i> {{@DB::table('countries')->find($job->country_id)->name}} </a></li>
															<li class="mr-3"><a href="#" class="icons"><i class="si si-calendar text-muted mr-1"></i>{{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</a></li>
															{{-- <li class="mr-3"><a href="#" class="icons"><i class="si si-eye text-muted mr-1"></i> 765</a></li> --}}
														</ul>
														{{-- <div class="rating-stars d-inline-flex mb-4 mr-3 mt-2">
															<input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="4">
															<div class="rating-stars-container mr-2">
																<div class="rating-star sm">
																	<i class="fa fa-star"></i>
																</div>
																<div class="rating-star sm">
																	<i class="fa fa-star"></i>
																</div>
																<div class="rating-star sm">
																	<i class="fa fa-star"></i>
																</div>
																<div class="rating-star sm">
																	<i class="fa fa-star"></i>
																</div>
																<div class="rating-star sm">
																	<i class="fa fa-star"></i>
																</div>
															</div> 4.0
														</div>
														<div class="rating-stars d-inline-flex mb-4">
															<div class="rating-stars-container mr-1">
																<div class="rating-star sm">
																	<i class="fa fa-heart"></i>
																</div>
															</div> 145
														</div> --}}
													</div>
													<div class="icons">
														@auth
														    @if(auth()->user()->user_type == 'candidate')
																@php
																	$application = \DB::table('job_applications')->where('job_id',$job->id)->where('employ_id', $employ->id)->first();
																@endphp
																@if($application)
																	<a href="javascript:void(0);" class="btn btn-danger icons mt-1 mb-1" >Applied</a>
																	{{-- <a href="/remove-application/{{$job->id}}" class="btn btn-danger icons mt-1 mb-1" > Remove Application</a> --}}
																@else
																	<a href="/apply-job/{{$job->id}}" class="btn btn-info icons"> Apply Now</a>
																@endif
															@endif
														@else
															<a href="/apply-job/{{$job->id}}" class="btn btn-info icons"> Apply Now</a>
														@endauth

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body border-top">
								<h4 class="mb-4 card-title">Job Description</h4>
								<div class="mb-4">
									<p>{!! html_entity_decode($job->description_intro) !!}</p>

								</div>
								<h4 class="mb-4 card-title">Job Details</h4>
								<div class="row">
									<div class="col-xl-12 col-md-12">
										<div class="table-responsive">
											<table class="table row table-borderless w-100 m-0 text-nowrap ">
												<tbody class="col-lg-12 col-xl-6 p-0">
													<tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Job Type</span></td> <td><span>:</span></td> <td><span> {{@DB::table('job_shifts')->find($item->job_shift_id)->job_shift}}</span></td>
													</tr>
													{{-- <tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Role</span></td> <td><span>:</span></td> <td><span> Hard ware Technician</span></td>
													</tr> --}}
													<tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Min Salary</span></td> <td><span>:</span></td> <td><span> Rs.{{$job->salary_from}}/-</span></td>
													</tr>
													<tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Max Salary</span></td> <td><span>:</span></td> <td><span> Rs.{{$job->salary_to}}/-</span></td>
													</tr>
													<tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Uploads at</span></td> <td><span>:</span></td> <td><span>{{ \Carbon\Carbon::parse($job->updated_at)->diffForHumans() }}</span></td>
													</tr>
												</tbody>
												<tbody class="col-lg-12 col-xl-6 p-0">
													<tr>
														<td class="w-150 px-0"><span class="font-weight-semibold"> Expired</span></td> <td><span>:</span></td> <td><span> {{ \Carbon\Carbon::parse($job->expiry_date)->diffForHumans() }}</span></td>
													</tr>
													{{-- <tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Languages</span></td> <td><span>:</span></td> <td><span> English , Hindi</span></td>
													</tr> --}}
													<tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Location</span></td> <td><span>:</span></td> <td><span> {{@DB::table('cities')->find($item->city_id)->name.","}} {{@DB::table('countries')->find($item->country_id)->name}}</span></td>
													</tr>
													<tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Eligibility</span></td> <td><span>:</span></td> <td><span> {{ @DB::table('educationlevels')->find($job->education_level_id)->title}}</span></td>
													</tr>
													<tr>
														<td class="w-150 px-0"><span class="font-weight-semibold">Company</span></td> <td><span>:</span></td> <td><span> {{ $company->company_name}}</span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="list-id">
									<div class="row">
										<div class="col">
											<a class="mb-0">Job ID : #{{$job->id}}</a>
										</div>
										<div class="col col-auto">
											Posted By <a class="mb-0 font-weight-bold">{{ $company->company_name}}</a> /  {{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer bg-light-50">
								<div class="icons">
									@auth
										@if(auth()->user()->user_type == 'candidate')
											@php
												$application = \DB::table('job_applications')->where('job_id',$job->id)->where('employ_id', $employ->id)->first();
												@endphp
												@if($application)
													<a href="javascript:void(0);" class="btn btn-danger icons mt-1 mb-1" >Applied</a>
													{{-- <a href="/remove-application/{{$job->id}}" class="btn btn-danger icons mt-1 mb-1" > Remove Application</a> --}}
												@else
													<a href="/apply-job/{{$job->id}}" class="btn btn-info icons"> Apply Now</a>
												@endif
											@endif
										@else
											<a href="/apply-job/{{$job->id}}" class="btn btn-info icons"> Apply Now</a>
										@endauth
									<a href="#" class="btn btn-primary icons mt-1 mb-1"><i class="si si-share mr-1"></i> Share Job</a>
									<a href="#" class="btn btn-info icons mt-1 mb-1"><i class="si si-printer  mr-1"></i> Print</a>
									<a href="#" class="btn btn-danger icons mt-1 mb-1" data-toggle="modal" data-target="#report"><i class="icon icon-exclamation mr-1"></i> Report Abuse</a>
								</div>
							</div>
						</div>
						<!--Jobs Description-->

					</div>

					<!--Right Side Content-->
					<div class="col-xl-4 col-lg-12 col-md-12">
                        @if($company_contact_persons)
                        {{-- @dd($company_contact_persons) --}}

						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Posted By</h3>
							</div>
							<div class="card-body  item-user">
								<div class="profile-pic mb-0">
									<img src="{{asset("/")}}{{$company_contact_persons->avatar != null ? $company_contact_persons->avatar : 'uploads/defaultimage.jpg'}}" class="brround avatar-xxl" alt="user">
									<div class="">
										<a href="userprofile.html" class="text-dark"><h4 class="mt-3 mb-1 font-weight-semibold">{{ $company_contact_persons->name}}</h4></a>
										<span class="text-gray">{{ $company_contact_persons->position}} of {{$company->company_name}}</span>
										<span class="text-muted">Member Since  {{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</span>
										<h6 class="mt-2 mb-0"><a href="#" class="btn btn-primary btn-sm">See All Ads</a></h6>
									</div>

								</div>
							</div>
							<div class="card-body item-user">
								<h4 class="mb-4 card-title">Contact Info</h4>
								<div>
									<h6><span class="font-weight-semibold"><i class="fa fa-envelope mr-2 mb-2"></i></span><a href="#" class="text-body"> {{ $company_contact_persons->email}}</a></h6>
									<h6><span class="font-weight-semibold"><i class="fa fa-phone mr-2  mb-2"></i></span><a href="#" class="text-primary">{{ $company_contact_persons->phone}}</a></h6>
									{{-- <h6><span class="font-weight-semibold"><i class="fa fa-link mr-2 "></i></span><a href="#" class="text-primary">http://spruko.com/</a></h6> --}}
								</div>
								<div class=" item-user-icons mt-4">
									<a href="#" class="facebook-bg mt-0"><i class="fa fa-facebook"></i></a>
									<a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a>
									<a href="#" class="google-bg"><i class="fa fa-google"></i></a>
									<a href="#" class="dribbble-bg"><i class="fa fa-dribbble"></i></a>
								</div>
							</div>
							<div class="card-footer bg-light-50">
								<div class="text-left">
									<a href="#" class="btn  btn-info"><i class="fa fa-envelope"></i> Chat</a>
									<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#contact"><i class="fa fa-user"></i> Contact Me</a>
								</div>
							</div>
						</div>
                        @endif

						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Shares</h3>
							</div>
							<div class="card-body product-filter-desc">
								<div class="product-filter-icons text-center">
									<a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a>
									<a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a>
									<a href="#" class="google-bg"><i class="fa fa-google"></i></a>
									<a href="#" class="dribbble-bg"><i class="fa fa-dribbble"></i></a>
									<a href="#" class="pinterest-bg"><i class="fa fa-pinterest"></i></a>
								</div>
							</div>
						</div>

					</div>
					<!--/Right Side Content-->
				</div>
			</div>
		</section>

		@include('themes.fvft.site.components.footer')
@endsection
