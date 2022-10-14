@extends('app')

@section('htmlheader_title', 'Fletter')

@section('contentheader_title', 'Forwarding Letter')

@section('main-content')
<style>
	.box-header { padding-left:7%;}
	.subject { padding-top:10px; padding-bottom:10px}
	.qdate {height:50px}
	.client { font-size:20px; font-weight:bold; margin-bottom:10px}
	.bold { font-weight:bold}
	.address { margin-bottom:50px}
	.sign { margin-top:100px;}
	.line-top { border-top: 1px solid #000; display: inline-block;}
	.thank { margin-top:30px; }
	.conc { margin-top:50px; }
	.itally { font-style:italic;}
	.size { font-size:18px;}
</style>
<div class="box">
        <div class="box-header">
            <h4 class="qdate">Date: {{ $fletter->qdate }}</h4>
            <h4 class="client">{{ $fletter->client }}</h4>
            <h4 class="address">{{ $fletter->address }}</h4>
            <h4 class="attention"><span class="bold">Attention:</span> {{ $fletter->attention }}</h4>
            <h4 class="subject"><span class="bold">Subject:</span> <span class="bold itally size">{{ $fletter->subject }}</span></h4>
        </div><!-- /.box-header -->

	<div class="container">
    <div class="table-responsive">
    <h4 class="bold">Dear Sir,</h4>
    <p><h4 class="ref">{{ $fletter->ref }}. {{ $fletter->lbody }}</h4></p>
    <p><h4 class="conc">{{ $fletter->conclusion }}</h4></p>
    
    <p><h4 class="thank">Thanks And Best Regards</h4></p>

    <p><h4 class="sign bold"><div class="line-top">{{ $fletter->sign->name }}</div></h4></p>
    <p><h4>{{ $fletter->sign->designation }}</h4></p>
    <p><h4>Mobile: {{ $fletter->sign->mobile }}</h4></p>
    <p><h4>Email: {{ $fletter->sign->email }}</h4></p>
    <p><h4>Website: {{ $fletter->sign->website }}</h4></p>

    </div>

	</div>
        <div class="box-footer">
        	<h4 class="text-center"> {{ $fletter->footer }}</h4>
        </div><!-- /.box-footer -->

</div>
@endsection
