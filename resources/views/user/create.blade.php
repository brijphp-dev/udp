@extends('layout.default')
@section('styles')
    
@endsection
@section('content')
<div class="card card-custom">
    @include('layout.messages')
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Create New System User
                <div class="text-muted pt-2 font-size-sm">New System User</div>
            </h3>
        </div>
        <div class="card-toolbar">
            
            @if (checkPermission([route('systemuser.index')]))
            <a href="{{ route('systemuser.index')  }}" class="btn btn-primary btn-icon-text" role="button" aria-pressed="true"> View System user</a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center w-100 mb-4">
            <h6 class="card-title mb-0">Add a new user</h6>
        </div>
        <form class="cmxform" id="user_form" data-form-id="user_add_form" method="POST" action="{{ route('systemuser.create.action') }}">
            @csrf
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{old('first_name')}}" placeholder="First Name" minlength="3" maxlength="255" >
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
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{old('last_name')}}" name="last_name" placeholder="Last Name" minlength="3" maxlength="255" >
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
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" value="{{old('email')}}" name="email" placeholder="Email Address" >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" value="{{old('password')}}" name="password" placeholder="Password" >
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row" id="role_group">
                <label for="role_id" class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-9">
                    <select id="role_id" class="form-control @error('role_id') is-invalid @enderror" name="role_id" >
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                        <option value="{{ encode_url($chapter->id) }}">{{ $chapter->chapter_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="btn-wrap mt-4">
                <button type="submit" class="btn btn-primary-2 mr-2">Save user</button>
                <button class="btn btn-light" id="user_cancel">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        /*$('select[name=group_id]').change(function() {
            $('select[name=branch_id]').val('');
            $("#salescompany_group").hide();
            $("#company_group").hide();
            $("#role_group").hide();
            $('#branch_group').hide();
            var group_id = $(this).val();
            if (group_id != '') {
                $.get('/', {
                        'group': group_id
                    },
                    function(data) {
                        var select = $('form select[name= role_id]');
                        select.find('option').remove();
                        select.append('<option value="">Select Role</option>');
                        $.each(data, function(key, value) {
                            select.append('<option value=' + value.id + '>' + value.name + '</option>');
                        });

                        $("#role_group").show();
                    }
                );
                if (group_id == 3) {
                    $.get('/', {
                            'group': group_id
                        },
                        function(data) {
                            var select = $('form select[name= company_id]');
                            select.empty();
                            select.append('<option value="">Select Company</option>');
                            $.each(data, function(key, value) {
                                select.append('<option value=' + value.id + '>' + value.display_name + '</option>');
                            });
                            $("#company_group").show();
                        }
                    );
                }
                if (group_id == 2) {
                    $('#branch_group').show();
                }
            }
        });*/


    });
</script>
@endsection
