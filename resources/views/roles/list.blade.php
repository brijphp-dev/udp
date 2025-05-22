@extends('layout.default')
@section('styles')
  <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">Roles List
				<div class="text-muted pt-2 font-size-sm">List of Role</div>
			</h3>
		</div>
		<div class="card-toolbar">
			<a href="{{ route('role.create.form') }}" class="btn btn-primary font-weight-bolder">
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
				</span>Add New Role
			</a>
		</div>
	</div>

	<div class="card-body">
		@if(Session::has('success'))
			<div class="alert alert-custom alert-notice alert-light-success fade show" role="alert">
				<div class="alert-icon"><i class="flaticon-warning"></i></div>
				<div class="alert-text">{!! Session::get('success') !!}</div>
				<div class="alert-close">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true"><i class="ki ki-close"></i></span>
					</button>
				</div>
			</div>
		@endif
		<table class="table table-bordered table-hover" id="role_list">
			<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Slug</th>
				<th>Actions</th>
			</tr>
			</thead>
		</table>

	</div>

</div>
@endsection

@section('scripts')
{{-- vendors --}}
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$('#role_list').DataTable({
      "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
      ],
      "iDisplayLength": 10,
      "language": {
        search: ""
      },
      processing: true,
      serverSide: true,
      ajax: {
       url: "{{route('role.index')}}",
       type: 'POST',
       headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
      },
      columns: [
            { data: 'DT_RowIndex', name: 'id'},
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        "drawCallback": function( settings ) {},
      	order: [[0, 'asc']]
    });
    $('#role_list').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      search_input.addClass('search-icon-bg');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });

  </script>
@endsection