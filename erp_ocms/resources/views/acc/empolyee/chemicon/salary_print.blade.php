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
</style>
<?php 
use  App\Models\Acc\Empolyees;
use  App\Models\Acc\Salaries;
		// $m_id=0;$year=0 ; $tdate='0000-00-00' ;


		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		Session::has('stdate') ? $tdate=Session::get('stdate') : $tdate='0000-00-00' ;
		Session::has('sm_id') ? $m_id=Session::get('sm_id') : $m_id=0;
		Session::has('syear') ? $year=Session::get('syear') : $year=2015 ;
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
			
			$sa=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Salary-H/O')->first();
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

		function eloan($id, $m, $y){
			$dt=$y.'-'.$m.'-01';
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$el=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Employee Loan')->first();
			isset($el) && $el->id>0 ? $el_id=$el->id : $el_id='';  
			$eloan=DB::table('acc_trandetails')->join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
			->where('acc_trandetails.com_id', $com_id)->where('acc_id',$el_id)
			->where('amount','>',0)
			->where('tdate','<', $dt)
			->where('acc_trandetails.sh_id',$id)->latest('acc_trandetails.created_at')->first();  

			$balance=DB::table('acc_trandetails')->join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
			->where('acc_trandetails.com_id', $com_id)->where('acc_id',$el->id)->where('tdate','<', $dt)->where('acc_trandetails.sh_id',$id)->sum('amount');
			if(isset($eloan) && $eloan->mdeduction>0 && $eloan->mdeduction < $balance):
					$result=$eloan->mdeduction;
			else:
				$result=$balance;
			endif;
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
			$salary=Salaries::where('emp_id',$id)->where('m_id',$m)->where('year',$y)->where('com_id',$com_id)->first();
			if(isset($salary) && $salary->id>0):
			else:
			$salary=Empolyees::where('id',$id)->first();
				$data=array(
					'emp_id'=>$salary->id,
					'basic'=>$salary->bsalary,
					'hrent'=>$salary->hrent,
					'conv'=>$salary->conv,
					'mexp'=>$salary->mexp,
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
        <h3 class="text-center cname">@if(isset($cname)){{ $cname }}@endif</h3>
        <h3 class="text-center rpt">{{ $deprt_name }} Salary Statement</h3>
        <h4 class="text-center rpt">for the Month of {{ $month_name }}, {{ $year }}</h4>
        <h4 class="text-center rpt">Payment Date on {{ $tdate }}</h4>
          <table id="empolyee-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center valing">{{ $langs['sl'] }}</th>
                        <th rowspan="2" class="valing">{{ $langs['name'] }}</th>
                        <th rowspan="2" class="valing">{{ $langs['designation_id'] }}</th>
                        <th rowspan="2" class="text-right">{{ $langs['basic'] }}</th>
                        <th rowspan="2" class="text-right">{{ $langs['hrent'] }}</th>
                        <th rowspan="2" class="text-right">Conv</th>
                        <th rowspan="2" class="text-right">{{ $langs['mexp'] }}</th>
                        <th rowspan="2" class="text-right">{{ $langs['gsalary'] }}</th>
                        <th rowspan="2" class="text-right">{{ $langs['otime'] }}</th>
                        <th rowspan="2" class="text-right">{{ $langs['hday'] }}</th>
                        <th rowspan="2" class="text-right">{{ $langs['wday'] }}</th>
                        <th rowspan="2" class="text-right">{{ $langs['tpsalary'] }}</th>
                        <th colspan="4" class="text-center">Deduction</th>
                        <th rowspan="2" class="text-right">{{ $langs['npay'] }}</th>
                    </tr>
                    <tr>
                        <th class="text-right">{{ $langs['asalary'] }}</th>
                        <th class="text-right">{{ $langs['loan'] }}</th>
                        <th class="text-right">{{ $langs['absence'] }}</th>
                        <th class="text-right">{{ $langs['ttl'] }}</th>
                    </tr>

                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php 
					$npay=''; $ttl_salary=''; $ttl_np=''; $ttl_asalary=''; $ttl_loan=''; $ttl_deduct=''; $ttl_absence=''; $ttl_tpsalary=''; $ttl_loans=''; $ttl_deducts='';  $asalary='';$loan_deduction='';$deducts='';
				?>
                @foreach($department as $item)
                    {{-- */$x++;/* --}}
                    <?php 
						//if ($item->id==49): echo $item->sh_id; endif;
						$otime=fld_value($item->id, $m_id, $year, 'otime'); $otimes=''; $otime>0 ? $otimes=number_format($otime,2) : $otimes=''; //echo $otimes;
						$hday=fld_value($item->id, $m_id, $year, 'hday'); $hdays=''; $hday>0 ? $hdays=number_format($hday,2) : $hdays='';
						$wday=fld_value($item->id, $m_id, $year, 'wday'); $wdays=''; $wday>0 ? $wdays=$wday : $wdays='';
						$loan_deduction=fld_value($item->id, $m_id, $year, 'loan'); $loan_deduction==0 ? $loan_deduction='' : '';
						//$asalary_deduction=fld_value($item->id, $m_id, $year, 'asalary'); $asalary_deduction==0 ? $asalary_deduction='' : '';
						$salid=DB::table('acc_salaries')->where('emp_id',$item->id)->where('m_id',$m_id)->where('year',$year)->where('com_id',$com_id)->first();
						isset($salid) && $salid->id >0 ? $sal_id=$salid->id : $sal_id='';
						
						$tpsalary=$item->bsalary+$item->hrent+$item->conv+$item->mexp+$otime+$hday; 
						$ttl_tpsalary += $tpsalary;

						$salary=DB::table('acc_salaries')->where($period)->where('emp_id',$item->id)->first();
						$emp_id=''; isset($salary) && $salary->id ? $emp_id=$salary->id : $emp_id='';

						$gsalary=$item->bsalary+$item->hrent+$item->conv+$item->mexp; 
						
						$absence_days=''; isset($salary) && $salary->id ? $absence_days=$salary->absence : $absence_days='';
						$m_ids=$m_id==0 ? 1: $m_id;
						$days = cal_days_in_month(CAL_GREGORIAN, $m_ids, $year);
						
						isset($salary) && $salary->id ? $absence=round($gsalary/$days*$salary->absence) : $absence='';
						$absences=''; $absence> 0 ? $absences=number_format($absence) : $absences='';
						$ttl_absence +=$absence;
						
						
						asalary($item->sh_id, $m_id, $year)>0 ? $asalary=number_format(asalary($item->sh_id, $m_id, $year)) : $asalary='';
						$asalry=asalary($item->sh_id, $m_id, $year); //echo $asalry;

						$deduct=$asalry+$loan_deduction+(integer)$absence; 
						$deduct>0 ? $deducts=number_format($deduct) : $deducts='';
						
						eloan($item->sh_id, $m_id, $year) > 0 ? $eloan=number_format(eloan($item->sh_id, $m_id, $year)) : $eloan='';
						$loans=eloan($item->sh_id, $m_id, $year);
						createSalary($item->id, $m_id,$year,$asalry,$loans);

						$ttl_salary += $item->salary;
						$ttl_deduct += $deduct;
						$ttl_deduct> 0 ? $ttl_deducts=number_format($ttl_deduct) : $ttl_deducts='';
						$ttl_loan += $loan_deduction; //loans;
						$ttl_loan> 0 ? $ttl_loans=number_format($ttl_loan) : $ttl_loans='';
						$ttl_asalary += $asalry;
						$ttl_salary> 0 ? $ttl_salarys=number_format($ttl_salary) : $ttl_salarys='';
						$npay=$tpsalary-$deduct;
						$ttl_np += $npay;
						
						
						// factory Salary
						$dp=DB::table('acc_departments')->where('com_id', $com_id)->where('name','Factory')->first();
						isset($dp) && $dp->id>0 ? $dp_id=$dp->id : $dp_id=''; // echo $dp_id.'<br>';
						if($item->department_id==$dp_id):
							$sa=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Salary Factory')->first();
							isset($sa) && $sa->id>0 ? $sa_id=$sa->id : $sa_id='';
							
							$pc=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Petty Cash-Factory')->first();
							isset($pc) && $pc->id>0 ? $mc_id=$pc->id : $mc_id='';  
  
						endif;
						$data=array('com_id'=>$com_id,'m_id'=>$m_id, 'year'=>$year, 'sh_id'=>$item->sh_id,'acc_id'=>$sa_id);
						$paid=DB::table('acc_trandetails')->where($data)->first();
						isset($paid) && $paid->id>0 ? $paid_has='y' : $paid_has='n'; 

					?>
                    <tr>
                  	{!! Form::model($department, ['url' => ['salary/pay', $item->id], 'method' => 'UPDATE', 'class' => 'form-horizontal tranmaster']) !!}
                        <td width="50" class="text-center">{{ $x }}</td>
                        <td class="text-left">{{ $item->name }}</td>
                        <td class="text-left">@if(isset($item->designation->name)){{ $item->designation->name }}@endif</td>
                        <td class="text-right">{{ number_format($item->bsalary) }}</td>
                        <td class="text-right">{{ number_format($item->hrent) }}</td>
                        <td class="text-right">{{ number_format($item->conv) }}</td>
                        <td class="text-right">{{ number_format($item->mexp) }}</td>
                        <td class="text-right">{{ number_format($gsalary) }}</td>
                        <td class="text-right">{{ $otimes }}</td>
                        <td class="text-right">{{ $hdays }}</td>
                        <td class="text-right">{{ $wdays }}</td>
                        <td class="text-right">{{ number_format($tpsalary) }}</td>
                        <td class="text-right">{{ $asalary }}</td>
                        <td class="text-right">{{ $loan_deduction }}</td>
                        <td class="text-right">{{ $absences }}@if($absence_days>0) ({{ $absence_days }} dyas) @endif</td>
                        <td class="text-right">{{ $deducts }}</td>
                        <td class="text-right">{{ number_format($npay) }}</td>
                        </td>
					{!!  Form::close() !!}
                    </tr>
                @endforeach
                <?php 	$ttl_absence> 0 ? $ttl_absence=number_format($ttl_absence) : $ttl_absence='';
						$ttl_tpsalary>0 ? $ttl_tpsalary=number_format($ttl_tpsalary) : '';
						$ttl_asalary>0 ? $ttl_asalary=number_format($ttl_asalary) : $ttl_asalary='';
						$ttl_np >0 ? $ttl_np=number_format($ttl_np) : $ttl_np='';
					 ?>
                <tr>
                	<td colspan="11" class="text-right">Total</td>
                    <td class="text-right">{{ $ttl_tpsalary }}</td>
                    <td class="text-right">{{ $ttl_asalary }}</td>
                    <td class="text-right">{{ $ttl_loans }}</td>
                    <td class="text-right">{{ $ttl_absence }}</td>
                    <td class="text-right">{{ $ttl_deducts }}</td>
                    <td colspan="" class="text-right">{{ $ttl_np }}</td><td></td>
                </tr>
                </tbody>
            </table>
@endsection

