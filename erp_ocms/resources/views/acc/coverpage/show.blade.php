@extends('app')

@section('htmlheader_title', 'Coverpage')

@section('contentheader_title', 'Coverpage')

@section('main-content')
<style>
	.mtitle { height:200px; padding-top:50px; text-align:center; font-weight:bolder; font-size:36px}
	.breif { height:150px; padding-top:30px; font-style:italic; font-weight:bold; text-align:center }
</style>
<div class="box">
        <div class="box-header">
        <h2 class="text-center"> {{ $coverpage->header }}</h2>
        </div><!-- /.box-header -->

	<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <td><h2 class="mtitle">{{ $coverpage->mtitle }}</h2></td>
            </tr>
            <tr>
                <td><h4 class="text-center">{{ $coverpage->subtitle }}</h4></td>
            </tr>
            <tr>
                <td><h4 class="text-center">Year of Establishment :{{ $coverpage->estyear }}</h3></td>
            </tr>
            <tr>
                <td><h4 class="text-center">Founder : {{ $coverpage->founder }}</h3></td>
            </tr>
            <tr>
                <td><h4 class="breif">{{ $coverpage->breif }}</h4></td>
            </tr>
        </table>
    </div>

	</div>
        <div class="box-footer">
        <h4 class="text-center"> {{ $coverpage->footer }}</h2>
        </div><!-- /.box-footer -->

</div>
@endsection
