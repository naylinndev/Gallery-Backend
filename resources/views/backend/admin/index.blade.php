@extends('backend.layout')
@section('meta')
<meta content="{{ csrf_token() }}" name="csrf-token"/>
@endsection
@section('breadcrump')
<div class="page-header">
    <div class="row">
        <div class="col-xl-6">
            <h1 class="page-title">
                Accounts
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="{{url('dashboard')}}">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Accounts
                </li>
            </ol>
        </div>
        <div class="col-xl-6 text-right">
            <button class="btn btn-primary waves-effect waves-light" id="quick-add" type="button">
                <i aria-hidden="true" class="icon md-plus">
                </i>
                Add
            </button>
        </div>
    </div>
</div>
@endsection

@section('before-styles')
<style type="text/css">
    .control-label {
    padding-top: 7px;
    margin-bottom: 0;
    text-align: right;
}

.form-group{
  margin-bottom: 0px !important;
}

span.select2-container {
  z-index: 10050;
}

.panel-body{
  padding-top: 10px !important;
}
</style>
@endsection
@section('content')
<div class="page-content">
    <!-- Panel Basic -->
    <!-- Page -->
    <div aria-hidden="true" aria-labelledby="confirmModelLabel" class="modal fade" id="confirmModel" role="dialog" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                        ×
                    </button>
                    <h4 class="modal-title" id="confirmModelLabel">
                        Confirmation
                    </h4>
                </div>
                <div class="modal-body">
                    <span>
                        Are you sure to delete this record?
                    </span>
                    <input id="hid-delete-id" name="hid-id" type="hidden" value=""/>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">
                        No
                    </button>
                    <button class="btn btn-primary" id="btn-confirm-yes" type="button">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
         <div aria-hidden="true" data-backdrop="static" data-keyboard="false"  aria-labelledby="confirmModelLabel" class="modal fade" id="resetPasswordModel" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                            ×
                        </button>
                        <h4 class="modal-title" id="confirmModelLabel">
                            Confirmation
                        </h4>
                    </div>
                    <div class="modal-body">
                        <span>
                            Are you sure to reset password this record?
                        </span>
                        <input id="hid-activate-id" name="hid-id" type="hidden" value=""/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" type="button">
                            No
                        </button>
                        <button class="btn btn-primary" id="btn-reset-confirm-yes" type="button">
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal -->
    <div aria-hidden="false" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" class="modal fade" id="quickModal" role="dialog" style="padding-left: 0px;" >
        <div class="modal-dialog modal-md">
            <input id="submiturl" name="submiturl" type="hidden" value="">
                <form class="modal-content" enctype="multipart/form-data" id="quick-form" role="form">
                    <div class="alert dark alert-danger alert-dismissible err-display" role="alert" style="display: none;">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">
                                x
                            </span>
                        </button>
                    </div>
                    @csrf
                    <input id="admin" name="admin" type="hidden" value="0">

                    <input id="_method" name="_method" type="hidden" value="">
                        <div class="modal-header">
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">
                                    ×
                                </span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                <span class="quick-action">
                                </span>
                                Accounts
                            </h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Name:
                                    </label>
                                </div>
                                <div class="col-md-7 form-group">
                                    <input class="form-control" id="name" name="name" placeholder="Enter Name" type="name" value="">
                                    </input>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Login Name:
                                    </label>
                                </div>
                                <div class="col-md-7 form-group">
                                    <input class="form-control" id="email" name="email" placeholder="Enter Email" type="name" value="">
                                    </input>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;" id="div_password">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Password:
                                    </label>
                                </div>
                                <div class="col-md-7 form-group">
                                    <input class="form-control" id="password" name="password" placeholder="Enter Password" type="name" value="">
                                    </input>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;" id="div_confirm_password">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Confirm Password:
                                    </label>
                                </div>
                                <div class="col-md-7 form-group">
                                    <input class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password" type="name" value="">
                                    </input>
                                </div>
                            </div>

                            
                            <div class="row" style="margin-top: 10px;">
                              <div class="col-md-4 form-group">
                                  <label class="control-label " for="Date">
                                        Permission:
                                  </label>
                              </div>
                              <div class="checkbox-custom checkbox-primary" class="col-md-7 form-group" style="margin-left: 20px">
                                <input class="form-control" checked="" id="admin-check" type="checkbox" value='No'>
                                  <label>
                                    Admin
                                    </label>
                                </input>
                              </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default waves-effect waves-light waves-effect waves-light" data-dismiss="modal" type="button">
                                Close
                            </button>
                            <button class="btn btn-primary waves-effect waves-light" id="btn-q-submit" type="button">
                                <i class="fa fa-save ico-btn">
                                </i>
                                Save
                            </button>
                        </div>
                    </input>
                </form>
            </input>
        </div>
    </div>
    <!-- End Modal -->
    <div class="panel">
        <div class="row" style="padding-left: 10px;">
            <header class="panel-heading">
                <div class="panel-actions">
                </div>
                <h3 class="panel-title">
                    Accounts
                </h3>
            </header>
        </div>
        <div class="panel-body">
            <div class="success-alert-area">
            </div>
            <table class="table table-hover dataTable table-striped w-full dtr-inline no-footer" id="account-table">
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Permission
                        </th>
                        <th>
                            Updated At
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var baseUrl = '{{url('')}}';
    $('#admin-check').prop('checked', false);
  $(function() {

   $('#nav-users').addClass('site-menu-item active');

   $("#admin-check").click(function(){
           if($(this).is(":checked")) {
               $("#admin").val('1');
           } else {
               $("#admin").val('0');
           }
   });
 
   // Quick Edit
  $('#account-table').on('click', '.reset-link', function(e) {
    e.preventDefault();
    var edit_id = getIdfromid($(this).attr('id'));
    $('#hid-activate-id').val(edit_id);
    $("#resetPasswordModel").modal('show');
  });

  $('#btn-reset-confirm-yes').click(function(e){
     e.preventDefault();
    $("#resetPasswordModel").modal('hide');
    var id = $('#hid-activate-id').val();
    $.ajax({
      type : "GET",
      url  : baseUrl + '/admin/' + id + '/edit',
      data : {},
      success: function(data){
        //var result = $.parseJSON(data);
        if(data['status'] == 'success') {

         tbl.ajax.reload( null, false );
          $(".success-alert-area").empty().append("<div class='alert alert-success success-display'><a href='#' class='close' data-dismiss='alert'>&times;</a>"+data['msg']+" for UserName <b style='color: red;'>"+data['username']+"</b> | Password is <b style='color: red;'>"+data['password']+"</b></div>");
        }
        else {
             $(".success-alert-area").empty().append("<div class='alert alert-danger success-display'><a href='#' class='close' data-dismiss='alert'>&times;</a>"+data['msg']+"</div>");
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("ERROR!!!");
          alert(errorThrown);
      }
    });
  });

    var tbl = $('#account-table').DataTable({
      processing: true,
      serverSide: true,
      iDisplayLength: 25,
      'responsive': true,
      'language' : {
        "sSearchPlaceholder": "Search..",
        "lengthMenu": "_MENU_",
        "search": "_INPUT_",
        "paginate": {
          "previous"  : '<i class="icon md-chevron-left" style="font-size : 20px;"></i>',
          "next"      : '<i class="icon md-chevron-right" style="font-size : 20px;"></i>'
        }
      },
      order: [[ 4, "desc" ]],
      ajax: {
        url  :  baseUrl + '/admin/create',
      },
      columns: [
        { data: 'DT_RowIndex', orderable: false, bSearchable: false  },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'administrator', name: 'administrator' },
        { data: 'updated_at', name: 'updated_at' },
        {data: 'action', name: 'action', orderable: false, searchable: false}

      ],
      "aoColumnDefs": [
        {
          "aTargets": [ 3 ],  // For Date
          "mRender": function ( data, type, full ) {
              return "<span class='badge badge-info'> "+(data == 1 ? 'Admin' : '---')+"</span>";
          }
        }

      ],
    });

  //Quick-Add
$("#quick-add").click(function(e){
    e.preventDefault();
    var url = baseUrl + '/admin';
    $('#hid-method').remove();
    $('#submiturl').val(url);
    $('#_method').val('POST');
    $("#image-area").html("").show();
    $('.quick-action').html('Add');
    $("#quickModal").modal('show');
  });

// Quick Edit
  $('#account-table').on('click', '.edit-link', function(e) {
    e.preventDefault();
    var id = getIdfromid($(this).attr('id'));
    $.ajax({
      type : "GET",
      url  : baseUrl + '/admin/' + id ,
      data : {},
      success: function(data){
        if(data['status'] == 'success') {


          var updateurl =  baseUrl + '/adminUpdate/' + id;
          $('#name').val(data['name']);
          $('#email').val(data['email']);

          $('#div_password').hide();
          $('#div_confirm_password').hide();


          $("#admin").val('0');
          $('#admin-check').prop('checked', false);

          if(data['administrator'] == 1){

            $("#admin").val('1');
            $('#admin-check').prop('checked', true);
          }

          $('#submiturl').val(updateurl);
          $('.quick-action').html('Edit');
          $("#quickModal").modal('show');

        }
        else {
           alert(result['msg']);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("ERROR!!!");
          alert(errorThrown);
      }
    });
  });


$('#btn-q-submit').click(function(e) {
    e.preventDefault();
    var valid = validateForm('quick-form');
    if(valid) {
      var formdata = $("#quick-form").serializeArray();
      var url = $('#submiturl').val();
      var method = ( $('.quick-action').html() == 'Add' ) ? 'POST' : 'PUT';
      quickAjaxsubmit(url, formdata, tbl, method);
    }
  });




  //Quick Delete
  $('#account-table').on('click', '.del-link', function(e) {
    e.preventDefault();
    var del_id = getIdfromid($(this).attr('id'));
    $('#hid-delete-id').val(del_id);
    $("#confirmModel").modal('show');

  });

  //Quick Delete Confirm
  $("#btn-confirm-yes").click(function(){
    var del_id= $('#hid-delete-id').val();
    $("#confirmModel").modal('hide');
    var url =  baseUrl + '/admin/' + del_id;
    deleteAjax(url, tbl);
  });

  });
</script>
@endsection
