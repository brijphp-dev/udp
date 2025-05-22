{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
<div class="card card-custom">
  	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">Voters List
				<div class="text-muted pt-2 font-size-sm">List of Voters</div>
			</h3>
		</div>
      <div class="card-toolbar">
          <!--begin::Button-->
          <a href="{{ route('voter.create.form') }}" class="btn btn-primary font-weight-bolder mr-4">
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
          </span>Add Voter</a>
          <!--end::Button-->
          <!-- Button trigger modal-->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#voterModalpopup">
            <i class="fa flaticon2-plus icon-1x"></i>Bulk upload Voters
          </button>
          <!-- Modal-->
            <div class="modal fade" id="voterModalpopup" tabindex="-1" aria-labelledby="voterModalLabel" aria-hidden="true" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="voterModalLabel">Upload Voter's sheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form id="votersheet_uploadForm" name="contact" role="form" method="POST" data-action="{{ route('voter.bulk.voter') }}" action="{{ route('voter.bulk.voter') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                      <div class="message-wrap mt-1" id="message-wrap" style="display:none;"></div>
                      <div class="form-group">
                        <label for="title-name" class="col-form-label">Voter sheet upload will check first befor upload, this may take some time to show your uploaded voters in list</label>
                      </div>
                      <div class="form-group">
                        <label for="voter_input_control" class="col-form-label">Upload Voter sheet:</label>
                        <div class="voter-wrapper">
                          <div class="voter-fileinput-container">
                            <input class="voter-fileinput-input voter-input-control" style="" type="file" name="voter_sheet" id="voter_input_control">
                            <label class="voter-input-label btn btn-light-primary btn-sm btn-bold" for="voter_input_control" id="voter_input_label">Attach file</label>
                            <span id="voter_input_name_span" class="file-upload-info"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Upload Sheet</button>
                    </div>
                  </form>
                  
                  {{-- <form id="citysheet_uploadForm" name="contact" role="form" method="POST" data-action="{{ route('voter.bulk.city') }}" action="{{ route('voter.bulk.city') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                      <div class="message-wrap mt-1" id="message-wrap" style="display:none;"></div>
                      <div class="form-group">
                        <label for="title-name" class="col-form-label">This section is only to upload City and Region, Please do not keep this Open. Close it after you done your work</label>
                      </div>
                      <div class="form-group">
                        <label for="city_input_control" class="col-form-label">Upload City and Region sheet:</label>
                        <div class="voter-wrapper">
                          <div class="voter-fileinput-container">
                            <input class="voter-fileinput-input voter-input-control" style="" type="file" name="city_sheet" id="city_input_control">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Upload city Sheet</button>
                    </div>
                  </form> --}}
                </div>
              </div>
            </div>
      </div>
  </div>

  <div class="card-body">
        <div class="table-responsive">
          <table id="voter_list" class="table">
            <thead>
              <tr>
				  <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Ward</th>
                <th>Polling Station</th>
                <th>Constituency</th>
                <th>Region</th>
                <th>Action</th>
              </tr>
            </thead>

          </table>
        </div>
      </div>
    </div>
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
        .voter-fileinput-container #voter_input_control {
          opacity: 0;
          z-index: 1;
          position: relative;
          height: 0;
          width: 0;
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
    $("#voter_input_label").click(function(){
      $("#voter_input_control").click();
    });
    document.querySelector('#voter_input_control').addEventListener('change', function(e) {
      document.getElementById("voter_input_name_span").innerText = '';
      if (document.getElementById("voter_input_control").files[0] != undefined) {
        var fileName = document.getElementById("voter_input_control").files[0].name;console.log(fileName, document.getElementById("voter_input_name_span"));
        document.getElementById("voter_input_name_span").innerText = fileName
      }
    });
    $("#votersheet_uploadForm").submit(function(event){
      var formdata = new FormData(this);
      $.ajax({
                type: "POST",
                url: $(this).attr("data-action"),
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.error) {
                        $('#message-wrap').html(data.messageHtml);
                        $('#message-wrap').show();

                    } else {
                      $("#votersheet_uploadForm")[0].reset();
                      document.getElementById("voter_input_name_span").innerText = '';
                      $('#voterModalpopup').modal('hide');
                    }
                    return false;
                },
                error: function(data) {
                    showTostAlert(data.responseJSON.error);
                }
            });
      return false;
    });

    $('#voter_list').DataTable({
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
       url: "{{route('voter.index')}}",
       type: 'POST',
       headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
      },
      columns: [
        { data: 'DT_RowIndex', name: 'id'},/*  */
        { data: 'userName', name: 'userName' },
        { data: 'userEmail', name: 'userEmail' },
        { data: 'userPhone', name: 'userPhone' },
        { data: 'userWard', name: 'userWard', },
        { data: 'userPolling', name: 'userPolling', },
        { data: 'userConstituency', name: 'userConstituency' },
        { data: 'userState', name: 'userState' },
        { data: 'action', name: 'action', orderable: false, searchable: false },

     ],
     "drawCallback": function( settings ) {},
      order: [[0, 'asc']]
    });
    $('#user_list').each(function() {
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


});
</script>
@endsection

