@extends('app')

@section('htmlheader_title', 'Companies')

@section('contentheader_title', 'Companies')

@section('main-content')
	<?php 
			//$result=Config::get('com.id'); echo $result.'osama';
		$setting='';
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ; //echo $com_id.'osama';
		
		Session::has('tmdfrom') ? ''  : 
		Session::put('tmdfrom', date('Y-m-d'));
		Session::put('tmdto', date('Y-m-d'));

	?>
    <style>
    	#setted { background-color:#CCF}
    </style>
    <div class="box">
        <div class="box-header">
        	<a href="{{ url('/company/companyhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_company'))
            <a href="{{ URL::route('company.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Company</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="company-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['oaddress'] }}</th>
                        <th>{{ $langs['mobile'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        <th>{{ $langs['web'] }}</th>
                        <th>{{ $langs['setting'] }}</th>
                        @if (Entrust::can('update_company'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_company'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php 
				$companies=DB::table('acc_usercompanies')
				->join('acc_companies', 'acc_usercompanies.com_id', '=', 'acc_companies.id')
				->where('acc_usercompanies.users_id', Auth::id())->get();
				?>
                @foreach($companies as $item)
                    {{-- */$x++;/* --}}
                    <?php 	
					$com_id== $item->id ? $setting='setted' : $setting=''; 
					$item->ctype==1 ? $disabled='disabled' : $disabled='';
					?>
                    <tr id="{{ $setting }}">
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/company', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->oaddress }}</td>
                        <td>{{ $item->mobile }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->web }}</td>
                        <td>
                         {!! Form::open(['url' => 'company/filter', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                {!! Form::hidden('com_id',$item->id ) !!}
                                {!! Form::submit($langs['setting'], ['class' => 'btn btn-primary form-control']) !!}
                                </div>    
                            </div>
                         {!! Form::close() !!}
                        </td>
                        @if (Entrust::can('update_company'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('company.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_company'))
                        <td width="80">{!! Form::open(['route' => ['company.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', $disabled, 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#company-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php if (Entrust::can("update_company")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_company")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
