<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title> OCMS ERP - @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset('/css/font-awesome/4.3.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ asset('/css/ionicons/2.0.1/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <!-- print -->
    <style type="text/css">
        thead { display: table-header-group }
        tfoot { display: table-footer-group }
        tr { page-break-inside: avoid }
        body { font-family: arial;}
		.break {display:block; clear:both; page-break-after:always}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/js/html5shiv/3.7.2/html5shiv.min.js') }}"></script>
    <script src="{{ asset('/js/respond/1.4.2/respond.min.js') }}"></script>
    <![endif]-->
  </head>
  <body>
    <div class="wrapper">
      <!-- Main content -->
      <section>
        @yield('main-content')
      </section><!-- /.content -->
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
    <script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>
  </body>
</html>