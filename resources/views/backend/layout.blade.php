<!DOCTYPE html>
<html class="no-js css-menubar">
<head>
  <meta charset='utf-16'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <meta content='{{ csrf_token() }}' name='_token'>
  <title>@yield('title', 'Gallery')</title>
  <meta content='@yield('description', '')' name='description'>
  <meta content='@yield('author', '')' name='author'>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('meta')
<link rel="gataomo-icon" href="{{url('images/logo.png')}}">
<link rel="shortcut icon" href="{{url('images/logo.png')}}">
  @yield('before-styles')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<link href="/assets/backend/global/css/bootstrap.min.css" rel="stylesheet"  media='screen,print'>
<link rel="stylesheet" href='https://mmwebfonts.comquas.com/fonts/?font=pyidaungsu'/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" media="all" rel="stylesheet" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js" type="text/javascript"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
 <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

 <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css';
css.rel = 'stylesheet'; css.type = 'text/css';
document.getElementsByTagName('head')[0].appendChild(css); })();
</script>
{{-- 
<style>
    * {
     font-family: 'Pyidaungsu';
    }
</style> --}}

<style type="text/css">

.group_name { color: #000000; font-size: 15px; }
.group_address { color: #808080; font-size: 13px; margin-left: 10px;}
.select2-selection__choice__remove{
  font-size: 20px;
}
.form-group{
  margin-bottom: 0px !important;
}
a { cursor: pointer; }
.control-label {
padding-top: 7px;
margin-bottom: 0;
text-align: right;
}
.select2-results__group{
  font-weight: 1000 !important;
}
.select2-results__options--nested{
  margin-left: 20px !important;
}
.dropdown-menu{
  z-index: 10055 ! important;
}
div.note-editor {
z-index: 10055 ! important;
}
span.select2-container {
z-index: 10050;
}
#toast-container {
    position: fixed;
    z-index: 999999;
    pointer-events: none;
}
.select2-selection__arrow{
  top:5px !important;
}
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

html {
  height: 100%;
  /* background: radial-gradient(#000, #555); */
}


</style>


<style type="text/css">

#loading {
    display:none;
    position:absolute;
    left:0;
    top:0;
    z-index:100000;
    width:100%;
    height:100%;
    min-height:100%;
    background:#000;
    opacity:0.8;
    text-align:center;
    color:#fff;
}

.loading-title{
   margin-top: 20%;
    z-index:100010;
    font-size: 20px;
    align-self: center;
}

.loader-tadpole{
    top: 30px;
    z-index:100010;
    align-self: center;
    color-rendering: #ff0000 !important;
}
</style>

 {!! css([
  'global/vendor/bootstrap-datepicker/bootstrap-datepicker',
    'assets/css/custom',
    'global/vendor/bootstrap-tokenfield/bootstrap-tokenfield',
    'global/vendor/bootstrap-tagsinput/bootstrap-tagsinput',
    'global/vendor/typeahead-js/typeahead',
    'global/vendor/timepicker/jquery-timepicker',
    'global/vendor/wave/waves',
    'global/fonts/web-icons/web-icons.min',
    'global/fonts/material-design/material-design.min',
    'global/css/bootstrap-extend.min',
    'assets/css/site.min',
    "global/vendor/animsition/animsition",
    'global/vendor/asscrollable/asScrollable',
    'global/vendor/select2/select2',
    'global/vendor/switchery/switchery',
    'global/vendor/icheck/icheck',
    'global/vendor/intro-js/introjs',
    'global/vendor/slidepanel/slidePanel',
    'global/vendor/flag-icon-css/flag-icon',
    'global/fonts/font-awesome/font-awesome',
    'global/fonts/weather-icons/weather-icons',
    'global/fonts/brand-icons/brand-icons.min',
      'assets/examples/css/uikit/utilities',
      'global/vendor/summernote/summernote',
      'assets/examples/css/uikit/dropdowns',
      'global/vendor/chartist/chartist',
      'global/vendor/aspieprogress/asPieProgress',
      'assets/examples/css/uikit/dropdowns',
      'global/vendor/ionrangeslider/ionrangeslider.min',
      'global/vendor/asrange/asRange',
  ], 'assets/backend/') !!}

 {!! css([
    'global/vendor/datatables.net-bs4/dataTables.bootstrap4',
    'global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4',
    'global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4',
    'global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4',
    'global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4',
    'global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4',
    'global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4',
    'global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4',
    'assets/examples/css/tables/datatable',
    'assets/examples/css/uikit/modals',
    'global/vendor/toastr/toastr',
    'assets/examples/css/advanced/toastr',
    'global/vendor/blueimp-file-upload/jquery.fileupload',
    'global/vendor/dropify/dropify'
  ], 'assets/backend/') !!}


   {!! css([
    'assets/examples/css/forms/masks',
    'global/vendor/select2/select2',
    'global/vendor/bootstrap-tokenfield/bootstrap-tokenfield',
    'global/vendor/bootstrap-tagsinput/bootstrap-tagsinput',
    'global/vendor/multi-select/multi-select',
    'global/vendor/typeahead-js/typeahead',
    'assets/examples/css/forms/advanced'
  ], 'assets/backend/') !!}


      <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
 {!! js(['global/vendor/breakpoints/breakpoints',
  'assets/js/modernizr',
  'global/vendor/wave/waves',
             ], 'assets/backend/') !!}
       <script>
      Breakpoints();
    </script>
  </head>

 <body class="dashboard" style="animation-duration: 0ms; opacity: 1;">

       @include('backend.partials.header')
       @include('backend.partials.menu')


  <div  class="page" style="animation-duration: 100ms; opacity: 1;">
      @yield('breadcrump')
      @include('flash::message')
      @yield('content')


    

  
       <!-- Modal -->
    <div aria-hidden="false" aria-labelledby="myModalLabel" class="modal fade" id="changePasswordModal" role="dialog" style="padding-left: 0px;" >
        <div class="modal-dialog modal-md">
            <input id="password-submiturl" name="password-submiturl" type="hidden" value="">
                <form class="modal-content" enctype="multipart/form-data" id="change-password-form" role="form">
                    <div class="alert dark alert-danger alert-dismissible err-display" role="alert" style="display: none;">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">
                                x
                            </span>
                        </button>
                    </div>
                    @csrf
                        <div class="modal-header">
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">
                                    ×
                                </span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                <span class="quick-action">
                                </span>
                                Change Password
                            </h4>
                        </div>
                        <div class="modal-body">

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Old Password:
                                    </label>
                                </div>
                                <div class="col-md-7 form-group">
                                    <input class="form-control" id="old_password" name="old_password" placeholder="Enter Password" type="password" value="" autocomplete="current-password">
                                    </input>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                    New Password:
                                    </label>
                                </div>
                                <div class="col-md-7 form-group">
                                    <input class="form-control"  id="change_password" name="change_password" placeholder="Enter New Password" type="password" value="" autocomplete="new-password">
                                    </input>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label " for="Date">
                                        Confirm Password:
                                    </label>
                                </div>
                                <div class="col-md-7 form-group">
                                    <input class="form-control" id="change_password_confirmation" name="change_password_confirmation" placeholder="Enter Confirm Password" type="password" value="" autocomplete="new-password">
                                    </input>
                                </div>
                            </div>




                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default waves-effect waves-light waves-effect waves-light" data-dismiss="modal" type="button">
                                Close
                            </button>
                            <button class="btn btn-primary waves-effect waves-light" id="btn-password-submit" type="button">
                                <i class="fa fa-save ico-btn">
                                </i>
                                Change Password
                            </button>
                        </div>
                    </input>
                </form>
            </input>
        </div>
    </div>
    <!-- End Modal -->
  </div>
      @include('backend.partials.footer')


<!-- Core  -->
{!! js([
  'assets/js/custom',
  "global/vendor/babel-external-helpers/babel-external-helpers",
  'global/vendor/popper-js/umd/popper.min',
  "global/vendor/bootstrap/bootstrap",
  "global/vendor/animsition/animsition",
  'global/vendor/mousewheel/jquery.mousewheel',
  'global/vendor/asscrollbar/jquery-asScrollbar',
  'global/vendor/asscrollable/jquery-asScrollable',
  'global/vendor/ashoverscroll/jquery-asHoverScroll',
], 'assets/backend/') !!}

<!-- Plugins -->
{!! js([
  "global/vendor/switchery/switchery",
  'global/vendor/intro-js/intro',
  'global/vendor/screenfull/screenfull',
  'global/vendor/slidepanel/jquery-slidePanel',
  'global/vendor/skycons/skycons',
  'global/vendor/aspieprogress/jquery-asPieProgress.min',
  'global/vendor/matchheight/jquery.matchHeight-min',
  'global/vendor/jquery-placeholder/jquery.placeholder',
  'global/js/Component',
  'global/js/Plugin',
  'global/js/Base',
  'global/js/Config',
  'assets/js/Section/Menubar',
  'assets/js/Section/GridMenu',
  'assets/js/Section/Sidebar',
  'assets/js/Section/PageAside',
  'assets/js/Plugin/menu',
  'global/js/config/colors',
  'assets/js/config/tour',
], 'assets/backend/') !!}


<!-- Page -->
{!! js([
'global/vendor/datatables.net/jquery.dataTables',
'global/vendor/datatables.net/dataTables.select',
'global/vendor/datatables.net-bs4/dataTables.bootstrap4',
'global/vendor/datatables.net-fixedheader/dataTables.fixedHeader',
'global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns',
'global/vendor/datatables.net-rowgroup/dataTables.rowGroup',
'global/vendor/datatables.net-scroller/dataTables.scroller',
'global/vendor/datatables.net-responsive/dataTables.responsive',
'global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4',
'global/vendor/datatables.net-buttons/dataTables.buttons',
'global/vendor/datatables.net-buttons/buttons.html5',
'global/vendor/datatables.net-buttons/buttons.flash',
'global/vendor/datatables.net-buttons/buttons.print',
'global/vendor/datatables.net-buttons/buttons.colVis',
'global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4',
'global/vendor/asrange/jquery-asRange.min',
'global/vendor/bootbox/bootbox'
], 'assets/backend/') !!}


   <!-- Page -->
{!! js([
"assets/js/Site",
"global/js/Plugin/asscrollable",
'global/js/Plugin/slidepanel',
'global/js/Plugin/switchery',
'global/js/Plugin/matchheight',
'global/js/Plugin/jvectormap',
'global/js/Plugin/toastr',
'global/js/Plugin/datatables',
'assets/examples/js/tables/datatable',
], 'assets/backend/') !!}

 <!-- Scripts -->


 <!-- Plugins -->
{!! js([
'global/vendor/jquery-ui/jquery-ui',
'global/vendor/blueimp-tmpl/tmpl',
'global/vendor/blueimp-canvas-to-blob/canvas-to-blob',
'global/vendor/blueimp-load-image/load-image.all.min',
'global/vendor/blueimp-file-upload/jquery.fileupload',
'global/vendor/blueimp-file-upload/jquery.fileupload-process',
'global/vendor/blueimp-file-upload/jquery.fileupload-image',
'global/vendor/blueimp-file-upload/jquery.fileupload-audio',
'global/vendor/blueimp-file-upload/jquery.fileupload-video',
'global/vendor/blueimp-file-upload/jquery.fileupload-validate',
'global/vendor/blueimp-file-upload/jquery.fileupload-ui',
'global/vendor/dropify/dropify.min',
'global/js/Plugin/dropify',
'global/vendor/icheck/icheck.min',
'global/vendor/switchery/switchery',
'assets/examples/js/forms/uploads',
'global/js/Plugin/formatter',
'global/vendor/formatter/jquery.formatter',
'global/vendor/summernote/summernote.min',
'global/js/Plugin/summernote',
'global/vendor/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min',
'global/vendor/jquery-placeholder/jquery.placeholder',
'global/js/Plugin/jquery-placeholder',
'global/js/Plugin/input-group-file',
'global/vendor/bootstrap-datepicker/bootstrap-datepicker',
'global/js/Plugin/matchheight',
'global/js/Plugin/aspieprogress',
'global/js/Plugin/asscrollable',
'global/js/Plugin/datepair',
'global/js/Plugin/bootstrap-select',
'global/js/Plugin/bootstrap-touchspin',
'global/js/Plugin/bootstrap-datepicker',
'global/js/Plugin/tabs',
'global/js/Plugin/select2',
'global/js/Plugin/ionrangeslider',
'global/js/Plugin/asrange',
'global/js/Plugin/bootstrap-tagsinput',
'global/vendor/typeahead-js/typeahead.jquery.min',
'global/vendor/bootstrap-tokenfield/bootstrap-tokenfield.min',
'global/js/Plugin/bootstrap-tokenfield',
'global/vendor/timepicker/jquery.timepicker.min',
'global/vendor/toastr/toastr',
'global/js/Plugin/jt-timepicker',
'global/js/Plugin/datepair'
], 'assets/backend/') !!}


  <script>


   (function(document, window, $){
        'use strict';

        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })
   (document, window, jQuery);
         $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
      $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
    });

   // $(document).ready(function() {
    //$("div").on("contextmenu",function(){
     //  return false;
    //});
    //});

  $(function() {
    //Quick-Add
$("#change-password").click(function(e){
    e.preventDefault();
    var url = baseUrl + '/admin/'+{{Auth::user()->id}};
    $('#hid-method').remove();
    $('#password-submiturl').val(url);
    $("#changePasswordModal").modal('show');
  });

$('#btn-password-submit').click(function(e) {
    e.preventDefault();
    var valid = validateForm('change-password-form');
    if(valid) {
      var formdata = $("#change-password-form").serializeArray();
      var url = $('#password-submiturl').val();
      var method = 'PUT';
      $.ajax({
        type :  method,
        url  :  url,
        data :  formdata,
        dataType: "json",
        beforeSend: function(xhr){
          $('#btn-password-submit').html('Submitting...').attr('disabled','disabled');
        },
        success: function(data){
          //  var result = $.parseJSON(data);
            if(data['status'] == 'success') {
                emptyForm('change-password-form');
                $('#btn-password-submit').removeAttr('disabled').html('<i class="fa fa-save ico-btn"></i> Save');
                $("#changePasswordModal").modal('hide');
                $(".success-alert-area").empty().append("<div class='alert alert-success success-display'><a href='#' class='close' data-dismiss='alert'>&times;</a>"+data['msg']+"</div>");
            }
            else {
                $('.err-display').html(data['msg']);
                $('.err-display').show();
                $('#btn-password-submit').removeAttr('disabled').html('<i class="fa fa-save ico-btn"></i> Save');
            }
          },
            error: function(e) {
              //console.log(e.responseText);
             }
         });
        }
    });

  });

    </script>

    <!-- AIzaSyAbrI3t8MahVul4VDL3nfXp0Ja7Odrujys -->

   
    <script>
      
      $('#message_content').on('click', '.message', function(e) {
        e.preventDefault();
        var id = getIdfromid($(this).attr('id'));

      });


    </script>

<script type="text/javascript">
      var specialKeys = new Array();
      specialKeys.push(8); //Backspace
      function IsNumeric(e) {
          var keyCode = e.which ? e.which : e.keyCode
          var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
          return ret;
      }

     function IsDecimal(event,obj) {
        var chCode = ('charCode' in event) ? event.charCode : event.keyCode;

        if (chCode >= 48 && chCode <= 57){
          return true;
        } else if (chCode == 46){
            if (obj.value.indexOf('.') >= 0)  {
              return false;
          }
          return true;
        } else{
          return false;
        }
      }

  </script>
    @yield('scripts')



</body>
</html>
