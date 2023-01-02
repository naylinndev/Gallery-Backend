@extends('backend.layout')
@section('meta')
<meta content="{{ csrf_token() }}" name="csrf-token"/>
@endsection
@section('breadcrump')
<div class="page-header">
    <div class="row">
        <div class="col-xl-6">
            <h1 class="page-title">
                Post
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="{{url('dashboard')}}">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Post
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
#image-area{
    white-space: nowrap;
}
.control-label {
    padding-top: 7px;
    margin-bottom: 0;
    text-align: right;
}

.row{
    margin-top: 10px;
}

div.note-editor {
   z-index: 10055 ! important;
}
span.select2-container {
  z-index: 100050;
}

.form-group{
  margin-bottom: 0px !important;
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
    <div aria-hidden="true" data-backdrop="static" data-keyboard="false" aria-labelledby="confirmModelLabel" class="modal fade" id="confirmModel" role="dialog">
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
    <div aria-hidden="false" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" class="modal fade" id="quickModal" role="dialog" style="padding-left: 0px;" >
        <div class="modal-dialog modal-lg">
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
                                </span>
                                Post
                            </h4>
                        </div>
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-xl-4 form-group">
                                    <label class="control-label" for="Date">
                                     Title:
                                    </label>
                                </div>
                                <div class="col-xl-8 form-group">
                                    <input class="form-control" id="title" name="title" placeholder="Enter Title" type="name" value="">
                                    </input>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Description:
                                    </label>
                                </div>
                                <div class="col-md-8 form-group" style="margin-top: 10px;">
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
                                </div>
                            </div> 

                            <div class="row" style="margin-top: 10px;" id='video_view'>
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Youtube Video Link:
                                    </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input class="form-control" id="video" name="video" placeholder="Enter Youtube Video Link" type="link" value="">
                                    </input>
                                </div>
                            </div> 

                            <div class="row" style="margin-top: 10px;" id='photo_view'>
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Post Photos:
                                    </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    </input>
                                    <div class="file-loading">
                                        <input id="post_images" type="file" name="post_images[]" multiple class="file" data-overwrite-initial="false" data-min-file-count="1" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-4 form-group"></div>
                                <div class="col-md-8" id="image-area">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xl-4 form-group">
                                  <label class="control-label">
                                    Video or Photo Post:
                                  </label>
                                </div>
                                <div class="col-xl-8 form-group">
                                  <input type="checkbox" data-plugin="switchery" id="is_video"/>
                                  <label class="control-label">
                                    Video?
                                  </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 form-group">
                                  <label class="control-label">
                                    Sent Noti:
                                  </label>
                                </div>
                                <div class="col-xl-8 form-group">
                                  <input type="checkbox" data-plugin="switchery" id="sent_noti"/>
                                  <label class="control-label">
                                    Sent Noti?
                                  </label>
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
                    Posts
                </h3>
            </header>
        </div>
        <div class="panel-body">
            <div class="success-alert-area">
            </div>
            <table class="table table-hover dataTable table-striped w-full dtr-inline no-footer" id="post-table">
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Title
                        </th>
                        <th>
                            Updated At
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
    $('#is_video').attr('value', 0);
    $('#is_video').prop('checked', false);

    $('#video_view').attr('hidden', true);
    $('#photo_view').attr('hidden', false);


    $('#sent_noti').attr('value', 1);
    $('#sent_noti').prop('checked', true);


    $("#description").summernote({
        dialogsInBody: true,
        styleWithSpan: false,
        height: 150,
        toolbar: [
         ['style', ['style']],
         ['font', ['underline','italic', 'bold','clear',]],
         ['fontname', ['fontname']],
         ['color', ['color']],
         ['para', ['ul', 'ol', 'paragraph']],
         ['height', ['height']],
         ['table', ['table']],
         ['insert', ['link', 'picture', 'video']],
         ['view', ['fullscreen', 'codeview']],
        ],
     });

  $(function() {
$('#nav-post').addClass('site-menu-item active');

    var tbl = $('#post-table').DataTable({
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
      order: [[ 2, "desc" ]],
      ajax: {
        url  :  baseUrl + '/post/create',
      },
      columns: [
        { data: 'DT_RowIndex', orderable: false, bSearchable: false  },
        { data: 'title', name: 'title',orderable: true, searchable: true },
        { data: 'updated_at', name: 'updated_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false}

      ],
    });



  //Quick-Add
$("#quick-add").click(function(e){
    e.preventDefault();
    var url = baseUrl + '/post';

    $('#is_video').attr('value', 0);
    $('#is_video').prop('checked', true).trigger("click");

    $('#video_view').attr('hidden', true);
    $('#photo_view').attr('hidden', false);


    $('#sent_noti').attr('value', 1);
    $('#sent_noti').prop('checked', false).trigger("click");

    $('#description').summernote('code','');

    $('#submiturl').val(url);
    $('#_method').val('POST');
    $("#image-area").html("").show();
    $('.quick-action').html('Add');
    $("#quickModal").modal('show');

  });


$('#btn-q-submit').click(function(e) {
    e.preventDefault();
    var valid =  validateForm('quick-form');
    if(valid) {
      $('#updated').val(1);
      var form_data = new FormData($('#quick-form')[0]);
      form_data.append("is_video", $('#is_video').val());
      form_data.append("sent_noti", $('#sent_noti').val());

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
  $('#post-table').on('click', '.edit-link', function(e) { 
    e.preventDefault();
    var id = getIdfromid($(this).attr('id')); 
     var selectedValues = new Array();

    $.ajax({
      type : "GET",
      url  : baseUrl + '/post/' + id + '/edit', 
      data : {},
      success: function(data){ 
        //var result = $.parseJSON(data);
        if(data['status'] == 'success') {
        
          
          var updateurl =  baseUrl + '/post/' + id;
          $('#title').val(data['data']['title']);
          $('#description').summernote('code',data['data']['description']);

          $('#video').val('https://www.youtube.com/watch?v='+data['data']['video']);

          if(data['data']['is_video'] == true){

            $('#is_video').attr('value', 1);
            $('#is_video').prop('checked', false).trigger("click");;

            $('#video_view').attr('hidden', false);
            $('#photo_view').attr('hidden', true);

          }else {

            $('#is_video').attr('value', 0);
            $('#is_video').prop('checked', true).trigger("click");;

            $('#video_view').attr('hidden', true);
            $('#photo_view').attr('hidden', false);

          }

          if(data['data']['sent_noti']){
            $('#sent_noti').attr('value', 1);
            $('#sent_noti').prop('checked', false).trigger("click");;

          }else {
            $('#sent_noti').attr('value', 0);
            $('#sent_noti').prop('checked', true).trigger("click");;

          }
          var i;
           var images = '';
           for (i = 0; i < data['data']['post_images'].length; ++i) {
             var color = "#" + Math.floor(Math.random() * 0xFFFFFF).toString(16);
             images += "<img src='"+ data['data']['post_images'][i] +"' style='width: 150px;margin-left : 10px;border-width : 1px;border-style: solid;border-color:"+color+"'/>"+((i%2 == 0 && i != 0) ? '</br>' : '');
            }
          $("#image-area").html(images).show();
        
          $('#submiturl').val(updateurl);
          $('#_method').val('PATCH');
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


  $("#is_video").on('change', function() {
    if ($(this).is(':checked')) {
      $(this).attr('value', 1);
     $('#video_view').attr('hidden', false);
     $('#photo_view').attr('hidden', true);
    }else {
     $(this).attr('value', 0);
     $('#video_view').attr('hidden', true);
     $('#photo_view').attr('hidden', false);
    }
  });


  $("#sent_noti").on('change', function() {
    if ($(this).is(':checked')) {
      $(this).attr('value', 1);
    }else {
     $(this).attr('value', 0);
    }
  });


  //Quick Delete
  $('#post-table').on('click', '.del-link', function(e) {
    e.preventDefault();
    var del_id = getIdfromid($(this).attr('id')); 
    $('#hid-delete-id').val(del_id);
    $("#confirmModel").modal('show');
   
  });

  //Quick Delete Confirm
  $("#btn-confirm-yes").click(function(){
    var del_id= $('#hid-delete-id').val();
    $("#confirmModel").modal('hide');  
    var url =  baseUrl + '/post/' + del_id;
    deleteAjax(url, tbl);
  });

  });
</script>
@endsection
