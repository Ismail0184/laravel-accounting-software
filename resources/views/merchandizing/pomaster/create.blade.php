@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Pomaster')

@section('contentheader_title', $langs['create_new'] . ' PO')

@section('main-content')
 <div class="box">

        <div class="box-header">
        </div><!-- /.box-header -->
    {!! Form::open(['route' => 'pomaster.store', 'class' => 'form-horizontal pomaster']) !!}
    		<div class="col-sm-6">
    				<div class="form-group">
                        {!! Form::label('pono', $langs['pono'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('pono',  null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
    				<div class="form-group">
                        {!! Form::label('order_id', $langs['order_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('order_id', $orders, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('po_rcvd_date', $langs['po_rcvd_date'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('po_rcvd_date', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('factory_ship_date', $langs['factory_ship_date'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('factory_ship_date', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('shipment_date', $langs['shipment_date'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('shipment_date', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>

             </div>
             <div class="col-sm-6"> 
					<div class="form-group">
                        {!! Form::label('qty', $langs['qty'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-4" style="padding-right:0px; margin-right:0px"> 
                            {!! Form::text('qty', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                        <div class="col-sm-2" style="padding-left:0px; margin-left:0px"> 
                            {!! Form::select('unit_id', $units, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('color_count', $langs['color_count'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('color_count', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('size_count', $langs['size_count'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('size_count', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-3">
                            {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
                        </div>    
                    </div>

			</div>
    {!! Form::close() !!}
            <div class="box-footer">
        </div><!-- /.box-header -->

</div>
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection

@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".pomaster").validate();
		$( "#po_rcvd_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#factory_ship_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#shipment_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
