@extends('app')

@section('htmlheader_title', 'Products')
<style>
	#second { padding-left:50px}
	#third { padding-left:30px}
	#forth { padding-left:30px}
	#sl {  width:50px; text-align:right }

</style>
@section('contentheader_title', 'Products')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		Session::put('m_name',"product")		;
		
		$user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
		$permission=array();
        if($user_only && !$admin_user) {
			$permission=array('user_id'=>Auth::id());
			}
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/product/producthelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_product'))
            <a href="{{ URL::route('product.create')}}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
<!--            <a href="{{ url('product/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('product/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('product/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('product/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('product/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('product/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
-->            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="product-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th colspan="5">{{ $langs['name'] }}</th>
                        <th>{{ $langs['unit_id'] }}</th>
                        <th>{{ $langs['ptype'] }}</th>
                        <th>{{ $langs['image'] }}</th>
                        @if($admin_user) 
                        <th>{{ $langs['user'] }}</th>
                        @endif
                        @if (Entrust::can('update_product'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_product'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($products as $item) <!--first group-->
                <?php 
				   	$unit=DB::table('acc_units')->where('id', $item->unit_id)->first();
					$unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name: $unit_name='';
					$trans=DB::table('acc_products')->where('group_id',$item->id)->first();
					isset($trans) && $trans->id> 0 ? $disabled='disabled' : $disabled='';

					?>
                   <!-- {{-- */$x++;/* --}}-->
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td colspan="5><a href="{{ url('/product', $item->id) }}"><?php echo $item->sl.'    '. $item->name;  ?></a>
                            <a href="{{ url('/product/create?g='.$item->id.'&&tg='.$item->id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['addnew'] }}
                        </td>
                        <td width="80">{{ $unit_name }}</td>
                        <td width="80">{{ $item->ptype }}</td>
                        <td width="80"><a href="{{ url('/fileentry',$item->vnumber) }}">Upload</a></td>
                        @if($admin_user) 
                        <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                        @endif
                        @if (Entrust::can('update_product'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('product.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_product'))
                        <td width="80">{!! Form::open(['route' => ['product.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], $disabled, 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                        @endif
                    </tr>
                    		<?php $record = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                            @foreach($record as $item) <!--second group-->
                                <!--{{-- */$x++;/* --}}-->
							<?php 
                                $unit=DB::table('acc_units')->where('id', $item->unit_id)->first();
                                $unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name: $unit_name='';

									$trans=DB::table('acc_products')->where('group_id',$item->id)->first();
									isset($trans) && $trans->id> 0 ? $disabled='disabled' : $disabled='';
							
								if ($disabled==''):
									$inven=DB::table('acc_invendetails')->where('item_id',$item->id)->first();
									isset($inven) && $inven->id> 0 ? $disabled='disabled' : $disabled='';
									endif;
									

                                ?>
                                <tr>
                                    <td width="50">{{ $x }}</td>
                                    <td id="sl">{{ $item->sl }}</td>
                                    <td id="second" colspan="4"><a href="{{ url('/product', $item->id) }}">{{ $item->name }}</a>
                            		@if($item->ptype<>'Product')	
                                        <a href="{{ url('/product/create?g='.$item->id.'&&tg='.$item->topGroup_id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['addnew'] }}
                                    @endif
                                    </td>
                                    <td width="80">{{ $unit_name }}</td>
                                    <td>{{ $item->ptype }}</td>
                                    <td width="80"><a href="{{ url('/fileentry',$item->id) }}">Upload</a></td>
                                    @if($admin_user) 
                                    <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                                    @endif
                                    @if (Entrust::can('update_product'))
                                    <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('product.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                                    @endif
                                    @if (Entrust::can('delete_product'))
                                    <td width="80">{!! Form::open(['route' => ['product.destroy', $item->id], 'method' => 'DELETE']) !!}
                                        {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', $disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                                        {!!  Form::close() !!}</td>
                                    @endif
                                </tr>
                                            <?php
                                				$records = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get();
                           					?>  
                                            
                                            @foreach($records as $item) <!--third group-->

											<?php 
                                                $unit=DB::table('acc_units')->where('id', $item->unit_id)->first();
                                                $unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name: $unit_name='';

													$inven=DB::table('acc_invendetails')->where('item_id',$item->id)->first();
													isset($inven) && $inven->id> 0 ? $disabled='disabled' : $disabled='';
                                                ?>
                                               <!-- {{-- */$x++;/* --}}-->
                                                <tr>
                                                    <td width="50">{{ $x }}</td>
                                                    <td id="sl"></td><td id="sl">{{ $item->sl }}</td>
                                                    <td id="third" colspan="3"><a href="{{ url('/product', $item->id) }}">{{ $item->name }}</a>
                                                    @if($item->ptype<>'Product')
                            							<a href="{{ url('/product/create?g='.$item->id.'&&tg='.$item->topGroup_id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['addnew'] }}
                                                    @endif
                                                    </td>
                                                    <td width="80">{{ $unit_name}}</td>
                                                    <td>{{ $item->ptype }}</td>
                                                    <td width="80"><a href="{{ url('/fileentry',$item->id) }}">Upload</a></td>
                                                    @if($admin_user) 
                                                    <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                                                    @endif
                                                    @if (Entrust::can('update_product'))
                                                    <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('product.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                                                    @endif
                                                    @if (Entrust::can('delete_product'))
                                                    <td width="80">{!! Form::open(['route' => ['product.destroy', $item->id], 'method' => 'DELETE']) !!}
                                                        {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', $disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                                                        {!!  Form::close() !!}</td>
                                                    @endif
                                                </tr>
                                                	 	<?php
															$recordz = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get();
														?>  
														
														@foreach($recordz as $item) <!--third group-->
														<?php 
                                                            $unit=DB::table('acc_units')->where('id', $item->unit_id)->first();
                                                            $unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name: $unit_name='';
																
																$inven=DB::table('acc_invendetails')->where('item_id',$item->id)->first();
																isset($inven) && $inven->id> 0 ? $disabled='disabled' : $disabled='';

                                                            ?>
														   <!-- {{-- */$x++;/* --}}-->
															<tr>
																<td width="50">{{ $x }}</td>
																<td id="sl"><td id="sl"></td><td id="sl">{{ $item->sl }}</td>
																<td id="third" colspan="2"><a href="{{ url('/product', $item->id) }}">{{ $item->name }}</a>
																@if($item->ptype<>'Product')
                                                                    <a href="{{ url('/product/create?g='.$item->id.'&&tg='.$item->topGroup_id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['addnew'] }}						@endif
																</td>
                                                                 <td width="80">{{ $unit_name }}</td>
                                                                <td>{{ $item->ptype }}</td>
                                                                <td width="80"><a href="{{ url('/fileentry',$item->id) }}">Upload</a></td>
                                                                @if($admin_user) 
                                                                <td width="80">{{  isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                                                                @endif
																@if (Entrust::can('update_product'))
																<td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('product.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
																@endif
																@if (Entrust::can('delete_product'))
																<td width="80">{!! Form::open(['route' => ['product.destroy', $item->id], 'method' => 'DELETE']) !!}
																	{!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', $disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
																	{!!  Form::close() !!}</td>
																@endif
															</tr>
                                                            
																		<?php
                                                                            $recordx = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get();
                                                                        ?>  
                                                                        
                                                                        @foreach($recordx as $item) <!--third group-->
																		<?php 
                                                                            $unit=DB::table('acc_units')->where('id', $item->unit_id)->first();
                                                                            $unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name: $unit_name='';
                                                                            ?>
                                                                           <!-- {{-- */$x++;/* --}}-->
                                                                            <tr>
                                                                                <td width="50">{{ $x }}</td>
                                                                                <td id="sl"><td id="sl"><td id="sl"></td><td id="sl">{{ $item->sl }}</td>
                                                                                <td id="forth"><a href="{{ url('/product', $item->id) }}">{{ $item->name }}</a>
                                                                				 @if($item->ptype<>'Product')
                                                                                    <a href="{{ url('/product/create?g='.$item->id.'&&tg='.$item->topGroup_id) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['addnew'] }}							@endif
                                                                                </td>
                                                                                <td width="80">{{ $unit_name }}</td>
                                                                                <td>{{ $item->ptype }}</td>
                                                                                <td width="80"><a href="{{ url('/fileentry',$item->id) }}">Upload</a></td>
                                                                                @if($admin_user) 
                                                                                <td width="80">{{ isset($users[$item->user_id]) ? $users[$item->user_id] : '' }}</td>
                                                                                @endif
                                                                                @if (Entrust::can('update_product'))
                                                                                <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('product.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                                                                                @endif
                                                                                @if (Entrust::can('delete_product'))
                                                                                <td width="80">{!! Form::open(['route' => ['product.destroy', $item->id], 'method' => 'DELETE']) !!}
                                                                                    {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', $disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                                                                                    {!!  Form::close() !!}</td>
                                                                                @endif
                                                                            </tr>                                                            
                                                                            @endforeach <!--Fift group-->
														@endforeach <!--Forth group-->
                                            @endforeach <!--third group-->
                            @endforeach <!--second group-->
                @endforeach <!--first group-->
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#product-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if ($admin_user): ?>, { "bSortable": false }<?php endif; if (Entrust::can("update_product")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_product")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
