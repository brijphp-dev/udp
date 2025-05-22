{{-- Extends layout --}}
@extends('layout.default')

@section('content')
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Profile Personal Information-->
			<div class="d-flex flex-row">
				<!--begin::Aside-->
				<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
					<!--begin::Profile Card-->
					<div class="card card-custom card-stretch">
						<!--begin::Body-->
						<div class="card-body pt-4">
							<!--begin::Toolbar-->
							<div class="d-flex justify-content-end">
								<div class="dropdown dropdown-inline">
									<a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="ki ki-bold-more-hor"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
										<!--begin::Navigation-->
										<ul class="navi navi-hover py-5">
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-drop"></i>
													</span>
													<span class="navi-text">New Group</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-list-3"></i>
													</span>
													<span class="navi-text">Contacts</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-rocket-1"></i>
													</span>
													<span class="navi-text">Groups</span>
													<span class="navi-link-badge">
														<span class="label label-light-primary label-inline font-weight-bold">new</span>
													</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-bell-2"></i>
													</span>
													<span class="navi-text">Calls</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-gear"></i>
													</span>
													<span class="navi-text">Settings</span>
												</a>
											</li>
											<li class="navi-separator my-3"></li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-magnifier-tool"></i>
													</span>
													<span class="navi-text">Help</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="#" class="navi-link">
													<span class="navi-icon">
														<i class="flaticon2-bell-2"></i>
													</span>
													<span class="navi-text">Privacy</span>
													<span class="navi-link-badge">
														<span class="label label-light-danger label-rounded font-weight-bold">5</span>
													</span>
												</a>
											</li>
										</ul>
										<!--end::Navigation-->
									</div>
								</div>
							</div>
							<!--end::Toolbar-->
							<!--begin::User-->
							<div class="d-flex align-items-center">
								<div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
									<div class="symbol-label" style="background-image:url('{{ $profileImg }}')"></div>
									<i class="symbol-badge bg-success"></i>
								</div>
								<div>
									<span class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{ $editUserDetail[0]->first_name }} {{ $editUserDetail[0]->last_name }}</span>
									<div class="text-muted">Member</div>
								</div>
							</div>
							<!--end::User-->
							<!--begin::Contact-->
							<div class="py-9">
								<div class="d-flex align-items-center justify-content-between mb-2">
									<span class="font-weight-bold mr-2">Email:</span>
									<a href="#" class="text-muted text-hover-primary">{{ $editUserDetail[0]->email }}</a>
								</div>
								<div class="d-flex align-items-center justify-content-between mb-2">
									<span class="font-weight-bold mr-2">Phone:</span>
									<span class="text-muted">{{ $editUserDetail[0]->phone }}</span>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<span class="font-weight-bold mr-2">Chapter:</span>
									<span class="text-muted">@if ($editUserDetail[0]->chapterDetail) {{ $editUserDetail[0]->chapterDetail->chapter_name }} @else Global Chapter @endif</span>
								</div>
							</div>
							<!--end::Contact-->
							<!--begin::Nav-->
							<div class="navi navi-bold navi-hover navi-active navi-link-rounded">
								<div class="navi-item mb-2">
									<a href="{{ route('admin.member.Card.Print', [encode_url( $editUserDetail[0]->id )]) }}" class="navi-link py-4 active"data-toggle="tooltip" title="Print Membership card" data-placement="right" target="_blank">
										<span class="navi-icon mr-2">
											<span class="svg-icon">
												<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24" />
														<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>
										</span>
										<span class="navi-text font-size-lg">Print Membership Card</span>
									</a>
								</div>
								<div class="navi-item mb-2">
									<a href="javascript: ;" class="navi-link py-4" data-toggle="tooltip" title="Coming soon..." data-placement="right">
										<span class="navi-icon mr-2">
											<span class="svg-icon">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
														<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>
										</span>
										<span class="navi-text font-size-lg">User Preference</span>
									</a>
								</div>
							</div>
							<!--end::Nav-->
						</div>
						<!--end::Body-->
					</div>
					<!--end::Profile Card-->
				</div>
				<!--end::Aside-->
				<!--begin::Content-->
				<div class="flex-row-fluid ml-lg-8">
					<!--begin::Card-->
					<div class="card card-custom card-stretch">
						<!--begin::Header-->
						<div class="card-header py-3">
							<div class="card-title align-items-start flex-column">
								<h3 class="card-label font-weight-bolder text-dark">Member's Information</h3>
								<span class="text-muted font-weight-bold font-size-sm mt-1">Update member's informaiton</span>
							</div>
							<div class="card-toolbar">
								<a href="{{ route('admin.user.list') }}" class="btn btn-primary font-weight-bolder">
									<span class="svg-icon svg-icon-md">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24"/>
												<circle fill="#000000" cx="9" cy="15" r="6"/>
												<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"/>
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>Back to List
								</a>
							</div>
						</div>
						<!--end::Header-->
						<!--begin::Form-->
						<form class="form" method="POST" id="brij_user_update_form" action="{{ route('admin.user.edit.action', [encode_url( $editUserDetail[0]->id )]) }}" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<!--begin::Body-->
							<div class="card-body">
								<div class="row">
									<label class="col-xl-3"></label>
									<div class="col-lg-9 col-xl-6">
										<h5 class="font-weight-bold mb-6">Customer Info</h5>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Avatar</label>
									<div class="col-lg-9 col-xl-6">
										<div class="image-input image-input-outline image-input-changed" id="kt_profile_avatar" style="background-image: url('{{ Storage::disk('public')->url('userProfile/blank.png') }}')">
											<div class="image-input-wrapper" style="background-image: url('{{ $profileImg }}')"></div>
											<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
												<i class="fa fa-pen icon-sm text-muted"></i>
												<input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
												<input type="hidden" name="profile_avatar_remove" />
												<input type="hidden" name="old_profile_name" value="@if( $editUserDetail[0]->profile_img != '' ) {{ $editUserDetail[0]->profile_img }} @endif"/>
											</label>
											<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
												<i class="ki ki-bold-close icon-xs text-muted"></i>
											</span>
											<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
												<i class="ki ki-bold-close icon-xs text-muted"></i>
											</span>
										</div>
										<span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
									<div class="col-lg-9 col-xl-6">
										<input class="form-control form-control-lg form-control-solid" type="text" value="{{ $editUserDetail[0]->first_name }}" name="first_name" placeholder="First Name"/>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
									<div class="col-lg-9 col-xl-6">
										<input class="form-control form-control-lg form-control-solid" type="text" value="{{ $editUserDetail[0]->last_name }}" name="last_name" placeholder="Last Name"/>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Gender</label>
									<div class="col-lg-9 col-xl-6">
										<select name="gender" class="form-control form-control-lg form-control-solid rounded-lg font-size-h6">
											<option value="Male" selected >Male</option>
											<option value="Female" @if ( $editUserDetail[0]->gender == 'Female') selected @endif>Female</option>
										</select>
									</div>
								</div>
								<div class="row">
									<label class="col-xl-3"></label>
									<div class="col-lg-9 col-xl-6">
										<h5 class="font-weight-bold mt-10 mb-6">Contact Info</h5>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
									<div class="col-lg-9 col-xl-6">
										<div class="input-group input-group-lg input-group-solid">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="la la-phone"></i>
												</span>
											</div>
											<input type="text" class="form-control form-control-lg form-control-solid" value="{{ $editUserDetail[0]->phone }}" name="phone" placeholder="Phone" />
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
									<div class="col-lg-9 col-xl-6">
										<div class="input-group input-group-lg input-group-solid">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="la la-at"></i>
												</span>
											</div>
											<input type="text" class="form-control form-control-lg form-control-solid" value="{{ $editUserDetail[0]->email }}" name="email" placeholder="Email" />
										</div>
									</div>
								</div>
																
								<div class="row">
									<label class="col-xl-3"></label>
									<div class="col-lg-9 col-xl-6">
										<h5 class="font-weight-bold mt-10 mb-6">Address Info</h5>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Address</label>
									<div class="col-lg-9 col-xl-6">
										<input class="form-control form-control-lg form-control-solid" type="text" value="{{ $editUserDetail[0]->address }}" name="address" placeholder="Address" />
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">postcode</label>
									<div class="col-lg-9 col-xl-6">
										<input class="form-control form-control-lg form-control-solid" type="text" value="{{ $editUserDetail[0]->post_code }}" name="postcode" placeholder="Postcode"/>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Country of Residence</label>
									<div class="col-lg-9 col-xl-6">
										<select name="country" class="form-control form-control-lg form-control-solid rounded-lg font-size-h6">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->name }}" {{ $editUserDetail[0]->country == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
										</select>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Constituency</label>
									<div class="col-lg-9 col-xl-6">
										<select name="state" class="form-control form-control-lg form-control-solid rounded-lg font-size-h6">
                                            @foreach ($states as $state)
                                                <option value="{{ $state->name }}" {{ $editUserDetail[0]->state == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                            @endforeach
										</select>
									</div>
								</div>							
																
								<div class="row">
									<label class="col-xl-3"></label>
									<div class="col-lg-9 col-xl-6">
										<h5 class="font-weight-bold mt-10 mb-6">Membership Info</h5>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Select Chapter</label>
									<div class="col-lg-9 col-xl-6">
										<select name="chapter_from" class="form-control form-control-lg form-control-solid rounded-lg font-size-h6">
											<option value="">Select Chapter</option>
                                            @foreach ($chapterList as $chapter)
                                                <option value="{{ encode_url($chapter->id) }}" {{ $editUserDetail[0]->chapter == $chapter->id ? 'selected' : '' }}>{{ $chapter->chapter_name }}</option>
                                            @endforeach
										</select>
										<span class="form-text text-muted">If you get request to change Chapter, you can change this.</span>
									</div>
								</div>	
								
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Status</label>
									<div class="col-lg-9 col-xl-6">
										<select name="status_from" class="form-control form-control-lg form-control-solid rounded-lg font-size-h6">
                                            @foreach ($userStatus as $statusId => $status)
                                                <option value="{{ $statusId }}" {{ $editUserDetail[0]->status == $statusId ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
										</select>
									</div>
								</div>							
																
								<div class="row">
									<label class="col-xl-3"></label>
									<div class="col-lg-9 col-xl-6">
										<h5 class="font-weight-bold mt-10 mb-6">Payment Info</h5>
									</div>
								</div>
								@if ($editUserDetail[0]->user_type == 2 && sizeof($editUserDetail[0]->paymentDetails) > 0 )
									<div class="row">
										<label class="col-xl-3">Payment</label>
										<div class="col-lg-9 col-xl-6">
											<span>{{ $editUserDetail[0]->paymentDetails[0]->payment_currency }} {{ $editUserDetail[0]->paymentDetails[0]->payment_ammount }}</span>
										</div>
									</div>
								@else
									@if ($editUserDetail[0]->user_type == 1 &&  sizeof($editUserDetail[0]->paymentDetails) > 0)
										<div class="row">
											<label class="col-xl-3">Manual Payment</label>
											<div class="col-lg-9 col-xl-6">
												<span>{{ $editUserDetail[0]->paymentDetails[0]->payment_currency }} {{ $editUserDetail[0]->paymentDetails[0]->payment_ammount }}</span>
											</div>
										</div>
									@else
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Manual Currency</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control form-control-lg form-control-solid" type="text" value="" name="manual_currency" placeholder="USD"/>
											</div>
										</div>
									
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Manual Ammount</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control form-control-lg form-control-solid" type="text" value="" name="manual_ammount" placeholder="20"/>
											</div>
										</div>
									
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Manual Receipt</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control form-control-lg form-control-solid" type="text" value="" name="manual_receipt" placeholder="ABCD1234XYZ"/>
											<span class="form-text text-muted">Please add manual payment details for record.</span>
											</div>
										</div>
									@endif
								@endif
								
								<div class="form-group row">
									<button class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3" type="submit" id="user_update_form_submit_button">Update
									<span class="svg-icon svg-icon-md ml-2">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24" />
												<rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
												<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span></button>
								</div>
							</div>
							<!--end::Body-->
						</form>
						<!--end::Form-->
					</div>
				</div>
				<!--end::Content-->
			</div>
			<!--end::Profile Personal Information-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
{{-- Scripts Section --}}
@section('scripts')
<script>
	new KTImageInput('kt_profile_avatar');
</script>
@endsection
