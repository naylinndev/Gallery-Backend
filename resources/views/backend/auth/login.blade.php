<!DOCTYPE html>
<html class="no-js css-menubar">
<head>
  <meta charset='utf-8'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0, minimal-ui">
  <meta content='{{ csrf_token() }}' name='_token'>
  <title>@yield('title', 'NToon')</title>
  <meta content='@yield('description', '')' name='description'>
  <meta content='@yield('author', '')' name='author'>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('meta')
<link rel="gataomo-icon" href="{{url('images/logo.png')}}">
<link rel="shortcut icon" href="{{url('images/logo.png')}}">
  {!! css([
    'global/css/bootstrap.min',
    'global/css/bootstrap-extend.min',
    'assets/css/site.min',
    "global/vendor/animsition/animsition",
    'global/vendor/asscrollable/asScrollable',
    'global/vendor/switchery/switchery',
    'global/vendor/intro-js/introjs',
    'global/vendor/slidepanel/slidePanel',
    'global/vendor/flag-icon-css/flag-icon',
    'assets/examples/css/pages/login-v3',
    'global/fonts/web-icons/web-icons.min',
    'global/fonts/brand-icons/brand-icons.min'
  ], 'assets/backend/') !!}


    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    {!! js(['global/vendor/breakpoints/breakpoints'
            ], 'assets/backend/') !!}

    <script>
      Breakpoints();
    </script>
</head>
  <body class="page-login-v3 layout-full" style="background: #000;">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out" style="background: #000;">
      <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
        <div class="panel"  style="width: 400px;">
          <div class="panel-body" style="padding-left: 30px !important; padding-right: 30px !important;padding-bottom: 30px !important;padding-top: 0px !important;">
            <div class="brand">
              <img class="brand-img" src="{{url('images/logo.png')}}" alt="..." style="width: 100px;height: 100px;">
              <h2 class="brand-text font-size-18" style="margin-top: 0px !important;">Gallery</h2>
            </div>
          <div class="alert alert-danger" id="login-alert" style="display:none">  </div>
            <form method="post" action="{{url('')}}">
              {{ csrf_field() }}
              <div class="form-group form-material floating error" >
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter User Name" />
                <label class="floating-label">User Name / Email</label>
              </div>
              <div class="form-group form-material floating" >
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" />
                <label class="floating-label">Password</label>
              </div>
              <button type="button" class="btn btn-primary btn-block btn-lg mt-40" id="btn-submit">Sign in</button>
            </form>
          </div>
        </div>

        <footer class="page-copyright page-copyright-inverse">
          <p>WEBSITE BY <a href="#" target="_blank" style="color: #da0b0b;">Nay Lin</a></p>
          <p>© {{ now()->year }}. All RIGHT RESERVED.</p>
        </footer>
      </div>
    </div>
    <!-- End Page -->

<!-- Core  -->
{!! js([
  "global/vendor/babel-external-helpers/babel-external-helpers",
  "global/vendor/jquery/jquery",
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
"assets/js/Site",
"global/js/Plugin/asscrollable",
'global/js/Plugin/slidepanel',
'global/js/Plugin/switchery',
'global/js/Plugin/jquery-placeholder',
'global/js/Plugin/material'
], 'assets/backend/') !!}

  <script>

  $(function() {
    var input = document.getElementById("password");
      input.addEventListener("keyup", function(event) {
          event.preventDefault();
         if (event.keyCode === 13) {
               $('#btn-submit').click();
           }
      });

      var input = document.getElementById("email");
      input.addEventListener("keyup", function(event) {
          event.preventDefault();
         if (event.keyCode === 13) {
               $('#btn-submit').click();
           }
      });

  $('#btn-submit').click(function (e) {
    e.preventDefault();
    $.ajax({
      url: '{{url('login')}}',
      method : "POST",
      data : {
        'email'  : $('#email').val(),
        'password'         : $('#password').val(),
      },
      beforeSend : function () {
          $('#login-alert').html('').hide();
          $('#btn-submit').html('<i class="fa fa-spinner fa-spin"></i> Submitting...').attr('disabled','disabled');
      },
      success: function(result) {
         // var result = $.parseJSON(data);
          if(result['status'] == 'success') {
            window.location.href = "{{url('dashboard')}}";
          }
          else {
              $('#login-alert').html(result['msg']).show();
              $('#btn-submit').html('<i class="icon md-lock-open"></i> Sign in').removeAttr('disabled');
          }
      },
      error: function(e) {
      }
    });
    });
 });



  </script>
   <script>Config.set('assets', "{{asset('/assets/backend/assets')}}");</script>
  <script>
      (function(document, window, $){
        'use strict';

        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);

      $.ajaxSetup({
       headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
       });
    </script>
</body>
</html>
