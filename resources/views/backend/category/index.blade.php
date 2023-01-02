@extends('backend.layout')
@section('meta')
<meta content="{{ csrf_token() }}" name="csrf-token"/>
    @endsection
@section('breadcrump')
    <div class="page-header">
        <div class="row">
            <div class="col-xl-6">
                <h1 class="page-title">
                  Category
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ">
                        <a href="{{url('dashboard')}}">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Category
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
    </style>
    @endsection
@section('content')
    <div class="page-content">
        <!-- Panel Basic -->
        <!-- Page -->
        <div aria-hidden="true" data-backdrop="static" data-keyboard="false" aria-labelledby="confirmModelLabel" class="modal fade" id="confirmModel" role="dialog" tabindex="-1">
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
        <!-- Modal -->
        <div aria-hidden="false" data-backdrop="static" data-keyboard="false"  aria-labelledby="myModalLabel" class="modal fade" id="quickModal" role="dialog" style="padding-left: 0px;" tabindex="-1">
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
                        <input id="_method" name="_method" type="hidden" value="">
                        <div class="modal-header">
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">
                                    ×
                                </span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                <span class="quick-action">
                                    Add
                                </span>
                                Category
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-4 form-group">
                                    <label class="control-label" for="Date">
                                     Category Name:
                                    </label>
                                </div>
                                <div class="col-xl-8 form-group">
                                    <input class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name" type="name" value="">
                                    </input>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Category Image:
                                    </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    </input>
                                    <div class="file-loading">
                                        <input id="category_image" type="file" name="category_image" class="file" data-overwrite-initial="true" data-max-file-count="1" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4 form-group">
                                </div>
                                <div class="col-md-8" id="image-cover" style="display: block;margin-top: 10px;">
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
                    </form>
                </input>
            </div>
        </div>
        <!-- End Modal -->
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                </div>
                <h3 class="panel-title">
                    Category
                </h3>
            </header>
            <div class="panel-body">
                <div class="success-alert-area">
                </div>
                <table class="table table-hover dataTable table-striped w-full dtr-inline no-footer" id="category-table">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                               Category Name
                            </th>
                            <th>
                                Created At
                            </th>
                            <th width="20%">
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
  $(function() {
  $('#nav-category').addClass('site-menu-item active');
    var tbl = $('#category-table').DataTable({
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
      order: [[ 1, "asc" ]],
      ajax: {
        url  :  baseUrl + '/category/create',
      },
      columns: [
        { data: 'DT_RowIndex', orderable: false, bSearchable: false  },
        { data: 'category_name', name: 'category_name' },
        { data: 'created_at', name: 'created_at' },
        {data: 'action', name: 'action', orderable: false, searchable: false}

      ]
    });



  //Quick-Add
$("#quick-add").click(function(e){
    e.preventDefault();
    var url = baseUrl + '/category';
    $('#hid-method').remove();
    $('#submiturl').val(url);
    $('.quick-action').html('Add');
    $("#quickModal").modal('show');
  });

 $('#btn-q-submit').click(function(e) {
    e.preventDefault();
    var valid = validateForm('quick-form');
    if(valid) {

      var form_data = new FormData($('#quick-form')[0]);
      $.ajax({
        url: $('#submiturl').val(),
        dataType: 'json',
        data: form_data,
        contentType:false,
        cache: false,
        processData:false,
        type: 'POST', 
        beforeSend: function(xhr) {
          $('#btn-q-submit').html('Submitting...');
          $('#btn-q-submit').attr('disabled','disabled');
        },
        success: function(data){
          if(data['status'] == 'success') {
            tbl.ajax.reload( null, false );
            emptyForm('quick-form');
            $('#btn-q-submit').removeAttr('disabled').html('<i class="fa fa-save ico-btn"></i> Save');
            $("#quickModal").modal('hide');
            $(".success-alert-area").empty().append("<div class='alert alert-success success-display'><a href='#' class='close' data-dismiss='alert'>&times;</a>"+data['msg']+"</div>");
          }
          else {
            $('.err-display').html(data['msg']);
            $('.err-display').show();
            $('#btn-q-submit').removeAttr('disabled').html('<i class="fa fa-save ico-btn"></i> Save');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alert("ERROR!!!");     
            alert(errorThrown);      
        } 
      });
    }
  });



// Quick Edit
  $('#category-table').on('click', '.edit-link', function(e) {
    e.preventDefault();
    var id = getIdfromid($(this).attr('id'));
    $.ajax({
      type : "GET",
      url  : baseUrl + '/category/' + id + '/edit',
      data : {},
      success: function(data){
        if(data['status'] == 'success') {


          var updateurl =  baseUrl + '/category/' + id;
          $('#category_name').val(data['data']['category_name']);
          $("#image-cover").html("<img src='"+ data['data']['category_image'] +"' style='width:200px;margin-left : 100px;' />").show();



          $('#submiturl').val(updateurl);
          $('.quick-action').html('Edit');
          $("#quickModal").modal('show');
          $('#_method').val('PATCH');

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



  //Quick Delete
  $('#category-table').on('click', '.del-link', function(e) {
    e.preventDefault();
    var del_id = getIdfromid($(this).attr('id'));
    $('#hid-delete-id').val(del_id);
    $("#confirmModel").modal('show');

  });

  //Quick Delete Confirm
  $("#btn-confirm-yes").click(function(){
    var del_id= $('#hid-delete-id').val();
    $("#confirmModel").modal('hide');
    var url =  baseUrl + '/category/' + del_id;
    deleteAjax(url, tbl);
  });

  });
    </script>
    @endsection
