@extends('app')

@section('htmlheader_title')
    403 Error Page
@endsection

@section('contentheader_title')
    403 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

<div class="error-page">
    <h2 class="headline text-red"> 403</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-red"></i> Oops! You are not Authorize to see this page.</h3>
        <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href='{{ url('/dashboard') }}'>return to dashboard</a>.
        </p>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
@endsection