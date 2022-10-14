@extends('app')

@section('htmlheader_title', 'Dashboard')

@section('contentheader_title', 'Top Sheet')

@section('main-content')
<style>
	.panel-body { min-height:400px}
	.panel-heading { height:45px}
	.center { padding-left:30%}
	.panel-heading { margin:0px; padding:0px; height:45px}
	.chart { height:200px; overflow-y:scroll}
	.ht { padding-top:8px}
</style>
        <!-- Main content -->
        <?php 
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  

			$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
			$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
			$user=DB::table('users')->where('id',Auth::id())->first();
			$user_name=''; isset($user) && $user->id >0 ? $user_name=$user->name : $user_name='';
			function balance($id){
				Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
				$balance=DB::table('acc_trandetails')->where('com_id', $com_id)->where('acc_id',$id)->sum('amount');
				return $balance;
				}
			function pcost($id){
				Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
				$balance=DB::table('acc_trandetails')->where('com_id', $com_id)->where('pro_id',$id)->sum('amount');
				return $balance;
				}
			function account_exist($account_head,$group,$tg,$at){
				Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
				$has=DB::table('acc_coas')->where('com_id', $com_id)->where('name',$account_head)->first();
				
				if(isset($has) && $has->id>0):
				else:
					$ca=DB::table('acc_coas')->where('com_id',$com_id)->where('name',$group)->first();
					isset($ca) && $ca->id > 0 ? $g=$ca->id : $g='';
					$bs=DB::table('acc_coas')->where('com_id',$com_id)->where('name',$tg)->first();
					isset($bs) && $bs->id > 0 ? $tg=$bs->id : $tg='';
					return '<a href="'.url('acccoa/create?name='.$account_head.'&g='.$g.'&tg='.$tg.'&at='.$at).'">Please create '.$account_head.'</a>';
				endif;
			}
			// -- ledger-------				
				Session::put('dfrom', date('Y-m-01'));
				Session::put('dto', date('Y-m-d'));
			//-- For stock ledger------
				Session::put('lgwh_id', '');
				Session::put('lgdfrom', date('Y-m-01'));
				Session::put('lgdto', date('Y-m-d'));
			//-----------------------------------------------
				
				/*Nitification*/
				$com=DB::table('acc_companies')->where('id',$com_id)->first();  
				$check_count=DB::table('acc_tranmasters')->where('com_id',$com_id)
				->where('check_id',Auth::id())->where('check_action',0)->count('check_action');
				$ttl=''; //echo $check_count;
				$check_count> 0 ? $ttl += $check_count: '';
				$approve_count=DB::table('acc_tranmasters')->where('com_id',$com_id)
				->where('appr_id',Auth::id())->where('appr_action',0)
				->where('check_action',1)->count('check_action');
				//echo $check_count;
				$approve_count> 0 ? $ttl += $approve_count: '';
				// recquisition count
				$rcheck_count=DB::table('acc_prequisitions')->where('com_id',$com_id)
				->where('check_id',Auth::id())->where('check_action',0)
				->where('check_action',0)->count('check_action');
				$rcheck_count> 0 ? $ttl += $rcheck_count: '';

				// transferred count
				$sis_count=DB::table('acc_trandetails')
				->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
				->where('sis_id',$com_id)
				->where('acc_trandetails.sis_action','')
				->groupBy('acc_tranmasters.id')
				->count('acc_tranmasters.id'); 
				$sis_count> 0 ? $ttl += $sis_count: '';

				// audit count
				$audit_count=DB::table('acc_audits')
				->where('com_id',$com_id)
				->where('sendto',Auth::id())
				->where('reply_id',0)
				->count('sendto'); 
				$audit_count> 0 ? $ttl += $audit_count: '';
				
				// reminder
				$reminder_count='';$amt='';
				$reminder=DB::table('acc_trandetails')
				->where('com_id',$com_id)
				->where('rmndr_id','>','0')
				->where('rmndr_date','<=',date('Y-m-d'))
				->havingRaw('SUM(amount) <> 0')
				->groupBy('rmndr_id')
				->get(); //echo $reminder.'';
				foreach($reminder as $item): 
					$amt=DB::table('acc_trandetails')->where('com_id',$com_id)->where('rmndr_id',$item->rmndr_id)->sum('amount');
					$amt!=0 ? $reminder_count+=1 : '';
				endforeach;
				$reminder_count!='' ? $ttl += 1: '';

		?>
<div class="box">
<div class="container">
        <section class="content">
          <div class="row">
            <div class="col-md-6">
              <!-- AREA CHART -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Cash and Bank <?php echo account_exist('Cash and Bank','Current Assets','Balance Sheet','Group') ?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                  <table class="table">
                  <tr>
                  	<th class="col-sm-2">{{ $langs['sl'] }}</th>
                    <th class="col-sm-6">{{ $langs['acc_id'] }}</th>
                    <th class="col-sm-4 text-right">{{ $langs['balance'] }}</th>
                  </tr>
                  {{-- */$x=0;/* --}}
                    @foreach($coa as $key => $val)
                    {{-- */$x++;/* --}}
                    	@if(balance($key)!=0)
                    	<tr>
                        	<td>{{ $x }}</td>
                            <td><a href="{{ url('/tranmaster/ledger?acc_id='.$key) }}">{{ $val }}</a></td>
                            <td class="col-sm-4 text-right">@if(balance($key)<0) ({{ substr(number_format(balance($key),2),1) }}) @else {{ number_format(balance($key),2) }} @endif</td>
                        </tr>
                        @endif
                    @endforeach
                    </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- DONUT CHART -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Sundry Debtors <?php echo account_exist('Sundry Debtors','Current Assets','Balance Sheet','Group') ?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                  <table class="table">
                  <tr>
                  	<th class="col-sm-2">{{ $langs['sl'] }}</th>
                    <th class="col-sm-6">{{ $langs['acc_id'] }}</th>
                    <th class="col-sm-4 text-right">{{ $langs['balance'] }}</th>
                  </tr>
                  {{-- */$x=0;/* --}}
                    @foreach((array)$sdebtors as $key => $val)
                    {{-- */$x++;/* --}}
                    	@if(balance($key)!=0)
                    	<tr>
                        	<td>{{ $x }}</td>
                            <td><a href="{{ url('/tranmaster/ledger?acc_id='.$key) }}">{{ $val }}</a></td>
                            <td class="col-sm-4 text-right">@if(balance($key)<0) ({{ substr(number_format(balance($key),2),1) }}) @else {{ number_format(balance($key),2) }} @endif</td>
                        </tr>
                        @endif
                    @endforeach
                    </table>
                  
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col (LEFT) -->
            
            <div class="col-md-6">
              <!-- LINE CHART -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Sundry Creditors <?php echo account_exist('Sundry Creditors','Current Liabilities','Balance Sheet','Group') ?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                  <table class="table">
                  <tr>
                  	<th class="col-sm-2">{{ $langs['sl'] }}</th>
                    <th class="col-sm-6">{{ $langs['acc_id'] }}</th>
                    <th class="col-sm-4 text-right">{{ $langs['balance'] }}</th>
                  </tr>
                  {{-- */$x=0;/* --}}
                    @foreach((array)$screditors as $key => $val)
                    {{-- */$x++;/* --}}
                    	@if(balance($key)>0)
                    	<tr>
                        	<td>{{ $x }}</td>
                            <td><a href="{{ url('/tranmaster/ledger?acc_id='.$key) }}">{{ $val }}</a></td>
                            <td class="col-sm-4 text-right">@if(balance($key)<0) ({{ substr(number_format(balance($key),2),1) }}) @else {{ number_format(balance($key),2) }} @endif</td>
                        </tr>
                        @endif
                    @endforeach
                    </table>
                  
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- BAR CHART -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Notifications</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                        You have {{ $ttl }} notifications
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li class="ht"><!-- start notification -->
                                    		Check: 
                                           	@if(isset($check_count) && $check_count>0)
                                            	<a href="{{ url('/tranmaster/checkby') }}"> 
                                                	{{ $check_count }} Transaction for checking
                                                </a>
                                        	@endif
                                    </li><li class="ht">
                                    		Approve:
											@if(isset($approve_count) && $approve_count>0)
                                            	<a href="{{ url('/tranmaster/approveby') }}"> 
                                                	{{ $approve_count }} Transaction for approval
                                                </a>
                                        	@endif 
                                    </li><li class="ht">
                                    		Requisition Check :
											@if(isset($rcheck_count) && $rcheck_count>0)
                                            	<a href="{{ url('/prequisition/check') }}"> 
                                                	{{ $rcheck_count }} Requisition for checking
                                                </a>
                                        	@endif  
                                    </li><li class="ht">Transaction For
                                    		Sister Concern: 
                                            @if($sis_count>0)
                                            	<a href="{{ url('/tranmaster/sister') }}"> 
                                                	{{ $sis_count }} Transfered for acceptance
                                                </a>
                                        	@endif  
                                    </li><li class="ht">
                                    		Audit Claim: 
                                            @if(isset($audit_count) && $audit_count>0)
                                            	<a href="{{ url('/audit/reply') }}"> 
                                                	{{ $audit_count }} Audtit Notice
                                                </a>
                                        	@endif  
									</li><li class="ht">      
                                    		Reminder:                             
                                            @if(isset($reminder_count) && $reminder_count>'0')
                                            	<a href="{{ url('/trandetail/reminder') }}"> 
                                                	{{ $reminder_count }} Transaction Reminder
                                                </a>
                                        	@endif  

                                    </li><!-- end notification -->
                                </ul>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col (RIGHT) -->
			<!--Second Level ***************************************************************************************-->

            <div class="col-md-6">
              <!-- AREA CHART -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Stock Balance
                  @if(count($whs)>2)
                  {!! Form::select('wh_id', $whs ,null, ['class' => 'tdayex','style'=>'width:200px','id'=>'wh_id']) !!}
                  @endif
                  </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                  <div id="responsestock" align="center">
                  <table class="table">
                  <tr>
                  	<th class="col-sm-2">{{ $langs['sl'] }}</th>
                    <th class="col-sm-6">{{ $langs['prod_id'] }}</th>
                    <th class="col-sm-4 text-right">{{ $langs['sbalance'] }}</th>
                  </tr>
                  {{-- */$x=0;/* --}}
                    @foreach($stock as $data)
                    {{-- */$x++;/* --}}
                    	<tr>
                        	<td>{{ $x }}</td>
                            <td><a href="{{ url('/invenmaster/ledger?item_id='.$data->item_id) }}">@if(isset($data->product->name)){{ $data->product->name }}@endif</a></td>
                            <td class="col-sm-4 text-right">{{ $data->qty }}</td>
                        </tr>
                    @endforeach
                    </table>
                    </div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- DONUT CHART -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Advance For Expenses <?php echo account_exist('Advance For Expenses','Cash and Bank','Balance Sheet','Account') ?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                  <table class="table">
                  <tr>
                  	<th class="col-sm-2">{{ $langs['sl'] }}</th>
                    <th class="col-sm-6">{{ $langs['acc_id'] }}</th>
                    <th class="col-sm-4 text-right">{{ $langs['balance'] }}</th>
                  </tr>
                  {{-- */$x=0;/* --}}
                    @foreach($advance as $val)
                    {{-- */$x++;/* --}}
                    	@if($val->amount>0)
                    	<tr>
                        	<td>{{ $x }}</td>
                            <td><a href="{{ url('/tranmaster/subhead?sh_id='.$val->sh_id) }}">@if($val->subhead->name){{ $val->subhead->name }}@endif</a></td>
                            <td class="col-sm-4 text-right">{{ number_format($val->amount,2) }}</td>
                        </tr>
                        @endif
                    @endforeach
                    </table>
                  
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col (LEFT) -->
            
            <div class="col-md-6">
              <!-- LINE CHART -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Todays Expenditures {!! Form::text('tdate', null, ['class' => 'tdayex','style'=>'width:100px','id'=>'tdate']) !!}</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                  <div id="responsecontainer" align="center">

                  <table class="table">
                  <tr>
                  	<th class="col-sm-2">{{ $langs['sl'] }}</th>
                    <th class="col-sm-6">{{ $langs['acc_id'] }}</th>
                    <th class="col-sm-4 text-right">{{ $langs['balance'] }}</th>
                  </tr>
                  {{-- */$x=0;/* --}}
                  <?php $ttl=''; ?>
                    @foreach($texpenses as $data)
                    {{-- */$x++;/* --}}
                    	<tr>
                        	<td>{{ $x }}</td>
                            <td><a href="{{ url('/tranmaster/voucher', $data->tm_id) }}">VNo:{{ $data->vnumber }}-@if(isset($data->coa->name)){{ $data->coa->name }}@endif</a></td>
                            <td class="col-sm-4 text-right">{{ $data->amount }}</td>
                        </tr>
                  <?php $ttl += $data->amount; ?>
                    @endforeach
                    <tr>
                    	<td class="text-right" colspan="2">Todal</td>
                        <td class="text-right">{{ $ttl }}</td>
                    </tr>
                    </table>
                  </div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- BAR CHART -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Project Cost</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                  <table class="table">
                  <tr>
                  	<th class="col-sm-2">{{ $langs['sl'] }}</th>
                    <th class="col-sm-4">{{ $langs['proj_id'] }}</th>
                    <th class="col-sm-3">{{ $langs['pvalue'] }}</th>
                    <th class="col-sm-3 text-right">{{ $langs['rcost'] }}</th>
                  </tr>
                  {{-- */$x=0;/* --}}
                    @foreach($projects as $val)
                    {{-- */$x++;/* --}}
                    	<tr>
                        	<td>{{ $x }}</td>
                            <td><a href="{{ url('/acc-project') }}" target="_blank">{{ $val->name }}</a></td>
                            <td>{{ number_format($val->cost,2) }}</td>
                            <td class="col-sm-4 text-right"><a href="{{ url('/acc-project/ledger?pro_id='.$val->id) }}" target="_blank">{{ number_format(pcost($val->id),2) }}</a></td>
                        </tr>
                    @endforeach
                    </table>
                  

                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col (RIGHT) -->




          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      </div></div>
@endsection
@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".b2b").validate();
		$( "#tdate" ).datepicker({ dateFormat: "yy-mm-dd" });
		
		$("#tdate").on('change', function(e){             
		var tdayex=e.target.value; 
		//alert(tdayex);
		  $.ajax({    //create an ajax request to load_page.php
			type: "POST",
			url: "{{{ asset('dashboard/display') }}}",      
			data: { id : tdayex, _token: "{{{ csrf_token() }}}" },              
			success: function(response){                    
				$("#responsecontainer").html(response); 
				//alert(response);
				}
			});
		});

		$("#wh_id").on('change', function(e){             
		var tdayex=e.target.value; 
		//alert(tdayex);
		  $.ajax({    //create an ajax request to load_page.php
			type: "POST",
			url: "{{{ asset('dashboard/stock') }}}",      
			data: { id : tdayex, _token: "{{{ csrf_token() }}}" },              
			success: function(response){                    
				$("#responsestock").html(response); 
				//alert(response);
				}
			});
		});

		
    });
        
</script>

@endsection

