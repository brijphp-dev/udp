{{-- Extends layout --}}
@extends('layout.front')

{{-- Style Section --}}
@section('styles')
    <link href="{{ asset('css/pages/login/login-3.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Content --}}
@section('content')
<!--begin::Wrapper-->
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid wizard" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-15 px-30">
                <!--begin::Aside header-->
                <a href="{{ url('/') }}" class="login-logo py-6">
                    <img src="{{ asset('media/logos/logo-1.png') }}" class="max-h-70px" alt="" />
                </a>
                <!--end::Aside header-->
                <!--begin: Wizard Nav-->
                <div class="wizard-nav pt-5 pt-lg-30">
                    <!--begin::Wizard Steps-->
                    <div class="wizard-steps">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">1</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">User Details</h3>
                                    <div class="wizard-desc">Provide Your Details</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">2</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Address Details</h3>
                                    <div class="wizard-desc">Residence Address</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 2 Nav-->
                        <!--begin::Wizard Step 3 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">3</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Member Type</h3>
                                    <div class="wizard-desc">Use Credit or Debit Cards</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 3 Nav-->
                        <!--begin::Wizard Step 4 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">4</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Completed!</h3>
                                    <div class="wizard-desc">Review and Submit</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 4 Nav-->
                    </div>
                    <!--end::Wizard Steps-->
                </div>
                <!--end: Wizard Nav-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            <div class="aside-img-wizard d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center pt-2 pt-lg-5" style="background-position-y: calc(100% + 3rem); background-image: url({{ asset('media/svg/illustrations/features.svg') }})"></div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-column-fluid d-flex flex-column p-10">
            <!--begin::Top-->
            <div class="text-right d-flex justify-content-center">
                <div class="top-signup text-right d-flex justify-content-end pt-5 pb-lg-0 pb-10">
                    <span class="font-weight-bold text-muted font-size-h4">Come here accidentally?</span>
                    <a href="{{ url('/') }}" class="font-weight-bolder text-primary font-size-h4 ml-2" id="kt_login_signup">Go back to UDP</a>
                </div>
            </div>
            @if(Session::has('successwithwarning'))
                <div class="alert alert-custom alert-notice alert-light-primary fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">{!! Session::get('successwithwarning') !!}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif

            @if(Session::has('success'))
                <div class="alert alert-custom alert-notice alert-light-success fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">{!! Session::get('success') !!}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif

            @if(Session::has('failed'))
                <div class="alert alert-custom alert-notice alert-light-warning fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">{!! Session::get('failed') !!}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">{!! Session::get('error') !!}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif
            <!--end::Top-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-row-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-form-signup">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_signup_form" method="POST" action="{{ route('user.registration.save') }}" enctype="multipart/form-data">
                        @csrf
                        <!--begin: Wizard Step 1-->
                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <!--begin::Errors-->
                            @if ($errors->any())
                                <div class="pb-10 pb-lg-5 fv-plugins-message-container">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="fv-help-block">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif                            
                            <!--begin::Errors-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="first_name" placeholder="First Name" value="{{ old('first_name') ? old('first_name') : 'brij123' }}" />
                                @error('first_name')
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">{{ $message }}</div>
                                </div>
                                @enderror
                            </div>
                            <!--end::Form Group-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="last_name" placeholder="Last Name" value="{{ old('last_name') ? old('last_name') : 'brij123' }}" />
                                @error('last_name')
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">{{ $message }}</div>
                                </div>
                                @enderror
                            </div>
                            <!--end::Form Group-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="phone" placeholder="phone" value="{{ old('phone') ? old('phone') : '+123456789' }}" max="15" />
                                <span class="form-text text-muted">With country code. eg. +1 xxx xxx xxxx</span>
                                @error('phone')
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">{{ $message }}</div>
                                </div>
                                @enderror
                            </div>
                            <!--end::Form Group-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="email" placeholder="Email" value="{{ old('email') ? old('email') : 'brij123@brij123.com' }}" />
                                @error('email')
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">{{ $message }}</div>
                                </div>
                                @enderror
                            </div>
                            <!--end::Form Group-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Gender</label>
                                <select name="gender" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <!--end::Form Group-->
                        </div>
                        <!--end: Wizard Step 1-->
                        <!--begin: Wizard Step 2-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Address Details</h3>
                                <div class="text-muted font-weight-bold font-size-h4">
                                    Provide your address for future use
                                </div>
                            </div>
                            <!--begin::Title-->
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Profile Image</label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div class="image-input image-input-outline" id="kt_user_add_avatar">
                                                <div class="image-input-wrapper" style="background-image: url({{ asset('media/users/blank.png') }})"></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Profile Image">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="profile_avatar_remove" />
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Profile Image">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Select-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Country of Residence</label>
                                        <select name="country" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->name }}" {{ old('country') == $country->name ? 'selected' : ( $country->name == 'The Gambia' ? 'selected' : '' ) }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Region</label>
                                        <select name="state" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            <option value="Banjul" selected>Banjul</option>
                                            <option value="Knifing">Knifing</option>
                                            <option value="Brikama">Brikama</option>
                                            <option value="Kerewan">Kerewan</option>
                                        </select>
                                        <span class="form-text text-muted">Only applicable when Country = The Gambia.</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Constituency</label>
                                        <select name="state" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            @foreach ($states as $state)
                                                <option value="{{ $state->name }}" {{ old('state') == $state->name ? 'selected' : '' }}>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted">Please enter your Constituency.</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Select-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Ward</label>
                                        <select name="ward" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            <option value="">Bakoteh</option>
                                            <option value="">Box Bar</option>
                                            <option value="">Campama</option>
                                        </select>
                                        <span class="form-text text-muted">Only applicable when Country = The Gambia.</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Select-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Polling Station</label>
                                        <select name="polling" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            <option value="">METHODIST PRI. SCH.( WESLEY ANNEX)</option>
                                            <option value="">WESLEY PRI.CH.</option>
                                            <option value="">ST. AUG. JNR. SEC. SCH.</option>
                                        </select>
                                        <span class="form-text text-muted">Only applicable when Country = The Gambia.</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="address" placeholder="Address" value="{{ old('address') ? old('address') : 'brij123' }}" />
                                        @error('address')
                                        <div class="fv-plugins-message-container">
                                            <div class="fv-help-block">{{ $message }}</div>
                                        </div>
                                        @enderror
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Postcode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="postcode" placeholder="Postcode" value="{{ old('postcode') ? old('postcode') : 'brij123' }}" />
                                        <span class="form-text text-muted">Required only when Country != The Gambia.</span>
                                        @error('postcode')
                                        <div class="fv-plugins-message-container">
                                            <div class="fv-help-block">{{ $message }}</div>
                                        </div>
                                        @enderror
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Select-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Select Chapter</label>
                                        <select name="chapter_from" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            <option value="">Select Chapter</option>
                                            @foreach ($chapterList as $chapter)
                                                <option value="{{ encode_url($chapter->id) }}" {{ old('chapter_from') == $chapter->chapter_name ? 'selected' : '' }}>{{ $chapter->chapter_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted">Not necessary, select only if applicable.</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Select-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Date of Birth</label>
                                        <input type="text" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="registration_dob" placeholder="MM/DD/YYYY" value="" id="registration_dob" />
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Select-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Ethnicity</label>
                                        <select name="chapter_from" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            <option value="">Select Ethnicity</option>
                                            <option value="">Mandinka</option>
                                            <option value="">Fulani</option>
                                            <option value="">Wolof</option>
                                            <option value="">Serahule</option>
                                            <option value="">Manjago</option>
                                            <option value="">Bambara</option>
                                            <option value="">Creole/Aku</option>
                                        </select>
                                        <span class="form-text text-muted">Not necessary, select only if applicable.</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Select-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">ID Card</label>
                                        <select name="chapter_from" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            <option value="">Select ID Card</option>
                                            <option value="">Birth Certificate</option>
                                            <option value="">Passport</option>
                                            <option value="">National ID Card</option>
                                        </select>
                                        <span class="form-text text-muted">Necessary only if Country = USA.</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Voter Registration# <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" name="voter_regNumber" placeholder="Voter Registration Number" value="" />
                                        @error('postcode')
                                        <div class="fv-plugins-message-container">
                                            <div class="fv-help-block">{{ $message }}</div>
                                        </div>
                                        @enderror
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Select-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Receive Emails?</label>
                                        <span class="switch switch-outline switch-icon switch-success">
                                            <label>
                                                <input type="checkbox" checked="checked" name="select" />
                                                <span></span>
                                            </label>
                                        </span>
                                        <span class="form-text text-muted">Select only if want to receive Emails</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Receive SMS</label>
                                        <span class="switch switch-outline switch-icon switch-primary">
                                            <label>
                                                <input type="checkbox" checked="checked" name="select" />
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end: Wizard Step 2-->
                        <!--begin: Wizard Step 3-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Support Channels</h3>
                                <div class="text-muted font-weight-bold font-size-h4">Your Support is needed</div>
                            </div>
                            <!--end::Title-->
                            <!--begin::Form Group-->
                            <div class="form-group m-0">
                                <label class="font-size-h6 font-weight-bolder text-dark">Chose Membership</label>
                                <div class="row">
                                    
                                 <div class="col-lg-6">
                                    <label class="option">
                                     <span class="option-control">
                                      <span class="radio">
                                       <input type="radio" name="membership_option" value="2" checked="checked"/>
                                       <span></span>
                                      </span>
                                     </span>
                                     <span class="option-label">
                                      <span class="option-head">
                                       <span class="option-title">
                                          Membership Fee
                                       </span>
                                       <span class="option-focus">
                                          <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Shopping\Euro.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                  <rect x="0" y="0" width="24" height="24"/>
                                                  <path d="M4.3618034,10.2763932 L4.8618034,9.2763932 C4.94649941,9.10700119 5.11963097,9 5.30901699,9 L15.190983,9 C15.4671254,9 15.690983,9.22385763 15.690983,9.5 C15.690983,9.57762255 15.6729105,9.65417908 15.6381966,9.7236068 L15.1381966,10.7236068 C15.0535006,10.8929988 14.880369,11 14.690983,11 L4.80901699,11 C4.53287462,11 4.30901699,10.7761424 4.30901699,10.5 C4.30901699,10.4223775 4.32708954,10.3458209 4.3618034,10.2763932 Z M14.6381966,13.7236068 L14.1381966,14.7236068 C14.0535006,14.8929988 13.880369,15 13.690983,15 L4.80901699,15 C4.53287462,15 4.30901699,14.7761424 4.30901699,14.5 C4.30901699,14.4223775 4.32708954,14.3458209 4.3618034,14.2763932 L4.8618034,13.2763932 C4.94649941,13.1070012 5.11963097,13 5.30901699,13 L14.190983,13 C14.4671254,13 14.690983,13.2238576 14.690983,13.5 C14.690983,13.5776225 14.6729105,13.6541791 14.6381966,13.7236068 Z" fill="#000000" opacity="0.3"/>
                                                  <path d="M17.369,7.618 C16.976998,7.08599734 16.4660031,6.69750122 15.836,6.4525 C15.2059968,6.20749878 14.590003,6.085 13.988,6.085 C13.2179962,6.085 12.5180032,6.2249986 11.888,6.505 C11.2579969,6.7850014 10.7155023,7.16999755 10.2605,7.66 C9.80549773,8.15000245 9.45550123,8.72399671 9.2105,9.382 C8.96549878,10.0400033 8.843,10.7539961 8.843,11.524 C8.843,12.3360041 8.96199881,13.0779966 9.2,13.75 C9.43800119,14.4220034 9.7774978,14.9994976 10.2185,15.4825 C10.6595022,15.9655024 11.1879969,16.3399987 11.804,16.606 C12.4200031,16.8720013 13.1129962,17.005 13.883,17.005 C14.681004,17.005 15.3879969,16.8475016 16.004,16.5325 C16.6200031,16.2174984 17.1169981,15.8010026 17.495,15.283 L19.616,16.774 C18.9579967,17.6000041 18.1530048,18.2404977 17.201,18.6955 C16.2489952,19.1505023 15.1360064,19.378 13.862,19.378 C12.6999942,19.378 11.6325049,19.1855019 10.6595,18.8005 C9.68649514,18.4154981 8.8500035,17.8765035 8.15,17.1835 C7.4499965,16.4904965 6.90400196,15.6645048 6.512,14.7055 C6.11999804,13.7464952 5.924,12.6860058 5.924,11.524 C5.924,10.333994 6.13049794,9.25950479 6.5435,8.3005 C6.95650207,7.34149521 7.5234964,6.52600336 8.2445,5.854 C8.96550361,5.18199664 9.8159951,4.66400182 10.796,4.3 C11.7760049,3.93599818 12.8399943,3.754 13.988,3.754 C14.4640024,3.754 14.9609974,3.79949954 15.479,3.8905 C15.9970026,3.98150045 16.4939976,4.12149906 16.97,4.3105 C17.4460024,4.49950095 17.8939979,4.7339986 18.314,5.014 C18.7340021,5.2940014 19.0909985,5.62999804 19.385,6.022 L17.369,7.618 Z" fill="#000000"/>
                                              </g>
                                          </svg><!--end::Svg Icon--></span>&nbsp;20.00
                                       </span>
                                      </span>
                                      <span class="option-body">
                                          All interested members are required to pay a membership fee on registration.
                                          <br>Payment Through Paypal <i class="icon-xl fab fa-paypal" style="color: #3699FF;"></i>
                                      </span>
                                     </span>
                                    </label>
                                   </div>
                                 <div class="col-lg-6">
                                  <label class="option">
                                   <span class="option-control">
                                    <span class="radio">
                                     <input type="radio" name="membership_option" value="1"/>
                                     <span></span>
                                    </span>
                                   </span>
                                   <span class="option-label">
                                    <span class="option-head">
                                     <span class="option-title">
                                        Already Paid/ Will Pay Later
                                     </span>
                                    </span>
                                    <span class="option-body">
                                        If you have already paid or will pay later to our own account.(Without verification of your payment we are unable to process your card)
                                    </span>
                                   </span>
                                  </label>
                                 </div>
                                </div>
                               </div>
                            <!--end::Form Group-->
                        </div>
                        <!--end: Wizard Step 3-->
                        <!--begin: Wizard Step 4-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Complete Your Signup And Become A Member!</h3>
                                <div class="text-muted font-weight-bold font-size-h4">Please make sure your details are right before you confirm </div>
                            </div>
                            <!--end::Title-->
                            <div id="member_preview_section"></div>
                        </div>
                        <!--end: Wizard Step 4-->
                        <!--begin: Wizard Actions-->
                        <div class="d-flex justify-content-between pt-3">
                            <div class="mr-2">
                                <button type="button" class="btn btn-light-primary font-weight-bolder font-size-h6 pl-6 pr-8 py-4 my-3 mr-3" data-wizard-type="action-prev">
                                <span class="svg-icon svg-icon-md mr-1">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1" />
                                            <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Previous</button>
                            </div>
                            <div>
                                <button class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3" data-wizard-type="action-submit" type="submit" id="kt_login_signup_form_submit_button">Submit
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
                                <button type="button" class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3" data-wizard-type="action-next">Next Step
                                <span class="svg-icon svg-icon-md ml-1">
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
                        <!--end: Wizard Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
<!--end::Wrapper-->
@endsection

{{-- Scripts Section --}}
@section('scripts')
<script src="{{ asset('js/pages/custom/login/login-3.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            'use strict';
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }
            $('#registration_dob').datepicker({
                rtl: KTUtil.isRTL(),
                clearBtn: true,
                todayHighlight: true,
                autoclose: true,
                templates: arrows
            });
        });
    </script>
@endsection