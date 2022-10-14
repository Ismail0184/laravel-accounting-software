@extends('app')

@section('htmlheader_title', 'Cash Flow')

@section('contentheader_title', 'Cash Flow Direct Method')

@section('main-content')
<?php 
			Session::has('dto') ? 
			$data=array('dfrom'=>Session::get('cfdfrom'),'dto'=>Session::get('cfdto')) : 
			$data=array('dfrom'=>date('Y-m-01'),'dto'=>date('Y-m-d'));''; 

?>
    <div class="box">
        <div class="box-header">
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="desigtn-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/trandetail/cashflowd?flag=filterd') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filterd')
                           {!! Form::open(['url' => 'trandetail/filterd', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  $data['dfrom'], ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto',  $data['dto'], ['class' => 'form-control', 'id'=>'dto', 'required']) !!}
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
                        <th>Description</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($transaction as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td width="350"><b>{{ $item }}</b></td>
                        <td width="100" class="text-right"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

