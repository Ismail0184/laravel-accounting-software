@extends('app')

@section('htmlheader_title', 'Collection')

@section('contentheader_title', 'Payment')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ url('purchasemaster/collection_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="empolyee-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="4"><a href="{!! url('/purchasemaster/payment?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'purchasemaster/payfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $acccoa, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  date('Y-m-01'), ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
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
                          {!! Form::close() !!}
                     @endif
               </td></tr>

                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php $ttl=''; ?>
                @foreach($collections as $item)
                	<?php 
						$amount=$item->amount < 0 ? substr($item->amount,1) : $item->amount; 
						$amounts=$amount!='' || $amount!=0 ? number_format($amount,2) : '';
					?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td >{{ $item->name }}</td>
                        <td class="text-right">{{ $amounts }}</td>

                    </tr>
                     <?php 
						$ttl += $item->amount;  ?>
                @endforeach
                    <?php 
						$ttl=$ttl < 0 ? substr($ttl,1) : $ttl;
						$ttls= $ttl!='' || $ttl!=0 ? number_format($ttl,2) : '';
					?>
                    <tr>
                        <td width="50"></td>
                        <td class="text-right">Total</td>
                        <td class="text-right">{{ $ttls }}</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
