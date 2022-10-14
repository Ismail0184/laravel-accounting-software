@extends('app')

@section('htmlheader_title', ' B2B')

@section('contentheader_title', 'B2B Trnsaction')

@section('main-content')
    
    {!! Form::open(['route' => 'lcinfo.store', 'class' => 'form-horizontal']) !!}
    				<?php 	 
					Session::has('com_id') ? 
					$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
					$option=DB::table('acc_options')->where('com_id',$com_id)->first(); 
					$currency_id=''; isset($option) && $option->id > 0 ? $currency_id=$option->currency_id : $currency_id='';
					$check_id=''; isset($option) && $option->id > 0 ? $check_id=$option->tcheck_id : $check_id='';
					
					$dacc_id=''; isset($option) && $option->id > 0 ? $dacc_id=$option->b2btd_id : $dacc_id=''; //echo $dacc_id.'hasan';
					$cacc_id=''; isset($option) && $option->id > 0 ? $cacc_id=$option->mlctd_id : $cacc_id='';
					// firnd b2b transaction 
						$find=DB::table('acc_trandetails')->where('com_id',$com_id)
						->where('acc_id',$dacc_id)->where('b2b_id', $b2b->id)->first(); 
						$find_data='no';isset($find) && $find->id>0 ? $find_data='yes' : $find_data='no';
						$flag='';
						if (isset($find) && $find->id>0 ):
							$dacc_id=$b2b->acc_id;
							$cacc_id=$option->b2btd_id;
							$flag='Products delivery, ';
						endif;

					$cur=DB::table('acc_currencies')->where('id',$currency_id)->first();
					$cur_name=''; isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name=''; 
					$vnumber = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;
					 
					if (isset($b2b) && $b2b->id > 0):
						$lc=DB::table('acc_lcinfos')->where('id',$b2b->lc_id)->first();
						$lc_value=''; isset($lc) && $lc->id>0 ? $lc_value=$lc->lcamount: $lc_value='';
						$crateto=$lc->crateto;
						
						$client=DB::table('acc_clients')->where('id',$b2b->client_id)->first();
						$client_name=''; isset($client) && $client->id > 0 ? $client_name=$client->name : $client_name='';
						

						$cur=DB::table('acc_currencies')->where('id',$lc->currency_id)->first(); 
						$curname=''; isset($cur) && $cur->id > 0 ? $curname=$cur->name : $curname=''; //echo $lc->crateto;
						
						$amount=''; $lc_value!='' && $b2b->crateto!='' ? $amount=$b2b->bamount * $lc->crateto : $amount='';
						$note=$flag. 'B2B LC No: '.$b2b->blcnumber. ', LC Value : '. $b2b->bamount. '('.$curname.'), Convertion Rate : '. $lc->crateto. '('.$cur_name.'), LC date: '. $lc->lcdate. ', Client: '. $client_name;
					endif;
					
					?>

   		 			<div class="form-group">
                        {!! Form::label('acc_id', $langs['daccount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $acccoa, $dacc_id, ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('vnumber', $vnumber, ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('flag', $flag, ['class' => 'form-control', 'required']) !!}
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
                            {!! Form::hidden('lc_id', $b2b->lc_id, ['class' => 'form-control']) !!}
                            {!! Form::hidden('b2b_id', $b2b->id, ['class' => 'form-control']) !!}
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