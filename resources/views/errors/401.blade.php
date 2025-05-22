@extends('layout.default')

@section('styles')
<style>
    .display-4 {font-size: 2rem !important;}
    .error.error-4{min-height: 450px}
    .error.error-4 .error-title{font-size:3.3rem!important}
    .error.error-4 .error-subtitle{font-size:2.7rem!important}
    @media (min-width:768px){
        .display-4 {font-size: 1.8rem !important;}
        .error.error-4{min-height: 600px}
        .error.error-4 .error-title{font-size:7rem!important}
        .error.error-4 .error-subtitle{font-size:5.5rem!important}
    }
</style>
@endsection

@section('content')
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Error-->
    <div class="error error-4 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url( {{ asset('media/error/bg4.jpg') }});">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-row-fluid align-items-center align-items-md-start justify-content-md-center text-center text-md-left px-10 px-md-30 py-10 py-md-0 line-height-xs">
            <h1 class="error-title text-success font-weight-boldest line-height-sm">Unauthorized!</h1>
            <p class="error-subtitle text-success font-weight-boldest mb-10">Access</p>
            <p class="display-4 text-danger font-weight-boldest mt-md-0 line-height-md">@lang('userMessages.access_denie_page')</p>
        </div>
        <!--end::Content-->
    </div>
    <!-- <img src="{{ asset('media/logos/404.svg') }}" class="img-fluid mb-2" alt="404"> -->
    <!--end::Error-->
</div>
<!--end::Main-->
@endsection
