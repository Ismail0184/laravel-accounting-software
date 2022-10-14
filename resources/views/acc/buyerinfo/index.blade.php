@extends('app')

@section('htmlheader_title', 'Buyer')

@section('contentheader_title', 'Buyer')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$employee_id=''; $date_range='';

		Session::put('brdfrom', date('Y-01-01'));
		Session::put('brdto', date('Y-m-d'));
	?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
            @if (Entrust::can('create_buyerinfo'))
            <a href="{{ url('/buyerinfo/buyerhelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
           <a href="{{ URL::route('buyerinfo.create')}}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
<!--             <a href="{{ url('buyerinfo/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('buyerinfo/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('buyerinfo/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('buyerinfo/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('buyerinfo/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('buyerinfo/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
-->                
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['contact'] }}</th>
                        <th>{{ $langs['address'] }}</th>
                        <th>{{ $langs['country_id'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        @if (Entrust::can('update_buyerinfo'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_buyerinfo'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($buyerinfos as $item)
                {{-- */$x++;/* --}}
				<?php 
					//$country=array('' => 'Select ...', 1 => 'UK', 2 => 'USA');
					$disabled='';
					$buyer = DB::table('acc_lcinfos')
					->where('buyer_id', $item->id)
					->first(); 
					isset($buyer->buyer_id) && $buyer->buyer_id>0 ? $disabled='disabled' : $disabled='';
					//echo $disabled;
				?>

                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/lcinfo/report?buyer_id='. $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->contact }}</td>
                        <td>{{ $item->address }}</td>
                        <td><a href="{{ url('/lcinfo/report?country_id='. $item->country_id) }}">{{ $country[$item->country_id] }}</a></td>
                        <td>{{ $item->email }}</td>
                        @if (Entrust::can('update_buyerinfo'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('buyerinfo.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_buyerinfo'))
                        <td width="80">{!! Form::open(['route' => ['buyerinfo.destroy', $item->id], 'method' => 'DELETE']) !!}
                          @if ($disabled=="disabled")
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa disabled', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                          @else
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                          @endif

                            {!!  Form::close() !!}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#buyerinfo-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_buyerinfo")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_buyerinfo")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
