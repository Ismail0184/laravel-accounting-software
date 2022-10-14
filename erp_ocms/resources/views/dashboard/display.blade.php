  <table class="table">
  <tr>
    <th class="col-sm-2">{{ $langs['sl'] }}</th>
    <th class="col-sm-6">{{ $langs['acc_id'] }}</th>
    <th class="col-sm-4 text-right">{{ $langs['balance'] }}</th>
  </tr>
  {{-- */$x=0;/* --}}
  <?php $ttl=''; ?>
    @foreach($texpenses as $data)
    {{-- */$x++;/* --}}
        <tr>
            <td>{{ $x }}</td>
            <td><a href="{{ url('/tranmaster/voucher', $data->tm_id) }}">VNo:{{ $data->vnumber }}-@if(isset($data->coa->name)){{ $data->coa->name }}@endif</a></td>
            <td class="col-sm-4 text-right">{{ $data->amount }}</td>
        </tr>
  <?php $ttl += $data->amount; ?>
    @endforeach
    <tr>
        <td class="text-right" colspan="2">Todal</td>
        <td class="text-right">{{ $ttl }}</td>
    </tr>
    </table>
