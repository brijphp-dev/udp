{{-- Extends layout --}}
@extends('layout.admindefault')

{{-- Style Section --}}
@section('styles')
    <link href="{{ asset('css/pages/login/login-3.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <!--begin::Aside header-->
                <a href="#" class="login-logo text-center pt-lg-25 pb-10">
                    <img src="{{ asset('media/logos/logo-1.png') }}" class="max-h-70px" alt="" />
                </a>
                <!--end::Aside header-->
                <!--begin::Aside Title-->
                <h3 class="font-weight-bolder text-center font-size-h4 text-dark-50 line-height-xl">United Democratic Party
                <br />The Gambia</h3>
                <!--end::Aside Title-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center" style="background-position-y: calc(100% + 5rem); background-image: url({{ asset('media/svg/illustrations/login-visual-5.svg') }})"></div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column p-10">
            <!--begin::Top-->
            {{-- <div class="text-right d-flex justify-content-center">
                <div class="top-signin text-right d-flex justify-content-end pt-5 pb-lg-0 pb-10">
                    <span class="font-weight-bold text-muted font-size-h4">Having issues?</span>
                    <a href="javascript:;" class="font-weight-bold text-primary font-size-h4 ml-2" id="kt_login_signup">Get Help</a>
                </div>
            </div> --}}
            <!--end::Top-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-row-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form">
                    
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
                    <!--begin::Form-->
                    <form class="form" id="kt_login_singin_form" action="{{ route('admin.user.login.save') }}" method="POST">
                        @csrf
                        <!--begin::Title-->
                        <div class="pb-5 pb-lg-10">
                            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h3>
                            {{-- <div class="text-muted font-weight-bold font-size-h4">New Here?
                            <a href="javascript:void(0);" class="text-primary font-weight-bolder">Create Account</a></div> --}}
                        </div>
                        <!--begin::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Your Email</label>
                            <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="text" name="username" autocomplete="off" value="{{ old('username') ? old('username') : 'super@admin.com' }}" />
                            @error('username')
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                {{-- <a href="custom/pages/login/login-3/forgot.html" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot Password ?</a> --}}
                            </div>
                            <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" value="Sup@r!123" autocomplete="off" />
                            @error('password')
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                        <!--end::Form group-->
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
                        </div>
                        <!--end::Action-->
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
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/custom/login/login-3.js') }}" type="text/javascript"></script>
    <script>
        
    </script>
@endsection