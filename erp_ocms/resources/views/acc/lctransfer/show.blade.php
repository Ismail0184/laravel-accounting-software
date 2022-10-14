@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Lcinfo')

@section('contentheader_title', $langs['edit'] . ' Trnsaction')

@section('main-content')
    
    {!! Form::open(['route' => 'lcinfo.store', 'class' => 'form-horizontal']) !!}
    				<?php 	 
					Session::has('com_id') ? 
					$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
					$option=DB::table('acc_options')->where('com_id',$com_id)->first(); 
					$currency_id=''; isset($option) && $option->id > 0 ? $currency_id=$option->currency_id : $currency_id='';
					$check_id=''; isset($option) && $option->id > 0 ? $check_id=$option->tcheck_id : $check_id='';

					$find=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id',$option->tlctd_id)->first();
					
					isset($find) && $find->id > 0 ? $flag='yes' : $flag=''; //echo $flag;
					

					$dacc_id=''; isset($option) && $option->id > 0 ? $dacc_id=$option->tlctd_id : $dacc_id='';
					$cacc_id=''; isset($option) && $option->id > 0 ? $cacc_id=$option->tlctc_id : $cacc_id='';
					if ($flag=='yes'):
						$dacc_id=''; isset($option) && $option->id > 0 ? $dacc_id=$option->mlctc_id : $dacc_id='';
						$cacc_id=''; isset($option) && $option->id > 0 ? $cacc_id=$option->tlctd_id : $cacc_id='';
					endif;
					
					$cur=DB::table('acc_currencies')->where('id',$currency_id)->first();
					$cur_name=''; isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name=''; 
					$vnumber = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1; 
					if (isset($lctransfer) && $lctransfer->id > 0):
						$lc=DB::table('acc_lcinfos')->where('id',$lctransfer->lc_id)->first();
						$lc_value=''; isset($lc) && $lc->id>0 ? $lc_value=$lc->lcamount: $lc_value='';

						$buyer=DB::table('acc_buyerinfos')->where('id',$lc->buyer_id)->first();
						$buyer_name=''; isset($buyer) && $buyer->id > 0 ? $buyer_name=$buyer->name : $buyer_name='';
						$crateto=$lctransfer->crateto;

						$cur=DB::table('acc_currencies')->where('id',$lc->currency_id)->first(); 
						$curname=''; isset($cur) && $cur->id > 0 ? $curname=$cur->name : $curname='';
						
						$client=DB::table('acc_clients')->where('id',$lctransfer->client_id)->first();
						$client_name=''; isset($client) && $client->id>0 ? $client_name=$client->name : $client_name='';

						$amount=''; $lc_value!='' && $lctransfer->crateto!='' ? $amount=$lc_value * $lctransfer->crateto : $amount='';
						$note='LC No: '.$lc->lcnumber. ', LC Value : '. $lc_value. '('.$curname.'), Convertion Rate : '. $lctransfer->crateto. '('.$cur_name.'), LC date: '. $lc->lcdate. ', Buyer: '. $buyer_name .', Client : '.$client_name;
					endif;
					
					?>

   		 			<div class="form-group">
                        {!! Form::label('acc_id', $langs['daccount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $acccoa, $dacc_id, ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('vnumber', $vnumber, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tdate', $langs['tdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tdate', date('Y-m-d'), ['class' => 'form-control', 'required', 'id' => 'lcdate']) !!}
								<!--{!! Form::text('date', null, array('id' => 'datepicker')) !!} -->                       
                         </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('amount', $langs['lcamount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tmamount', $amount, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', $currency, $currency_id, ['class' => 'form-control'], 'required') !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('crateto', $langs['crateto'].' '.$cur_name, ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('crateto', $crateto, ['class' => 'form-control','number']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('note', $note, ['class' => 'form-control','size' => '5x3']) !!}
                            {!! Form::hidden('lc_id', $lc->id, ['class' => 'form-control','size' => '5x3']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tranwith_id', $langs['caccount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('tranwith_id', $acccoa, $cacc_id, ['class' => 'form-control',]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id', $users, $check_id, ['class' => 'form-control',]) !!}
                        </div>    
                    </div>

    
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit($langs['crtran'], ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection
@section('custom-scripts')

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#lcdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
	 $( "#shipmentdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
	  $( "#expdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
  });
  </script>

@endsection