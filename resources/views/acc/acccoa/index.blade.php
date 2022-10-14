@extends('app')

@section('htmlheader_title', 'COA')

@section('contentheader_title', 'Chart of Account')

@section('main-content')
<style>
	#second { padding-left:50px}
	#third { padding-left:30px}
	#forth { padding-left:30px}
	#sl {  width:50px; text-align:right }
	#sl2 {  width:100px; text-align:right }
</style>
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';

		$user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
		$permission=array();
        if($user_only && !$admin_user) {
			$permission=array('user_id'=>Auth::id());
			}
		
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/acccoa/acchelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_lcinfo'))
            <a href="{{ URL::route('acccoa.create')}}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('acccoa/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
<!--             <a href="{{ url('acccoa/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('acccoa/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
           <a href="{{ url('acccoa/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('acccoa/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('acccoa/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
            @endif
            
        </div><!-- /.box-header -->
-->        <div class="box-body">
            <table id="acccoa-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th colspan="5">{{ $langs['name'] }}</th>
                        <th class="text-center">Type</th>
                        @if($admin_user) 
                        <th>{{ $langs['user'] }}</th>
                        @endif
                        @if (Entrust::can('update_acccoa'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_acccoa'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                <!--{{-- */$x=0;/* --}}-->

                @foreach($acccoas as $item)  <!-- first level-->
                    {{-- */$x++;/* --}}
                    <?php 
						$child=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item->id)->first();
						$disabled=''; isset($child) && $child->id > 0 ? $disabled="disabled" : $disabled='';
						if ($disabled==''): //echo $item->id;
							$trans=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id',$item->id)->first();
							isset($trans) && $trans->id > 0 ? $disabled="disabled" : $disabled='';
						endif;
					?>
                   
                    <tr>
                        <td width="50" id="clr">{{ $x }}</td>
                        <td colspan="5"><a href="{{ url('/acccoa', $item->id) }}"><?php  echo $item->name; ?></a> 
                        <a href="{{ url('/acccoa/create?g='.$item->id.'&&tg='.$item->topGroup_id) }}" class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i></a>
                        </td>
						<td width="80" class="text-center">{{ $item->atype }}
                        </td> 

                        @if($admin_user) 
                        <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                        @endif
                        @if (Entrust::can('update_acccoa'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('acccoa.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_acccoa'))
                        <td width="80">{!! Form::open(['route' => ['acccoa.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled,'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                        @endif
                    </tr>
                                <?php
                                	$record = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item->id)->orderby('sl')->get();
                                ?>           
                            @foreach($record as $item) <!-- Second level-->
                                <!--{{-- */$x++;/* --}}-->
                                <?php 
									$groupHead = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $item->group_id)->first();
									$child=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item->id)->first();
									$disabled=''; isset($child) && $child->id > 0 ? $disabled="disabled" : $disabled='';
												if ($disabled==''): //echo $item->id;
													$trans=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id',$item->id)->first();
													isset($trans) && $trans->id > 0 ? $disabled="disabled" : $disabled='';
												endif;
								?>
                                <tr>
                                    <td width="50">{{ $x }}</td>
                                    <td id="sl">{{ $item->sl }}</td>
                                    <td id="second" colspan="4"><a href="{{ url('/acccoa', $item->id) }}">{{ $item->name }}</a>
                                        @if($item->atype<>'Group') 
                                             <a href="{{ url('/coacondition/create?acc_id='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['cond_id'] }}</a>
                                             @if($groupHead->name=='Bills Receivable' && $item->name=='Sundry Debtors') 
                                            	<a href="{{ url('/coadetail/create?id='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['detail_id'] }}</a>
                                             @endif
                                        @endif                                    
                            		@if($item->atype<>'Account')
                                    <a href="{{ url('/acccoa/create?g='.$item->id.'&&tg='.$item->topGroup_id) }}" class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i></a>
                                    @endif
                                    </td>
                                    <td width="80" class="text-center">{{ $item->atype }}</td> 
                                    @if($admin_user) 
                                    <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                                    @endif

                        			@if (Entrust::can('update_acccoa'))
                        			<td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('acccoa.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        			@endif
                        			@if (Entrust::can('delete_acccoa'))
                                    <td width="80">{!! Form::open(['route' => ['acccoa.destroy', $item->id], 'method' => 'DELETE']) !!}
                            			{!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled,'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                                        {!!  Form::close() !!}</td>
                                    @endif

                                </tr>
											 <?php
                                            	$record = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item->id)->orderby('sl')->get();
                                            ?>           
                                        @foreach($record as $item) <!-- third level -->
                                            <!--{{-- */$x++;/* --}}-->
                                           <?php 
												$groupHead = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $item->group_id)->first();
												$child=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item->id)->first();
												$disabled=''; isset($child) && $child->id > 0 ? $disabled="disabled" : $disabled='';
												if ($disabled==''):
													$trans=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id',$item->id)->first();
													isset($trans) && $trans->id > 0 ? $disabled="disabled" : $disabled='';
												endif;
												
											?>
                                           <tr>
                                                <td width="50">{{ $x }}</td>
                                                <td id="sl"></td>
                                                <td id="sl">{{ $item->sl }}</td>
                                                <td id="third" colspan="3"><a href="{{ url('/acccoa', $item->id) }}">{{ $item->name }}</a>
                                                    @if($item->atype<>'Group') 
                                                         <a href="{{ url('/coacondition/create?acc_id='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['cond_id'] }}</a>
                                                             @if($groupHead->name=='Bills Receivable' && $groupHead->name=='Sundry Debtors') 
                                                                <a href="{{ url('/coadetail/create?id='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['detail_id'] }}</a>
                                                             @endif                                                    
                                                    @endif                                    
                            					@if($item->atype<>'Account')
                                                    <a href="{{ url('/acccoa/create?g='.$item->id.'&&tg='.$item->topGroup_id) }}" class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i></a>
                                                @endif
                                                </td>
                                                <td width="80" class="text-center">{{ $item->atype }}</td> 
                                                @if($admin_user) 
                                                <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                                                @endif

                        						@if (Entrust::can('update_acccoa'))
                        						<td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('acccoa.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                                                @endif
                                                @if (Entrust::can('delete_acccoa'))
                                                <td width="80">{!! Form::open(['route' => ['acccoa.destroy', $item->id], 'method' => 'DELETE']) !!}
                            						{!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled,'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                                                    {!!  Form::close() !!}</td>
                                                @endif

                                            </tr>
                                            			<?php
																$recordn = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item->id)->orderby('sl')->get();
														?>           
														@foreach($recordn as $item) <!-- Forth level -->
															<!--{{-- */$x++;/* --}}-->
                                                            <?php 
																$groupHead = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $item->group_id)->first(); //echo $groupHead->name;
																$child=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item->id)->first();
																$disabled=''; isset($child) && $child->id > 0 ? $disabled="disabled" : $disabled='';
																if ($disabled==''):
																	$trans=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id',$item->id)->first();
																	isset($trans) && $trans->id > 0 ? $disabled="disabled" : $disabled='';
																endif;

															?>
															<tr>
																<td width="50">{{ $x }}</td>
                                                                <td id="sl"></td>
                                                                <td id="sl"></td>
                                                				<td id="sl">{{ $item->sl }}</td>
																<td id="forth" colspan="2"><a href="{{ url('/acccoa', $item->id) }}">{{ $item->name }}</a>
                                                                @if($item->atype<>'Group') 
                                                                     <a href="{{ url('/coacondition/create?acc_id='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['cond_id'] }}
                                                                     @if($groupHead->name=='Bills Receivable' || $groupHead->name=='Sundry Debtors' || $groupHead->name=='Bank Account') 
                                                                        <a href="{{ url('/coadetail/create?id='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['detail_id'] }}</a>
                                                                     @endif
                                                                @endif  
                                                                @if($item->atype<>'Account') 
                            									<a href="{{ url('/acccoa/create?g='.$item->id.'&&tg='.$item->topGroup_id) }}" class="btn btn-primary pull-right btn-sm"><i class="fa fa-plus"></i></a>
                                                                @endif
                                                                <td width="80" class="text-center">{{ $item->atype }}</td> 
                                                                @if($admin_user) 
                                                                <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                                                                @endif

                        										@if (Entrust::can('update_acccoa'))
                        										<td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('acccoa.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                                                                @endif
                                                                @if (Entrust::can('delete_acccoa'))
																<td width="80">{!! Form::open(['route' => ['acccoa.destroy', $item->id], 'method' => 'DELETE']) !!}
                            										{!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled,'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
																	{!!  Form::close() !!}</td>
                                                                @endif
															</tr>
																			<?php
                                                                                    $record = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item->id)->orderby('sl')->get();
                                                                            ?>           
                                                                            @foreach($record as $item) <!-- fifth level -->
                                                                                <!--{{-- */$x++;/* --}}-->
                                                                                <?php 
                                                                                    $groupHead = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $item->group_id)->first(); //echo $groupHead->name;
																					$child=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item->id)->first();
																					$disabled=''; isset($child) && $child->id > 0 ? $disabled="disabled" : $disabled='';
																					if ($disabled==''):
																						$trans=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id',$item->id)->first();
																						isset($trans) && $trans->id > 0 ? $disabled="disabled" : $disabled='';
																					endif;

                                                                                ?>
                                                                                <tr>
                                                                                    <td width="50">{{ $x }}</td>
                                                                                    <td id="sl"></td>
                                                                                    <td id="sl"></td>
                                                                                    <td id="sl"></td>
                                                                                    <td id="sl">{{ $item->sl }}</td>
                                                                                    <td id="forth"><a href="{{ url('/acccoa', $item->id) }}">{{ $item->name }}</a>
                                                                                    @if($item->atype<>'Group') 
                                                                                         <a href="{{ url('/coacondition/create?acc_id='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['cond_id'] }}
                                                                                         @if($groupHead->name=='Bills Receivable' || $groupHead->name=='Sundry Debtors' || $groupHead->name=='Bank Account') 
                                                                                            <a href="{{ url('/coadetail/create?id='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['detail_id'] }}</a>
                                                                                         @endif
                                                                                    @endif                                    
                                                                                    <td width="80" class="text-center">{{ $item->atype }}</td> 
                                                                                    @if($admin_user) 
                                                                                    <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                                                                                    @endif

                                                                                    @if (Entrust::can('update_acccoa'))
                        															<td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('acccoa.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                                                                                    @endif
                                                                                    @if (Entrust::can('delete_acccoa'))
                                                                                    <td width="80">{!! Form::open(['route' => ['acccoa.destroy', $item->id], 'method' => 'DELETE']) !!}
                            															{!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled,'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                                                                                        {!!  Form::close() !!}</td>
                                                                                    @endif
                                                                                </tr>
                                                                            @endforeach <!-- fifth level -->
 
                                                        @endforeach <!-- Forth level -->
                                        @endforeach <!-- third level -->
                            @endforeach <!-- second level -->
                @endforeach <!-- first level -->
                
                
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#acccoa-table").dataTable({
    		//"aoColumns": [ null, null, null, { "bSortable": false }, { "bSortable": false } ] 
    		"aoColumns": [ null, null, null <?php if ($admin_user): ?>, { "bSortable": false }<?php endif; if (Entrust::can("update_acccoa")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_acccoa")): ?>, { "bSortable": false }<?php endif ?> ]

    	});
    } );
</script>

@endsection
