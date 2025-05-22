@extends('layout.default')
@section('styles')
    
@endsection
@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    @include('layout.messages')
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Create New Voter
                <div class="text-muted pt-2 font-size-sm">New Voter</div>
            </h3>
        </div>
        <div class="card-toolbar">
            
            @if (checkPermission([route('systemuser.index')]))
            <a href="{{ route('systemuser.index')  }}" class="btn btn-light-primary btn-icon-text font-weight-bolder mr-2" role="button" aria-pressed="true"> <i class="ki ki-long-arrow-back icon-sm"></i> Back to Voter's list</a>
            @endif
            <button type="button" class="btn btn-primary font-weight-bolder" id="submit_voter_button">
                <i class="ki ki-check icon-sm"></i>Add Voter</button>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center w-100 mb-4">
            <h6 class="card-title mb-0">Add a new Voter</h6>
        </div>
        <form class="cmxform" id="voter_add_form" data-form-id="voter_add_form" method="POST" action="{{ route('voter.create.action') }}">
            @csrf
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">First Name <span class="text-danger">*</span></label>
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
                <label for="last_name" class="col-sm-3 col-form-label">Last Name <span class="text-danger">*</span></label>
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
                <label for="phone" class="col-sm-3 col-form-label">Phone <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{old('phone')}}" name="phone" placeholder="phone" >
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row" id="role_group">
                <label for="polling_ward" class="col-sm-3 col-form-label">Polling Ward <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="polling_ward" class="form-control mb-2 @error('polling_ward') is-invalid @enderror" name="polling_ward" >
                        <option value="">Select Ward</option>
                        @foreach ($wards as $ward)
                        <option value="{{ $ward->id }}" {{ (old('polling_ward') == $ward->id )? 'selected' : '' }} >{{ $ward->name }}</option>
                        @endforeach
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" class="form-control" id="wardother" value="" name="wardother" placeholder="Specify Polling ward name if not in list" >
                    @error('polling_ward')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    @error('wardother')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="poll_station" class="col-sm-3 col-form-label">Polling Station <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('poll_station') is-invalid @enderror" id="poll_station" value="{{old('poll_station')}}" name="poll_station" placeholder="Polling Station" minlength="3" maxlength="255" >
                    @error('poll_station')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" value="{{old('address')}}" name="address" placeholder="Address" minlength="3" maxlength="255" >
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="city_from" class="col-sm-3 col-form-label">City <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="city_from" class="form-control mb-2 @error('city_from') is-invalid @enderror" name="city_from">
                        <option value="">Select City</option>
                        @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ (old('city_from') == $city->id )? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" class="form-control" id="cityother" value="" name="cityother" placeholder="Specify City name if not in list" > 
                    @error('city_from')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="region" class="col-sm-3 col-form-label">Region <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="region" class="form-control mb-2 @error('region') is-invalid @enderror" name="region">
                        <option value="">Select Region</option>
                        @foreach ($regions as $region)
                        <option value="{{ $region->id }}" {{ (old('region') == $region->id )? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" class="form-control" id="regionother" value="" name="regionother" placeholder="Specify Region name if not in list" >
                    @error('region')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="constitute" class="col-sm-3 col-form-label">Constituency <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('constitute') is-invalid @enderror" id="constitute" value="{{old('constitute')}}" name="constitute" placeholder="Constituency" minlength="3" maxlength="255" >
                    @error('constitute')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="select_state" class="col-sm-3 col-form-label">State / Village<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="select_state" class="form-control mb-2 @error('select_state') is-invalid @enderror" name="select_state">
                        <option value="">Select State / Village</option>
                        @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ (old('select_state') == $state->id )? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" class="form-control" id="stateother" value="" name="stateother" placeholder="Specify State / Village name if not in list" >
                    @error('select_state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="postcode" class="col-sm-3 col-form-label">Postcode</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('postcode') is-invalid @enderror" id="postcode" value="{{old('postcode')}}" name="postcode" placeholder="Postcode" minlength="3" maxlength="255" >
                    @error('postcode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-9">
                    <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender">
                        <option value="Male" selected>Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="ethnicity" class="col-sm-3 col-form-label">Ethnicity <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select id="ethnicity" class="form-control mb-2 @error('ethnicity') is-invalid @enderror" name="ethnicity">
                        <option value="">Select Ethnicity</option>
                        @foreach ($ethnicities as $ethnicity)
                        <option value="{{ $ethnicity->id }}" {{ (old('ethnicity') == $ethnicity->id )? 'selected' : '' }}>{{ $ethnicity->ename }}</option>
                        @endforeach
                    </select>
                    @error('ethnicity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="voter_id" class="col-sm-3 col-form-label">VoterID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('voter_id') is-invalid @enderror" id="voter_id" value="{{old('voter_id')}}" name="voter_id" placeholder="VoterID" minlength="3" maxlength="255" >
                    @error('voter_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        
        $('#submit_voter_button').click( function() {console.log('call');
            $('form#voter_add_form').submit();
        });
    });
    var validation_rules = {
        'first_name': {
            required: true
        },
        'last_name': {
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
        'first_name': {
            required: "Please enter a first name"
        },
        'last_name': {
            required: "Please enter a last name"
        },
        'udp[role_slug]': {
            required: "Please provide a Slug"
        },
        'udp[role_permission][]': {
            required: "Please select one Permission"
        }
    };
    //$('[data-form-id="voter_add_form"]').formValidation(validation_rules, validation_messages);
    jQuery('#role_cancel').on('click', function(e) {
        e.preventDefault();
        jQuery('[data-form-id="role_add_form"]').resetForm('[data-form-id="role_add_form"]');
    });
</script>
@endsection
