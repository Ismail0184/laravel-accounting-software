@extends('print')

@section('htmlheader_title', 'Empolyees')

@section('contentheader_title', 'Salary Statement')

@section('main-content')

<style>
	.valign { vertical-align:middle}
	.table > thead > tr > th {
     vertical-align: middle;
}
.box-body { overflow-x:scroll}
.table { font-size:9px}
.cname { font-size:16px}
.rpt { font-size:12px}
	#col {  min-height:100px; padding-top:50px; width:16%; float:left}

</style>
<?php 
use  App\Models\Acc\Empolyees;
use  App\Models\Acc\Salaries;
		// $m_id=0;$year=0 ; $tdate='0000-00-00' ;
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		Session::has('stdate') ? $tdate=Session::get('stdate') : $tdate='0000-00-00' ;
		Session::has('sm_id') ? $m_id=Session::get('sm_id') : $m_id=0;
		Session::has('syear') ? $year=Session::get('syear') : $year=date('Y') ;
		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;
		
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
			
			$as=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Advance Salary')->first(); 
			isset($as) && $as->id > 0 ? $as_id=$as->id : $as_id=''; 
			
			$el=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Employee Loan')->first();
			isset($el) && $el->id>0 ? $el_id=$el->id : $el_id='';  
			
			$sa=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Salary and Allowances')->first();
			isset($sa) && $sa->id>0 ? $sa_id=$sa->id : $sa_id='';  
			
			$mc=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Main Cash')->first();
			isset($mc) && $mc->id>0 ? $mc_id=$mc->id : $mc_id='';  
			$vnumber = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;
			$period=array('m_id'=>$m_id, 'year'=>$year);
			
		function asalary($id,$m_id, $year){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$as=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Advance Salary')->first(); 
			isset($as) && $as->id > 0 ? $as_id=$as->id : $as_id='';
			$period=array('m_id'=>$m_id, 'year'=>$year,'com_id'=> $com_id);
			$balance=DB::table('acc_trandetails')->where('amount', '>','0')->where('acc_id',$as_id)->where($period)->where('sh_id',$id)->sum('amount');
			return $balance;
		}

		function eloan($id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$el=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Employee Loan')->first();
			isset($el) && $el->id>0 ? $el_id=$el->id : $el_id='';  
			$eloan=DB::table('acc_trandetails')->where('com_id', $com_id)->where('acc_id',$el_id)->where('sh_id',$id)->first();  
			
			$balance=DB::table('acc_trandetails')->where('com_id', $com_id)->where('acc_id',$el->id)->where('sh_id',$id)->sum('amount');
			isset($eloan->mdeduction) && $eloan->mdeduction < $balance ? $result=$eloan->mdeduction : $result=$balance;
			return $result;
		}
		function fld_value($id, $m, $y, $fld){
			$salary=DB::table('acc_salaries')->where('emp_id',$id)->where('m_id',$m)->where('year',$y)->first();
			if (isset($salary) && $salary->id > 0 ):
				return $salary->$fld;
			else:
				return 0;
			endif;
		}

		$months=array(''=>'Select ...', 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');
		$years=array(''=>'Select ...', 2015=>'2015', 2016=>'2016', 2017=>'2017', 2018=>'2018', 2019=>'2019', 2020=>'2020');
		$month_name=isset($months[$m_id]) ? $months[$m_id] : '';

		function createSalary($id, $m, $y, $asalary, $loan){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$salary=Salaries::where('emp_id',$id)->where('com_id',$com_id)->where('m_id',$m)->where('year',$y)->first();
			if(isset($salary) && $salary->id>0):
			else:
			$salary=Empolyees::where('id',$id)->where('com_id',$com_id)->first();
				$data=array(
					'emp_id'=>$salary->id,
					'gsalary'=>$salary->gsalary,
					'basic'=>$salary->bsalary,
					'hrent'=>$salary->hrent,
					'tran'=>$salary->tran,
					'mexp'=>$salary->mexp,
					'enter'=>$salary->enter,
					'sallow'=>$salary->sallow,
					'mobile'=>$salary->mobile,
					'asalary'=>$asalary,
					'loan'=>$loan,
					'm_id'=>$m,
					'department_id'=>$salary->department_id,
					'year'=>$y,
					'user_id'=>Auth::id(),
					'com_id'=>$com_id,
				);
				$m>0 ? Salaries::create($data) : '';
			endif;
			}
?>
        <h3 class="text-center cname">@if(isset($cname)){{ $cname }}@endif </h3>
        <h3 class="text-center rpt">{{ $deprt_name }} Salary Statement</h3>
        <h4 class="text-center rpt">for the Month of {{ $month_name }}, {{ $year }}</h4>
        <h4 class="text-center rpt">Payment Date on {{ $tdate }}</h4>

            <table id="empolyee-table" class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center valing">{{ $langs['sl'] }}</th>
                        <th rowspan="2" class="valing">{{ $langs['name'] }}</th>
                        <th rowspan="2" class="text-right">{{ $langs['basic'] }}</th>
                        <th rowspan="2" class="text-right">H.R.</th>
                        <th rowspan="2" class="text-right">Tran.</th>
                        <th rowspan="2" class="text-right">M Exp.</th>
                        <th rowspan="2" class="text-right">Enter.</th>
                       	<th rowspan="2" class="text-right">{{ $langs['gsalary'] }}</th>
                        <th colspan="5" class="text-center">Addition</th>
                        <th colspan="5" class="text-center">Deduction</th>
                        <th rowspan="2" class="text-right">Net Payable</th>
                    </tr>
                    <tr>
                        <th class="text-right">{{ $langs['due'] }}</th>
                        <th class="text-right">L. Bill</th>
                        <th class="text-right">Mob</th>
                        <th class="text-right">S A</th>
                        <th class="text-right">{{ $langs['ttl'] }}</th>
                        <th class="text-right">Abs</th>
                        <th class="text-right">A S</th>
	                    <!--<th class="text-right">Loan</th>-->
                        <th class="text-right">Other</th>
                        <th class="text-right">ESF</th>
                        <th class="text-right">{{ $langs['ttl'] }}</th>
                    </tr>

                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php 
					$npay=''; $ttl_salary=''; $ttl_np=''; $ttl_asalary=''; $ttl_loan=''; $ttl_deduct=''; $ttl_absence=''; $ttl_tpsalary=''; $ttl_loans=''; $ttl_deducts=''; $ttl_ad='';$ttl_mobile='';$ttl_lunch=''; $vno='#'; $ttl_esf=''; $ttl_others=''; $ttl_other=''; ; $ttl_due=''; $ttl_dues=''; $ttl_sallow=''; $ttl_sallows=''; $ttl_gsalarys=''; $ttl_gsalary=''; $ttl_asalarys='';
				?>
                @foreach($department as $item)
                    {{-- */$x++;/* --}}
                    <?php 

						$otime=fld_value($item->id, $m_id, $year, 'otime'); $otimes=''; $otime>0 ? $otimes=number_format($otime,2) : $otimes='';
						$hday=fld_value($item->id, $m_id, $year, 'hday'); $hdays=''; $hday>0 ? $hdays=number_format($hday,2) : $hdays='';
						$wday=fld_value($item->id, $m_id, $year, 'wday'); $wdays=''; $hday>0 ? $wdays=$wday : $wdays='';
						$lunch=fld_value($item->id, $m_id, $year, 'lunch'); $lunchs=''; $lunch>0 ? $lunchs=$lunch : $lunchs='';
						$mobile=fld_value($item->id, $m_id, $year, 'mobile'); $mobiles=''; $mobile>0 ? $mobiles=$mobile : $mobiles='';
						$sallow=fld_value($item->id, $m_id, $year, 'sallow'); $sallows=''; $sallow>0 ? $sallows=$sallow : $sallows='';
						$due=fld_value($item->id, $m_id, $year, 'due'); $dues=''; $due>0 ? $dues=$due : $dues='';
						$other=fld_value($item->id, $m_id, $year, 'other'); $others=''; $other>0 ? $others=$other : $others='';
					
						$esfactive=fld_value($item->id, $m_id, $year, 'esf'); $esf_active=''; $esfactive>0 ? $esf_active=$esfactive : $esf_active='0'; 
						$ttl_ad=$lunchs+$mobiles+$sallows+$dues;
						
						$tpsalary=$item->gsalary; 
						$ttl_tpsalary += $tpsalary;
						$ttl_mobile +=$mobile;
						$ttl_due +=$due;
						$ttl_sallow +=$sallow;
						$ttl_gsalary +=$ttl_ad;
						$ttl_lunch +=$lunch;

						$salary=DB::table('acc_salaries')->where($period)->where('emp_id',$item->id)->first();
						$emp_id=''; isset($salary) && $salary->id ? $emp_id=$salary->id : $emp_id=''; //echo $emp_id;
						
						$absence_days=''; isset($salary) && $salary->id ? $absence_days=$salary->absence : $absence_days='';
						$m_ids=$m_id==0 ? 1: $m_id;
						$days = cal_days_in_month(CAL_GREGORIAN, $m_ids, $year);
						
						isset($salary) && $salary->id ? $absence=$tpsalary/$days*$salary->absence : $absence='';
						$absences=''; $absence> 0 ? $absences=number_format($absence) : $absences='';
						$ttl_absence +=$absence;
						
						// Generate ESF 
						$esf_active==0 ? $esf=$item->bsalary*10/100 : $esf=0;
						$deduct=asalary($item->sh_id, $m_id, $year)+eloan($item->sh_id)+$esf+$absence+$other ; 
						$ttl_esf += $esf;
						$ttl_other += $other;
						$deduct>0 ? $deducts=number_format($deduct) : $deducts='';
						
						asalary($item->sh_id, $m_id, $year)>0 ? $asalary=number_format(asalary($item->sh_id, $m_id, $year)) : $asalary='';
						$asalry=asalary($item->sh_id, $m_id, $year); 
						
						eloan($item->sh_id) > 0 ? $eloan=number_format(eloan($item->sh_id)) : $eloan='';
						$loans=eloan($item->sh_id);
						createSalary($item->id, $m_id,$year,$asalry,$loans);

						$ttl_salary += $item->bsalary;
						$gsalary=$item->bsalary+$item->hrent+$item->tran+$item->mexp+$item->enter+$item->lunch+$item->sallow; 
						$ttl_deduct += $deduct;
						$ttl_deduct> 0 ? $ttl_deducts=number_format($ttl_deduct) : $ttl_deducts='';
						$ttl_loan += $loans;
						$ttl_loan> 0 ? $ttl_loans=number_format($ttl_loan) : $ttl_loans='';
						$ttl_asalary += $asalry; 
						$ttl_salary> 0 ? $ttl_salarys=number_format($ttl_salary) : $ttl_salarys='';
						$npay=$item->gsalary-$deduct+$ttl_ad;
						$ttl_np += $npay;
						$data=array('com_id'=>$com_id,'m_id'=>$m_id, 'year'=>$year, 'sh_id'=>$item->sh_id,'acc_id'=>$sa_id);
						$paid=DB::table('acc_trandetails')->where($data)->first();
						isset($paid) && $paid->id>0 ? $paid_has='y' : $paid_has='n'; 
						
						$ttl_ad>0 ? $ttl_ads=$ttl_ad : $ttl_ads='';
					?>
                    <tr>
                  	{!! Form::model($department, ['url' => ['salary/pay', $item->id], 'method' => 'UPDATE', 'class' => 'form-horizontal tranmaster']) !!}
                        <td width="50" class="text-center">{{ $x }}</td>
                        <td class="text-left">{{ $item->name }}</td>
                        <td class="text-right">{{ number_format($item->bsalary) }}</td>
                        <td class="text-right">{{ number_format($item->hrent) }}</td>
                        <td class="text-right">{{ number_format($item->tran) }}</td>
                        <td class="text-right">{{ number_format($item->mexp) }}</td>
                        <td class="text-right">{{ number_format($item->enter) }}</td>
                        <td class="text-right">{{ number_format($item->gsalary) }}</td>
                        <td class="text-right">{{ $dues }}</td>
                        <td class="text-right">{{ $lunchs }}</td>
                        <td class="text-right">{{ $mobiles }}</td>
                        <td class="text-right">{{ $sallows }}</td>
                        <td class="text-right">{{ $ttl_ads }}</td>
                        <td class="text-right">{{ $absences }}@if($absence_days>0) @endif</td>
                        <td class="text-right">{{ $asalary }}</td>
                        <!--<td class="text-right">{{ $eloan }}-->
                         <td class="text-right">{{ $others }}
                        <td class="text-right">{{ $esf> 0 ? number_format($esf) : '' }}</td>
                        <td class="text-right">{{ $deducts }}</td>
                        <td class="text-right">{{ number_format($npay) }}</td>
                    </tr>
                @endforeach
                <?php 	
						//echo $ttl_asalary;
						$ttl_absence> 0 ? $ttl_absence=number_format($ttl_absence) : $ttl_absence='';
						$ttl_tpsalary>0 ? $ttl_tpsalary=number_format($ttl_tpsalary) : '';
						$ttl_asalary>0 ? $ttl_asalarys=number_format($ttl_asalary) : $ttl_asalarys='';
						$ttl_esf>0 ? $ttl_esf=number_format($ttl_esf) : $ttl_esf='';
						$ttl_np >0 ? $ttl_nps=number_format($ttl_np) : $ttl_nps='';
						$ttl_other >0 ? $ttl_others=number_format($ttl_other) : $ttl_others='';
						$ttl_due >0 ? $ttl_dues=number_format($ttl_due) : $ttl_dues=''; //sallow
						$ttl_sallow >0 ? $ttl_sallows=number_format($ttl_sallow) : $ttl_sallows=''; //ttl_gsalary
						$ttl_gsalary >0 ? $ttl_gsalarys=number_format($ttl_gsalary) : $ttl_gsalarys=''; //sallow
					 ?>
                <tr>
                	<td colspan="7" class="text-right">Total</td>
                    <td class="text-right">{{ $ttl_tpsalary }}</td>
                    <td class="text-right" colspan="">{{ $ttl_dues }}</td>
                    <td class="text-right" colspan="">{{ $ttl_lunch > 0 ? number_format($ttl_lunch) : ''  }}</td>
                    <td class="text-right" colspan="">{{ $ttl_mobile > 0 ? number_format($ttl_mobile) : '' }}</td>
                    <td class="text-right" colspan="">{{ $ttl_sallows }}</td>
                    <td class="text-right" colspan="">{{ $ttl_gsalarys }}</td>
                    <td class="text-right">{{ $ttl_absence }}</td>
                    <td class="text-right">{{ $ttl_asalarys }}</td>
                    <!--<td class="text-right">{{ $ttl_loans }}</td>-->
                    <td class="text-right">{{ $ttl_others }}</td>
                    <td class="text-right">{{ $ttl_esf }}</td>
                    <td class="text-right">{{ $ttl_deducts }}</td>
                    <td colspan="" class="text-right">{{ $ttl_nps }}</td><td></td>
                </tr>
                </tbody>
            </table>
            
              <div class="row" style="padding:5px">
                <div class="col-sm-3 text-center" id="col"> __________
                    <div id="inner">Prepared By</div>
                </div>
            	<div class="col-sm-3 text-center" id="col"> _______________
            		<div id="inner">Manager HR and Admin</div>
                </div>
            	<div class="col-sm-3 text-center" id="col"> __________
            		<div id="inner">Manager A/C</div>
                </div>
            	<div class="col-sm-3 text-center" id="col"> __________
            		<div id="inner">A.G.M</div>
                </div>
            	<div class="col-sm-3 text-center" id="col"> _______________
            		<div id="inner">Managing Director</div>
                </div>
            	<div class="col-sm-3 text-center" id="col"> __________
            		<div id="inner">Chairman</div>
                </div>
            </div>     

        </div>
    </div>

@endsection
