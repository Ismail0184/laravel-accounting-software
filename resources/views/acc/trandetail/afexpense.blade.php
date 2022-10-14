@extends('app')

@section('htmlheader_title', 'Daily Transaction')

@section('contentheader_title', 	  ' Daily Transaction')
@section('main-content')

<style>
    table.borderless td,table.borderless th{
     border: none !important;
	}

	h1{
		font-size: 1.6em;
	}
	h5{
		font-size: 1.2em; margin:0px
	}
	#unit {width: 10px} 
	#cur {width: 10px}
	.space { padding-left:30px; padding-right:30px}
</style>
<?php 
		function subhead($id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$sh=DB::table('acc_subheads')->where('com_id',$com_id)->where('id',$id)->first();
			if (isset($sh) && $sh->id>0 ):
				return $sh->name;
			else:
				return '';
			endif;
		}
		function has($id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$stock=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$id)->sum('qty');
			if (isset($stock) ):
				return $stock;
			else:
				return 0;
			endif;
		}
 ?>
 <div class="container">
 <div class="box" >
 <div class="box" >
         <div class="box-header">
        <a href="{{ url('invenmaster/ledger_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
        </div><!-- /.box-header -->

    <div class="table-responsive">
        <table class="table">
        <?php 
			isset($_GET['tdate']) ? Session::put('afdto',$_GET['tdate']) : '';
			
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 




			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="3"><h1 align="center">'.$com_name.'</h1></td></tr>';
			// data collection filter method by session	
			$data=array('dto'=>date('Y-m-d'));
			
			Session::has('afdto') ? $data=array('dto'=>Session::get('afdto')) : ''; 
		

				// for multiple account
				echo '<tr><td class="text-center" colspan="3"><h5>Advance For Expenses</h5><h5 >'.$data['dto'].'</h5></td></tr>';
				$ttl='';
		?>
            <tr><td colspan="3"><a href="{!! url('/trandetail/afexpense?flag=filter') !!}"> Filter  </a>
        					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['prod_id']) ? $data['prod_id']='' : '' ;
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'trandetail/affilter', 'class' => 'form-horizontal']) !!}
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto',$data['dto'], ['class' => 'form-control','required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['find'], ['class' => 'btn btn-primary form-control']) !!}
                                </div>    
                            </div>
                          {!! Form::close() !!}
                     @endif

        </td></tr>
                          <tr>
                  	<th class="col-sm-2 text-center">{{ $langs['sl'] }}</th>
                    <th class="col-sm-6">{{ $langs['acc_id'] }}</th>
                    <th class="col-sm-4 text-right">{{ $langs['balance'] }}</th>
                  </tr>
                  {{-- */$x=0;/* --}}
                    @foreach($advance as $val)
                    {{-- */$x++;/* --}}
                        {{-- */ $ttl += $val->amount /* --}}
                        @if($val->amount!=0)
                    	<tr>
                        	<td class="text-center"> {{ $x }}</td>
                            <td><a href="{{ url('/tranmaster/subhead?sh_id='.$val->sh_id) }}">@if(isset($val->subhead->name)){{ $val->subhead->name }}@endif</a></td>
                            <td class="col-sm-4 text-right">{{ number_format($val->amount,2) }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr><td class="text-right" colspan="2">Total</td><td class="text-right">{{ $ttl!=0 ? number_format($ttl,2) :  ''}}</td></tr>
                    </table>

        </div>
     </div>
</div>
@endsection

@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".trandetail").validate();
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
        $( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
