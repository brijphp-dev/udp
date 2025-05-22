@extends('layout.master')

@push('plugin-styles')
{!! Html::style('/assets/plugins/prismjs/prism.css') !!}
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <nav class="page-breadcrumb mb-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bridgestone</a></li>
            <li class="breadcrumb-item"><a href="#">Profile</a></li>
        </ol>
    </nav>
    <div class="font-weight-bold">
        <span>{{ __('System date : ')}} {{getSystemDate()}}</span>
    </div>
</div>
<div class="row">
    @include('layout.messages')
    <div class="col-md-6 col-lg-5  col-xl-4 grid-margin stretch-card justify-content-between profile-wrap">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center w-100 mb-4">
                    <h6 class="card-title mb-0">Profile</h6>
                </div>
                <div class="mt-3 bd-b pb-2 ">
                    <i class="mdi mdi-face-profile mr-2"></i>
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Name:</label>
                    <span class="text-muted">{{$user->first_name}} {{$user->last_name}} </span>
                </div>
                <div class="mt-3 bd-b pb-2">
                    <i class="mdi mdi-city  mr-2"></i>
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Company:</label>
                    <span class="text-muted">{{$user->company->display_name}} </span>
                </div>
                <div class="mt-3 bd-b pb-2">
                    <i class="mdi mdi-email mr-2"></i>
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                    <span class="text-muted">{{$user->email}} </span>
                </div>
                <div class="mt-3 ">
                    <i class="mdi mdi-account-key mr-2"></i>
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Role:</label>
                    <span class="text-muted">{{$user->roles[0]->name}} </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
{!! Html::script('/assets/plugins/prismjs/prism.js') !!}
{!! Html::script('/assets/plugins/clipboard/clipboard.min.js') !!}
@endpush