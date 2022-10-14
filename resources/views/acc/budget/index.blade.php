@extends('app')

@section('htmlheader_title', 'Budgets')

@section('contentheader_title', 'Budgets')

@section('main-content')

	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/budget/budgethelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_budget'))
            <a href="{{ URL::route('budget.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Budget</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
             
          
            <table id="budget-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                         <th>{{ $langs['account_id'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        <th>{{ $langs['btype'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_budget'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_budget'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($budgets as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                    	<?php 
							$coa=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$item->acc_id)->first(); //echo $coa->name;
							$coa_name='';isset($coa) && $coa->id >0 ? $coa_name=$coa->name: $coa_name='';
						?>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/budget', $item->id) }}">{{ $coa_name }}</a></td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->btype }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_budget'))
						<td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('budget.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td>                         @endif
                        @if (Entrust::can('delete_budget'))
                        <td width="80">{!! Form::open(['route' => ['budget.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#budget-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if (Entrust::can("update_budget")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_budget")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
