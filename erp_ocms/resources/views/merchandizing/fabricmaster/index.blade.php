@extends('app')

@section('htmlheader_title', 'Fabricmasters')

@section('contentheader_title', 'Fabrication')

@section('main-content')
<?php  
		Session::has('jobno') ?  $jobno=Session::get('jobno') : $jobno='';
		Session::has('booking_id') ?  $book_id=Session::get('booking_id') : $book_id='';
		$dmus=array('1'=>'Inch', '2'=>'CM');
?>
    <div class="box">
        <div class="box-header">
        	<h3 class="pull-left" style="margin:0px; padding:0px">@if(isset($company->name)){{ $company->name}}@endif</h3>
            		<div class="form-group col-sm-6">
                        <form class="navbar-form" role="search" action="{{  url('/fabricmaster/find') }}">
                            <div class="form-group col-sm-8" style="padding-right:0px; padding-left:0px"> 
                                {!! Form::select('jobno', $find_jobno, null, ['class' => 'form-control select2', 'required']) !!}
                            </div> 
                            <div class="form-group col-sm-4" style="padding-right:0px; padding-left:0px"> 
                                {!! Form::submit($langs['find'], ['class' => 'btn btn-primary form-control']) !!}
                            </div>
                        </form>    
                    </div>
          @if(count($po_list)>0)
          <div class="callout callout-info col-sm-12">
            <h4>Create Booking From PO List!</h4>
            <form class="navbar-form" role="search" action="{{  url('/fabricmaster/booking') }}">
            @foreach($po_list as $item)
                    <div class="form-group col-sm-12">
                        {!! Form::checkbox('pono[]', $item->pono, null, ['class' => 'form-field']) !!}
                        {!! Form::hidden('jobno', $jobno, ['class' => 'form-control']) !!}
                        {!! Form::hidden('booking', $booking_count, ['class' => 'form-control']) !!}
                        {!! Form::label('pono', $item->pono) !!}
                    </div>
            @endforeach
            <div class="form-group">
                <div class="form-group col-sm-1" style="padding-right:0px; padding-left:0px"> 
                    {!! Form::submit('Create '.$langs['booking_id'].' No '.$booking_count, ['class' => 'btn btn-primary form-control']) !!}
                </div>
            </div>
            </form> 
            
          </div>
          @endif
            <div>
                @if (Entrust::can('create_fabricmaster') && $book_id!='')
                <a href="{{ URL::route('fabricmaster.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} DIA</a>
                @endif
			</div>
                <div class="form-group col-sm-4">
                   <div class="btn-group success">
                      <button type="button" class="btn btn-success">Booking No</button>
                      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
            			@foreach($booking_id as $item)
            	            <li><a href="{{ url('/fabricmaster?booking_id='. $item->booking) }}">Booking No {{ $item->booking }}</a></li>
			            @endforeach
                      </ul>
                    </div>
				</div>

        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="fabricmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['jobno'] }}</th>
                        <th>{{ $langs['booking_id'] }}</th>
                        <th>{{ $langs['gtype_id'] }}</th>
                        <th>{{ $langs['pogarment_id'] }}</th>
                        <th>{{ $langs['dia_sl'] }}</th>
                        <th>{{ $langs['diatype_id'] }}</th>
                        <th>{{ $langs['dia_id'] }}</th>
                        <th>{{ $langs['gsm_id'] }}</th>
                        <th>{{ $langs['ftype_id'] }}</th>
                        <th>{{ $langs['ycount_id'] }}</th>
                        <th>{{ $langs['consumption'] }}</th>
                        <th>{{ $langs['wastage'] }}</th>
						<th>{{ $langs['details'] }}</th>
                        @if (Entrust::can('update_fabricmaster'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_fabricmaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($fabricmasters as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->jobno }}</td>
                        <td>{{ $item->booking_id }}</td>
                        <td>@if(isset($item->gtype->name)){{ $item->gtype->name }}@endif</td>
                        <td>@if(isset($item->pogarment->name)){{ $item->pogarment->name }}@endif</td>
                        <td>{{ $item->dia_sl }}</td>
                        <td>@if(isset($diatypes[$item->diatype_id])){{ $diatypes[$item->diatype_id] }}@endif</td>
                        <td>@if(isset($item->dia->name)){{ $item->dia->name }}@endif/@if(isset($dmus[$item->dmu_id])){{ $dmus[$item->dmu_id] }}@endif</td>
                        <td>@if(isset($item->gsm->name)){{ $item->gsm->name }}@endif</td>
                        <td>@if(isset($item->ftype->name)){{ $item->ftype->name }}@endif</td>
                        <td>@if(isset($item->ycount->name)){{ $item->ycount->name }}@endif</td>
                        <td>{{ $item->consumption }}</td>
                        <td>{{ $item->wastage }}</td>
                        <td><a href="{{ url('/fabricmaster', $item->id) }}">Color and Size</a></td>
                        @if (Entrust::can('update_fabricmaster'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('fabricmaster.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_fabricmaster'))
                        <td width="80">{!! Form::open(['route' => ['fabricmaster.destroy', $item->id], 'method' => 'DELETE']) !!}
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
       <!-- $("#fabricmaster-table").dataTable({
    		//"aoColumns": [ null, null, null, null, null, null, null, null, null, null, null, null, null<?php if (Entrust::can("update_fabricmaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_fabricmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	//});-->
		
    } );
</script>

@endsection
