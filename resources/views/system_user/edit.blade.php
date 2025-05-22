{{-- Extends layout --}}
@extends('layout.default')

@section('content')
<div class="card card-custom">
    @include('layout.messages')
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Edit System User
                <div class="text-muted pt-2 font-size-sm">System User Changes</div>
            </h3>
        </div>
        <div class="card-toolbar">
            
            @if (checkPermission([route('systemuser.index')]))
            <a href="{{ route('systemuser.index') }}" class="btn btn-primary font-weight-bolder">
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
            @endif
        </div>
    </div>
    <div class="card-body">
        <form class="cmxform" id="user_form" data-form-id="user_add_form" method="POST" action="{{ route('systemuser.edit.action',[encode_url( $editUserDetail[0]->id )] ) }}">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ $editUserDetail[0]->first_name}}" placeholder="First Name" minlength="3" maxlength="255"  required>
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                    <div class="col-sm-9">
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"  value="{{ $editUserDetail[0]->last_name}}" name="last_name" placeholder="Last Name" minlength="3" maxlength="255"  required>
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"  value="{{ $editUserDetail[0]->email}}" name="email" placeholder="Email Address" required readonly>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
            <div class="form-group row" id="role_group" >
                <label for="role_id" class="col-sm-3 col-form-label">Role</label>
                    <div class="col-sm-9">
                    <select id="role_id" class="form-control @error('role_id') is-invalid @enderror"  name="role_id" required>
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{$editUserDetail[0]->role[0]->pivot->role_id == $role->id? 'selected' : ''}} >{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
            </div>
            <div class="form-group row" id="branch_group">
                <label for="chapter_from" class="col-sm-3 col-form-label">Chapter</label>
                <div class="col-sm-9">
                    <select id="chapter_from" class="form-control @error('chapter_from') is-invalid @enderror" name="chapter_from">
                        <option value="">Select Chapter</option>
                        @foreach ($chapters as $chapter)
                        <option value="{{ encode_url($chapter->id) }}" {{$editUserDetail[0]->chapter == $chapter->id? 'selected' : ''}} >{{ $chapter->chapter_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if($canEditPassword)
                <div class="form-group row" id="company_group">
                    <label for="company_id" class="col-sm-3 col-form-label">Change Password</label>
                    <div class="col-sm-9 input-group">
                        <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password" data-field="new_password">
                    </div>
                </div>
            @endif
            <div class="form-group row">
                <button class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3" type="submit" id="chapter_form_submit_button">Update
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
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
    });
</script>
@endsection
