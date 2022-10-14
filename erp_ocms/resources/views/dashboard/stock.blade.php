  <table class="table">
  <tr>
	<th class="col-sm-2">{{ $langs['sl'] }}</th>
	<th class="col-sm-6">{{ $langs['prod_id'] }}</th>
	<th class="col-sm-4 text-right">{{ $langs['sbalance'] }}</th>
  </tr>
  {{-- */$x=0;/* --}}
	@foreach($stock as $data)
	{{-- */$x++;/* --}}
		<tr>
			<td>{{ $x }}</td>
			<td><a href="{{ url('/invenmaster/ledger?item_id='.$data->item_id) }}">@if(isset($data->product->name)){{ $data->product->name }}@endif</a></td>
			<td class="col-sm-4 text-right">{{ $data->qty }}</td>
		</tr>
	@endforeach
	</table>
