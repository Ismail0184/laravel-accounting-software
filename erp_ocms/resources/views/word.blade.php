<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
    <head>
        <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
        <meta name='ProgId' content='Word.Document'>
        <meta name='Generator' content="Microsoft Word 9">
        <meta name='Originator' content="Microsoft Word 9">
        <title> OCMS ERP - @yield('htmlheader_title', 'Your title here') </title>
        <!-- Bootstrap 3.3.4 -->
        <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{ asset('/css/font-awesome/4.3.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{ asset('/css/ionicons/2.0.1/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset('/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
        <style>
            @page Section1 {size:595.45pt 841.7pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
            div.Section1 {page:Section1;}
            @page Section2 {size:841.7pt 595.45pt;mso-page-orientation:landscape;margin:1.25in 1.0in 1.25in 1.0in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
            div.Section2 {page:Section2;}
        </style>
    </head>
    <body>
        <div class='Section2'>
            @yield('main-content')
        </div>
        <!-- AdminLTE App -->
        <script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>
    </body>
</html>