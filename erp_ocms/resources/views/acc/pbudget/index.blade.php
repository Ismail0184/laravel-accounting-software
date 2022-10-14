@extends('app')

@section('htmlheader_title', 'Pbudgets')

@section('contentheader_title', 'Project budget')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/pbudget/pbudgethelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_pbudget'))
            <a href="{{ URL::route('pbudget.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Pbudget</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="pbudget-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['pro_id'] }}</th>
                        <th>{{ $langs['seg_id'] }}</th>
                        <th>{{ $langs['prod_id'] }}</th>
                        <th class="text-right">{{ $langs['qty'] }}</th>
                        <th class="text-right">{{ $langs['rate'] }}</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                        @if (Entrust::can('update_pbudget'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_pbudget'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($pbudgets as $item)
                	<?php 

					$project=''; $pro=DB::table('acc_projects')->where('id',$item->pro_id)->first(); isset($pro) && $pro->id>0 ? $project=$pro->name: $project='';
					$pplanning=''; $prop=DB::table('acc_pplannings')->where('id',$item->seg_id)->first(); isset($prop) && $prop->id>0 ? $pplanning=$pro->name: $pplanning='';
					$product=''; $prod=DB::table('acc_products')->where('id',$item->prod_id)->first(); isset($prod) && $prod->id>0 ? $product=$prod->name: $product='';
					//echo $product;
					?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/pbudget', $item->id) }}">{{ $project }}</a></td>
                        <td>{{ $pplanning }}</td>
                        <td>{{ $product }}</td>
                        <td class="text-right">{{ $item->qty. ' (' . $units[$item->unit_id] .')'}}</td> 
                        <td class="text-right" >{{ $currency[$item->cur_id].'    '.$item->rate }}</td> 
                        <td class="text-right">{{ $currency[$item->cur_id].'    '. $item->amount }}</td>   
                                             
                        @if (Entrust::can('update_pbudget'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('pbudget.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_pbudget'))
                        <td width="80">{!! Form::open(['route' => ['pbudget.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#pbudget-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php if (Entrust::can("update_pbudget")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_pbudget")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
