@extends('backend.layout')
@section('before-styles')
<style type="text/css">
    .card {
        margin-bottom : 10px ! important;
    }
    .col-md-3{
     padding-right : 0px ! important;
     padding-left : 10px ! important;
    }

</style>
@stop
@section('breadcrump')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="javascript: void(0);">
                Home
            </a>
        </li>
    </ol>
</div>
@stop
@section('content')
<!-- Page Content -->
<div class="page-content container-fluid">

    <div class="row">


        <div class="col-md-3">
            <div class="card card-inverse bg-organe-600" id="nav-category" style="border-radius: 0px;">
                <a href="{{ url('category') }}" style="text-decoration:none">
                  <div class="row"  style="padding: 15px;cursor: pointer;">
                    <div class="col-6">
                      <div>
                        <h4 class="card-title" style="font-size: 40px;font-weight: 300;">
                          {{$category}}
                        </h4>
                        <p class="row" style="align-items: center; padding-left: 20px;">
                            <i aria-hidden="true" class="icon fa-mobile" style="font-size: 20px;color: #f0f0f0;">
                            </i>
                            <span style="font-size: 18px;margin-left: 10px; color: #fff;">
                                Category
                            </span>
                        </p>
                      </div>
                  </div>

                </div>

                </a>
            </div>
        </div>

        

        <div class="col-md-3">
            <div class="card card-inverse bg-organe-600" id="nav-photo" style="border-radius: 0px;">
                <a href="{{ url('photo') }}" style="text-decoration:none">
                    <div style="padding: 15px;cursor: pointer;">
                        <h4 class="card-title" style="font-size: 40px;font-weight: 300;">
                          {{$photos}}
                        </h4>
                        <p class="row" style="align-items: center; padding-left: 20px;">
                            <i aria-hidden="true" class="icon wb-library" style="font-size: 20px;color: #f0f0f0;">
                            </i>
                            <span style="font-size: 18px;margin-left: 10px; color: #fff;">
                                Photos
                            </span>
                        </p>
                    </div>
                </a>
            </div>
        </div>

        @if(Auth::user()->isAdmin())

        <div class="col-md-3">
            <div class="card card-inverse bg-orange-600" id="nav-users" style="border-radius: 0px;">
                <a href="{{ url('admin') }}" style="text-decoration:none">
                    <div style="padding: 15px;cursor: pointer;">
                        <h4 class="card-title" id="nav-users-title" style="font-size: 40px;font-weight: 300;">
                          {{$users}}
                        </h4>
                        <p class="row" style="align-items: center; padding-left: 20px;">
                            <i aria-hidden="true" class="icon wb-users" style="font-size: 20px;color: #f0f0f0;">
                            </i>
                            <span style="font-size: 18px;margin-left: 10px; color: #fff;">
                                Users
                            </span>
                        </p>
                    </div>
                </a>
            </div>
        </div>


        @endif
        

    </div>
</div>
@overwrite

@section('scripts')
<script>
    var baseUrl = '{{url('')}}';
    $(document).ready(function () {
      setInterval(updateDashboard, 30000);

      function updateDashboard() {
        $.ajax({
          type : "GET",
          url  : baseUrl + '/getDashboard',
          data : {},
          success: function(data){
           
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {

          }
        });

      }
    });
  $(function() {
    $('#nav-dashboard').addClass('site-menu-item active');
    });
</script>
@stop
