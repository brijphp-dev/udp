@extends('layout.default')
@section('content')
<div class="card card-custom">
    @include('layout.messages')
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">System Roles
                <div class="text-muted pt-2 font-size-sm">Edit Role for more permission</div>
            </h3>
        </div>
        <div class="card-toolbar">
            
            @if (checkPermission([route('role.index')]))
            <a href="{{ route('role.index') }}" class="btn btn-primary font-weight-bolder">
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
        <form class="cmxform" data-form-id="role_add_form" id="role_add_form" method="POST" action="{{ route('role.edit.action', [$role['id']]) }}">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Role Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('bridgestone.role_name') is-invalid @enderror" id="role_name" name="bridgestone[role_name]" placeholder="Manager/ Company Manager" value="{{ $role['name'] }}" onblur="generateSlug(this)" required>
                    @error('bridgestone.role_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="display_name" class="col-sm-3 col-form-label">Slug</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('bridgestone.role_slug') is-invalid @enderror" id="role_slug" name="bridgestone[role_slug]" placeholder="manager/ company_manager" value="{{ $role['slug'] }}" required>
                    @error('bridgestone.role_slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                <label for="permission" class="col-sm-3 col-form-label">Select Permisssions</label>
                <div class="col-sm-9 list-group-item">
                    <input type="hidden" class="form-control  @error('udp.role_permission') is-invalid @enderror" >
                    @error('udp.role_permission')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="roles-treeview jstree">
                        @foreach ($modelsWithPermissions as $modelEach)
                        @if (count($modelEach->permissions) >= 1)
                        <ul class="list-group collapse show parent-ul" aria-expanded="true" data-master="{{ strtolower($modelEach->model) }}">
                            <li class="list-group-item-parent">
                                <i class="ki ki-solid-minus icon-md"></i>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input tw-control" data-parent="{{ strtolower($modelEach->model) }}">
                                        {{ $modelEach->model }}
                                    </label>
                                </div>
                                <ul class="fa-ul list-group collapse show" aria-expanded="true">
                                    @foreach ($modelEach->permissions as $permission )
                                    <li data-value="{{ $permission->permissions_name }}" class="list-group-item-inner child-li" data-group="1" data-relate="{{ strtolower($modelEach->model) }}">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input data-child="{{ strtolower($modelEach->model) }}" data-group="1" type="checkbox" data-treeview="true" name="bridgestone[role_permission][]" class="tw-control" data-value="{{ $permission->permissions_name }}" value="{{ $permission->permissions_name }}" @if (array_key_exists($permission->permissions_name, $role['permissions'] ))
                                                checked
                                                @endif>{{ $permission->display_name }}
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
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

@section('styles')
    <link href="{{ asset('plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .list-group-item-parent, .list-group-item-inner {
            position: relative;
            display: block;
            padding: 0.75rem 1.25rem;
            background-color: #ffffff;
            border: none;
        }
        .list-group-item-parent{
            border-bottom: 1px solid #EBEDF3;
        }
        .list-group:last-child > .list-group-item-parent{
            border: none;
        }
    </style>
@endsection

@section('scripts')
<script src="{{ asset('plugins/custom/jstree/jstree.bundle.js') }}"></script>
<script src="{{ asset('plugins/custom/treeview/treeview.js') }}"></script>
<!--end::Page Vendors-->

<script>
    $('.roles-treeview').treeview();
    $('#show-values').on('click', function() {
        $('#values').text(
            $('.roles-treeview').treeview('selectedValues')
        );
    });

    function generateSlug(getValue) {
        $.get('{{ route("role.slug.create") }}', {
                'title': $(getValue).val()
            },
            function(data) {
                $('#role_slug').val(data.slug);
            }
        );
    }
    $(document).ready(function() {

    });
    var validation_rules = {
        'udp[role_name]': {
            required: true,
            minlength: 3
        },
        'udp[group_id]': {
            required: true
        },
        'udp[role_slug]': {
            required: true
        },
        'udp[role_permission][]': {
            required: true
        }
    };
    var validation_messages = {
        'udp[role_name]': {
            required: "Please enter a Role name",
            minlength: "Name must consist of at least 3 characters"
        },
        'udp[group_id]': {
            required: "Please select group"
        },
        'udp[role_slug]': {
            required: "Please provide a Slug"
        },
        'udp[role_permission][]': {
            required: "Please select one Permission"
        }
    };
    //$('[data-form-id="role_add_form"]').formValidation(validation_rules, validation_messages);
    jQuery('#role_cancel').on('click', function(e) {
        e.preventDefault();
        jQuery('[data-form-id="role_add_form"]').resetForm('[data-form-id="role_add_form"]');
    });
</script>
@endsection
