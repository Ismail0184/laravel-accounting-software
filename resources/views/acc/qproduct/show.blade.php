@extends('app')

@section('htmlheader_title', 'Qproduct')

@section('contentheader_title', 'Qproduct')

@section('main-content')

<!-- /.Product Details -->
<div class="box">
        <div class="box-header">
            <h3 class="text-center">Products and Service Details</h3>
        </div><!-- /.box-header -->
	<?php $ttl=''; ?>
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
                        <?php $ttl +=$item->rate * $item->qty; ?>
                <tr>
                	<td class="size">{{ $x }}</td>
                	<td class="size">@if(isset($item->product->name)){{ $item->product->name }}@endif</td>
                    <td class="size text-right">{{ $item->qty }}</td>
                    <td class="size text-right">{{ number_format($item->rate,2) }}</td>
                    <td class="size text-right">{{ number_format($item->rate * $item->qty,2)  }}</td>
                </td>
            @endforeach
            <tr><td colspan="4" class="size text-right">Total: </td><td class="size text-right">@if($ttl>0){{ number_format($ttl,2) }}@endif</td></tr>
	</table>
    </div>

	</div>
        <div class="box-footer">
        	<h4 class="text-center"> </h4>
        </div><!-- /.box-footer -->

</div>

@endsection
