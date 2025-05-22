{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Create New Chapter
                <div class="text-muted pt-2 font-size-sm">Open a new Chepter</div>
            </h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('chapter.index') }}" class="btn btn-primary font-weight-bolder">
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
    <div class="card-body">
        <form class="form" novalidate="novalidate" id="udp_chapter_add" method="POST" action="{{ route('chapter.create.action') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="col-lg-12">Create Chapter <span class="text-danger">*</span></label>
                <div class="col-lg-12 col-md-9 col-sm-12">
                    <input type="text" class="form-control font-size-h6" name="chapter_name" placeholder="Chapter *" value="{{ old('chapter_name') ? old('chapter_name') : '' }}" required/>
                    @error('chapter_name')
                    <div class="fv-plugins-message-container">
                        <div class="fv-help-block">{{ $message }}</div>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <button class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3" type="submit" id="chapter_form_submit_button">Submit
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

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}

    <script>
        jQuery(document).ready(function() {
            var chapterForm = document.getElementById('udp_chapter_add');            
		    var formSubmitButton = document.getElementById('chapter_form_submit_button');
            var chapterValidat = FormValidation.formValidation(chapterForm, {
                fields: {
                    chapter_name: {
                        validators: {
                            notEmpty: {
                                message: 'Chapter is required'
                            }
                        }
                    },
                },
                plugins: { //Learn more: https://formvalidation.io/guide/plugins
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                        //eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                    }),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
				}
            });
            /*jQuery("#chapter_form_submit_button").on('click', function(e){
                e.preventDefault();
                console.log(chapterValidat);
                return false;
                if(chapterValidat){
                    chapterValidat.validate().then(function (status) {
                        chapterForm.submit();
                    });
                }
            });*/
            
        });
    </script>
@endsection