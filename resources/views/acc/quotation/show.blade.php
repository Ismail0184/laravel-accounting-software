@extends('app')

@section('htmlheader_title', 'Quotation')

@section('contentheader_title', 'Quotation')

@section('main-content')
<?php 

	use App\Models\Acc\Coverpages;
	use App\Models\Acc\Fletters;
	use App\Models\Acc\Termconditions;
	use App\Models\Acc\Conditions;
	use App\Models\Acc\Clientlists;
	use App\Models\Acc\Qproducts;
	
	$clist=Clientlists::Latest()->get();
	$qproducts=Qproducts::where('quotation_id', $quotation->id)->Latest()->get();
	
	$coverpage=Coverpages::where('id', $quotation->cpage_id)->first();
	$fletter=Fletters::where('id', $quotation->fletter_id)->first();
	$topics=Conditions::select('acc_conditions.id as id', 'acc_conditions.topic_id as topic_id')->join('acc_termconditions', 'acc_conditions.id','=','acc_termconditions.condition_id')
	->where('quotation_id', $quotation->id)->groupBy('acc_conditions.topic_id')->get();
?>

<style>
	.mtitle { height:200px; padding-top:50px; text-align:center; font-weight:bolder; font-size:36px}
	.breif { height:150px; padding-top:30px; font-style:italic; font-weight:bold; text-align:center }
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
	.box-footer { padding-left:7%;}

</style>
<div class="box">
        <div class="box-header">
        </div><!-- /.box-header -->

	<div class="container">
        <h2 class="text-center"> {{ $coverpage->header }}</h2>
        <h5 class="text-center">({{ $coverpage->header_details}})</h5>
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
<!-- /.end of-cover page -->

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

<!-- /.Product Details -->
<div class="box">
        <div class="box-header">
            <h3 class="text-center">Products and Service Details</h3>
        </div><!-- /.box-header -->
	<?php $price=''; ?>
	<div class="container">
    <div class="table-responsive">
    <table class="table">
    	<tr>
        	<th>{{ $langs['sl'] }}</th>
        	<th>{{ $langs['prod_id'] }}</th>
			<th class="text-right">{{ $langs['qty'] }}</th>
            <th class="text-right">{{ $langs['rate'] }}</th>
            <th class="text-right">{{ $langs['amount'] }}</th>
        </tr>
                        {{-- */$x=0;/* --}}
    	@foreach($qproducts as $item)
                        {{-- */$x++;/* --}}
                        <?php $price +=$item->rate * $item->qty; ?>
                <tr>
                	<td class="size">{{ $x }}</td>
                	<td class="size">@if(isset($item->product->name)){{ $item->product->name }}@endif</td>
                    <td class="size text-right">{{ $item->qty }}</td>
                    <td class="size text-right">{{ number_format($item->rate,2) }}</td>
                    <td class="size text-right">{{ number_format($item->rate * $item->qty, 2)  }}</td>
                </td>
            @endforeach
            <tr><td colspan="4" class="size text-right">Total: </td><td class="size text-right">@if($price>0){{ number_format($price,2) }}@endif</td></tr>
	</table>
    </div>

	</div>
        <div class="box-footer">
        	<ul>
            <li><h3>Price and Payment</h3></li>
                <ul>
                    <li><h4 class="text-left">Totap Price: @if($price>0){{ number_format($price,2) }} @endif  {{ Terbilang::make($price) }}  only</h4></li>
                    <li><h4 class="text-left">Singing Money: @if($price>0){{ number_format($price * 40/100,2) }} @endif  {{ Terbilang::make($price * 40/100) }}  only</h4></li>
                    <li><h4 class="text-left">Monthly Payment: @if($price>0){{ number_format($price * 60/100/4,2) }} @endif  {{ Terbilang::make($price * 60/100/4) }}  only</h4></li>
                </ul>
            </ul>
        </div><!-- /.box-footer -->

</div>


<!-- /.Term and Condition -->
<div class="box">
        <div class="box-header">
            <h3 class="text-center">Terms and Condition</h3>
        </div><!-- /.box-header -->

	<div class="container">
    <div class="table-responsive">
    <ul>
    	@foreach($topics as $item)
        	<li><h3>@if(isset($item->topic->name)){{ $item->topic->name }}@endif</h3></li>
            <?php 	$termconditions=Termconditions::join('acc_conditions','acc_termconditions.condition_id','=','acc_conditions.id')
			->where('quotation_id', $quotation->id)->where('acc_conditions.topic_id',$item->topic_id)
			->get();?>
            <ul>
            @foreach($termconditions as $item)
                <li><p class="size">@if(isset($item->condition->name)){{ $item->condition->name }}@endif</p></li>
            @endforeach
			</ul>
        @endforeach
    </ul>
    </div>

	</div>
        <div class="box-footer">
        	<h4 class="text-center"> {{ $fletter->footer }}</h4>
        </div><!-- /.box-footer -->

</div>


<!-- /.Client List -->
<div class="box">
        <div class="box-header">
            <h3 class="text-center">Client List</h3>
        </div><!-- /.box-header -->

	<div class="container">
    <div class="table-responsive">
    <table class="table">
    	<tr>
            <th class="size">{{ $langs['sl'] }}</th>
            <th class="size">{{ $langs['name'] }}</th>
            <th class="size">{{ $langs['group_name'] }}</th>
            <th class="size">{{ $langs['product'] }}</th>
        </tr>
                {{-- */$x=0;/* --}}
    	@foreach($clist as $item)
                    {{-- */$x++;/* --}}
                <tr>
                	<td class="size">{{ $x }}</td>
                    <td class="size">{{ $item->name }}</td>
                    <td class="size">{{ $item->group_name }}</td>
                    <td class="size">{{ $item->product }}</td>
                </tr>
        @endforeach
    </table>
    </div>

	</div>
        <div class="box-footer">
        	<h4 class="text-center"> {{ $fletter->footer }}</h4>
        </div><!-- /.box-footer -->

</div>

@endsection
@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".condition").validate();
	
    });
        
</script>

@endsection
