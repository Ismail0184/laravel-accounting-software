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
					
					$dacc_id=''; isset($option) && $option->id > 0 ? $dacc_id=$option->mlctd_id : $dacc_id='';
					$cacc_id=''; isset($option) && $option->id > 0 ? $cacc_id=$option->mlctc_id : $cacc_id='';
					
					$cur=DB::table('acc_currencies')->where('id',$currency_id)->first();
					$cur_name=''; isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name=''; 
					$vnumber = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1; 
					if (isset($lcinfo) && $lcinfo->id > 0):
						$buyer=DB::table('acc_buyerinfos')->where('id',$lcinfo->buyer_id)->first();
						$buyer_name=''; isset($buyer) && $buyer->id > 0 ? $buyer_name=$buyer->name : $buyer_name='';
						$crateto=$lcinfo->crateto;
						$cur=DB::table('acc_currencies')->where('id',$lcinfo->currency_id)->first(); 
						$curname=''; isset($cur) && $cur->id > 0 ? $curname=$cur->name : $curname='';
						
						$amount=''; $lcinfo->lcamount!='' && $lcinfo->crateto!='' ? $amount=$lcinfo->lcamount * $lcinfo->crateto : $amount='';
						$note='LC No: '.$lcinfo->lcnumber. ', LC Value : '. $lcinfo->lcamount. '('.$curname.'), Convertion Rate : '. $lcinfo->crateto. '('.$cur_name.'), LC date: '. $lcinfo->lcdate. ', Buyer: '. $buyer_name;
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
                            {!! Form::hidden('lc_id', $lcinfo->id, ['class' => 'form-control','size' => '5x3']) !!}
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