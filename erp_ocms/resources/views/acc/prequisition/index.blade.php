@extends('app')

@section('htmlheader_title', 'Purchase Requisitions')

@section('contentheader_title', 'Requisitions')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 style="margin:0px; padding:0px">{{ $com_name }}</h3>
            @if (Entrust::can('create_prequisition'))
            <h4 style="margin:0px; padding:0px"> 
            	<?php 
					$marq_text='';
					$preq = DB::table('acc_prequisitions')
					->where('check_id',Auth::user()->id)
					->where('com_id',$com_id)
					->where('check_id',Auth::id())
					->where('check_action',0)
					->first(); 
					isset($preq->name) ?
					$marq_text="<a href='prequisition/$preq->id' >".$preq->name.'- Tk '. number_format($preq->ramount,2).'-'.$preq->description.'-created by '.$users[$preq->user_id]."</a>" : '';
					?>
                <marquee behavior="scroll" direction="left" width=80%><?php echo $marq_text ?></marquee> 
                <a href="{{ url('/prequisition/prequisitionhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
                <a href="{{ URL::route('prequisition.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Requisition</a>
             </h4>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="prequisition-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['description'] }}</th>
                        <th class="text-right">{{ $langs['ramount'] }}</th>
                        <th>{{ $langs['rtypes'] }}</th>
                        @if (Entrust::can('update_prequisition'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_prequisition'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($prequisitions as $item)
                	<?php $item->check_action==1 ? $disabled="disabled" : $disabled=""; $rtypes=array(''=>'Select ...', 'n' => 'Normal', 'u' => 'Urgent', 'tu' => 'Top Urgent'); 
						$item->ramount> 0 ? $item->ramount=number_format($item->ramount,2) : '';
					?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/prequisition', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->description }}</td>
                        <td class="text-right">{{ $item->ramount }}</td>
                        <td>{{ $rtypes[$item->rtypes] }}</td>
                        @if (Entrust::can('update_prequisition'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('prequisition.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_prequisition'))
                        <td width="80">{!! Form::open(['route' => ['prequisition.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#prequisition-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if (Entrust::can("update_prequisition")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_prequisition")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
