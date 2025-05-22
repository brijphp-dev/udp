{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Send Mail Notification
                <div class="text-muted pt-2 font-size-sm">Let the members know new things</div>
            </h3>
        </div>
    </div>
    <div class="card-body">
        <form class="form" novalidate="novalidate" id="kt_mail_send_form" method="POST" action="{{ route('admin.mail.notification.send') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="col-lg-12">Select User to send Mail <span class="text-danger">*</span></label>
                <div class="col-lg-12 col-md-9 col-sm-12">
                    <select class="form-control select2 font-size-h6" id="brij_kt_select2_3" name="useremails[]" multiple="multiple">
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-12">Mail Subject <span class="text-danger">*</span></label>
                <div class="col-lg-12 col-md-9 col-sm-12">
                    <input type="text" class="form-control font-size-h6" name="adminemail_subject" placeholder="Mail Subject *" value="{{ old('adminemail_subject') ? old('adminemail_subject') : '' }}" />
                </div>
            </div>
            <div class="form-group ">
                <label class="col-lg-12">Email Content <span class="text-danger">*</span></label>
                <div class="col-lg-12 col-md-9 col-sm-12">
                    <textarea id="kt-tinymce-4" name="adminemail_content" class="tox-target"></textarea>
                </div>
            </div>
            <div class="form-group row">
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
    <script src="{{ asset('js/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/custom/tinymce/tinymce.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/crud/forms/editors/tinymce.js') }}" type="text/javascript"></script>

    <script>
        var KTTinymce = function () {
            // Private functions
            var demos = function () {
                tinymce.init({
                    selector: '#kt-tinymce-4',
                    menubar: false,
                    toolbar: ['styleselect fontselect fontsizeselect',
                        'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
                        'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],
                    plugins : 'advlist autolink link image lists charmap print preview code'
                });
            }

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();


        jQuery(document).ready(function() {
            var data = {!! $emailUserLists !!};

            $("#brij_kt_select2_3").select2({
                data: data,
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: function(data) {
                    return data.htmlMarkup;
                },
                templateSelection: function(data) {
                    return data.text;
                }
            });
            KTTinymce.init();
        });
    </script>
@endsection