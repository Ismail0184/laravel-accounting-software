@extends('app')

@section('htmlheader_title', 'Reconciliations')

@section('contentheader_title', 'Reconciliations')

@section('main-content')
	<?php 
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		
			$data=array('pmfd'=>'0000-00-00','pmld'=>'0000-00-00');
			Session::has('rpmfd') ? 
			$data=array('pmfd'=>Session::get('rpmfd'),'pmld'=>Session::get('rpmld')) : ''; 
	?>	
    <div class="box">
        <div class="box-header">
        <h3 style="margin:0px; padding:0px" class="pull-left">{{ $com_name }}</h3><br><br>
            <a href="{{ url('/reconciliation?flag=filter') }}" class="btn btn-primary pull-left btn-sm">{{ $langs['filter'] }}</a>
            @if (Entrust::can('create_reconciliation'))
            <a href="{{ URL::route('reconciliation.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Reconciliation</a>
            @endif
					<?php 
						$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'reconciliation/rdatefilter', 'class' => 'form-horizontal']) !!}
            				<table><tr><td style="width:400px">
                    		<div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  null, ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto',  date('Y-m-d'), ['class' => 'form-control', 'id'=>'dto', 'required']) !!}
                                </div>    
                            </div>                            
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['find'], ['class' => 'btn btn-primary form-control']) !!}
                                </div>    
                            </div>
                            </td></tr></table>
                          {!! Form::close() !!}
                     @endif
               
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="reconciliation-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['bankname'] }}</th>
                        <th>{{ $langs['tdate'] }}</th>
                        <th>{{ $langs['acc_id'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        <th>{{ $langs['ttype'] }}</th>
						<th>{{ $langs['note'] }}</th>
                        @if (Entrust::can('update_reconciliation'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_reconciliation'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php 
					$reconciliations=DB::table('acc_reconciliations')->where('com_id',$com_id)
					->whereBetween('tdate', [$data['pmfd'], $data['pmld']])->get(); 
				?>
                @foreach($reconciliations as $item)
                    {{-- */$x++;/* --}}
                    <?php 
						$bank=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$item->acc_id)->first();
						$bank_name=''; isset($bank) && $bank->id > 0 ? $bank_name=$bank->name : $bank_name='';

						$coa=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$item->tranwith_id)->first();
						$coa_name=''; isset($coa) && $coa->id > 0 ? $coa_name=$coa->name : $coa_name='';
					?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/reconciliation', $item->id) }}">{{ $bank_name }}</a></td>
                        <td>{{ $item->tdate }}</td>
                        <td>{{ $coa_name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->ttype }}</td>
                        <td>{{ $item->note }}</td>
                        @if (Entrust::can('update_reconciliation'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('reconciliation.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_reconciliation'))
                        <td width="80">{!! Form::open(['route' => ['reconciliation.destroy', $item->id], 'method' => 'DELETE']) !!}
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
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
        $( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

        $("#reconciliation-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php if (Entrust::can("update_reconciliation")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_reconciliation")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
