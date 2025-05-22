{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Chapters List
                    <div class="text-muted pt-2 font-size-sm">List of Chapters</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('chapter.create.form') }}" class="btn btn-primary font-weight-bolder">
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
                    </span>New Record
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(Session::has('success'))
                <div class="alert alert-custom alert-notice alert-light-success fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
                    <div class="alert-text">{!! Session::get('success') !!}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif
            <table class="table table-bordered table-hover" id="chapter_datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>

        </div>

    </div>

@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .table-hover tbody tr:hover .checkbox > span {
            background-color: #fff;
        }
        .table-hover tbody tr:hover .checkbox > input:checked ~ span {
            background-color: #3699FF;
        }
    </style>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            'use strict';
            var myUserDatatable = $('#chapter_datatable').DataTable({
                "aLengthMenu": [
                    [10, 20, 30, -1],
                    [10, 20, 30, "All"]
                ],
                "iDisplayLength": 10,
                "language": {
                    search: ""
                },
                ordering: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('chapter.index')}}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id'},
                    { data: 'chapter_name', name: 'chapter_name', orderable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },

                ],
                "drawCallback": function( settings ) {
                    //feather.replace();
                },
                order: [],                
                responsive: true,
                // DOM Layout settings
                dom: `<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-10 dataTables_pager'p>><'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'p>>`,
                language: {
                    'lengthMenu': 'Display _MENU_',
                },
                /*headerCallback: function(thead, data, start, end, display) {
                    thead.getElementsByTagName('th')[0].innerHTML = `
                        <label class="checkbox checkbox-single">
                            <input type="checkbox" value="All" class="group-checkable"/>
                            <span></span>
                        </label>`;
                },*/
            });
        });
    </script>
@endsection
