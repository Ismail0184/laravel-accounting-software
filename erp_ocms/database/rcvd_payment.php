<style>
	#center { text-align:center}
	#right { text-align:right}
	#left { text-align:left}
	.amount { width:120px}
	#atype {width:120px; text-align:left}
	#note { width:350px}
	#report_header { height:105px; background-color:#;  }
	#report_body { min-height:500px; background-color:#}
	#report_footer { height:70px; background-color:#; border-top:3px solid #666}
	#header_left { float:left; background-color:#; width:50%; height:80px; display:inline}
	#header_right {float:left; background-color:#; width:50%; height:80px ; display:inline; text-align:right; }
	#company {margin:0px ; padding:0px; padding-left:5px}
	#p { font-size:16px; font-weight:bold; padding-right:10px; padding-top:5px; padding-left:5px}
	#rpt { margin:0px; padding:0px;}
	#rpt_bottom,#rpt_top { background-color:#; border-top:1px solid #333 ; border-bottom:1px solid #CCC ; font-weight:bold }
	#group1 {border-top:1px solid #333 ; }
	#level1 { padding-left:20px; font-weight:bold}
	#level2 { padding-left:40px ; font-weight:bold}
	#level3 { padding-left:60px}
	#level4 { padding-left:80px}
	#currency {width:10px}
	a { text-decoration:none}
	
</style>
<?php
		//============== for Currency convert============
			$flag= $this->uri->segment(5);
			$sc= $this->uri->segment(5);
			$first_currency=$this->transaction_model->options('first_currency');
			$second_Currency=$this->transaction_model->options('second_currency');
			$second_currency_rate=$this->transaction_model->options('second_currency_rate');
			$currency= $sc=='sc' ? $second_Currency :  $first_currency;
			$flag=='scc' ? $currency=$second_Currency : '';
			$sca=$this->transaction_model->options('SC Allowed');
			$flag=='scc' && $sca=='active' ? $scc='' : empty($flag) && $sca=='active' ? $scc='scc' : $scc='';
		//=============== end of currency convert==========

$pl='';
$idcoa= $this->uri->segment(5);

$id_coa=0; $id_subhead=0; $debit_ttl='';
if ($this->transaction_model->current_data_view('rpt')!=false):
	list($vns,$fdate,$tdate,$id_coas) =preg_split('[,]',$this->transaction_model->current_data_view('rpt'));
else:
$vns=''; $fdate='0000-00-00';$tdate='0000-00-00';$id_coas='';
endif;

// fiscal opening date
list ($period_1,$period_2)=preg_split('[=]',$this->transaction_model->fyear($tdate));
$period_1=date('d-m-Y',strtotime($period_1));

	echo "<div id='report_header'>
				<div id='header_left'>
					<h3 id='company'>".$this->coa_model->id_company('company')."</h3>
					<h5 id='company'>".$this->coa_model->id_company('address')."</h5>
				</div>
				<div id='header_right'>
				<p  id='p'></p>
				"; 
				
				$dt=date('m',strtotime($fdate))==date('m',strtotime($tdate)) ? "Report for: ".date('F Y', strtotime($tdate)) 
					: "As at: ".date('d-m-Y',strtotime($tdate))."";
				
				$scs=$sc=='sc' ? '' : 'sc';
				echo "
				<p id='p'> $dt</p> 
				</div>";
				echo $sca=='active' ? "<h4  align='center' id='rpt'><a href=".site_url(SITE_AREA .'/content/transaction/trial_balance/'.$scs).">Trial Balance</a></h4>" : "<h4  align='center' id='rpt'>Receipt and Payment</h4>";
		echo "</div>";

echo $sc=='sc' ? "<div align='right'>Currency converted rate : $second_currency_rate</div>" : '';
		
echo  "<div id='report_body'>";
echo "<table  cellpadding='10' width='100%' >";

	// Dual currency support

echo "<tr id='rpt_top'><th >Account Head</th><td id='currency'></td><th id='right' class='amount'>Debit</th><td id='currency'></td><th id='right' class='amount'><a href=".site_url(SITE_AREA .'/content/transaction/trial_balance/'.$scc).">Credit</a></th></tr>";
//
 
 		//============opening balance ===============
			$op_b_cc=''; $op_b_c='';  $ttl=''; $op_b_dc=''; $op_b_d='';
			$fyear=$this->transaction_model->fyear($fdate); 
			list ($period1, $period2)=preg_split('[=]',$fyear);
			
			//$idcoa=$this->coa_model->get_field("acchead","Main Cash"); 
			$idcoa=$this->coa_model->field_value('id_coa',array('acchead'=>'Main Cash'));
				$wheres="tdate < '$fdate' and id_coa=$idcoa";
				$rp="(before ".date('d-m-Y',strtotime($fdate)).")";
			//echo $wheres;
			$op_b=$this->transaction_model->sum_amount($wheres,$sc) ? $this->transaction_model->sum_amount($wheres,$sc) : '';
			//echo $op_b;
			$op_b>0 ? $op_b_d=number_format($op_b,2) : $op_b_c=number_format(substr($op_b,1),2);
			$op_b>0 ? $op_b_dc=$currency : $op_b_cc=$currency;
			
			echo "<tr id=''><td id='right' colspan='1'>Opening Balance:$rp</td><td id='currency'>$op_b_cc</td><td id='right'>$op_b_c</td><td id='currency'>$op_b_dc</td><td id='right'>$op_b_d</td><td id='currency'></td><td id='right'></td></tr>";

			$op_b!='' ? $ttl+=$op_b :'';
		//=============closing balance =================
 
 
 
 
 
 
 
 $credit_ttl=0;$debit_ttls=0;
 
 // Grand Mother level
 
$idco=$this->coa_model->field_value('id_coa',array('acchead'=>'Main Cash'));

$wheres="tdate between '$fdate' and '$tdate'";
$records=$this->coa_model->select('id_parent,acchead,atype, u9_transaction.id_coa')
->join('u9_transaction', 'u9_transaction.id_coa = u9_coa.id_coa', 'inner')
->where('u9_transaction.id_coa <> '.$idco)
->where("u9_transaction.ttype in ('cr','ce')")
->where($wheres)
->group_by('id_parent')
->find_all(); //'u9_coa.id_parent',0

if (is_array($records)){ // 001
	foreach($records as $record){ // 002
		$GroupHead=$this->coa_model->field_value('acchead',array('id_coa'=>$record->id_parent)); //echo $GroupHead;
		echo "<tr id='group1'><td  id='level1'>$GroupHead </td><td id='currency'></td><td id='right' ></td><td id='currency'></td><td id='right'></td></tr>"; 
		
		

		// first group level	
		$records=$this->coa_model
		->join('u9_transaction', 'u9_transaction.id_coa = u9_coa.id_coa', 'inner')
		->group_by('id_parent')
		->find_all_by(array('id_parent'=>$record->id_parent)); //echo $record->id_coa;
		if (is_array($records)){ // 001
		foreach($records as $record){ // 002
						$daterang=$fdate.'='.$tdate; //echo $daterang;
						$query=$this->transaction_model->rcvd_payment($daterang,$record->id_parent,$flag);
						$n=0;$val='';
						if ($query && is_array($query)){ // 0010
							foreach($query as $val){
								$currencyD=''; $currencyC=''; $CreitAmount=''; $DebitAmount=''; $DebitAmounts=''; $CreitAmounts='';
								$acchead=$this->coa_model->get_field($val->id_coa,'acchead');
								$val->amount>0 ? $currencyD='Tk' :  '';
								$val->amount<0 ? $currencyC='Tk' : '';
								
								$val->amount>0 ? $DebitAmount=$val->amount : '';
								$val->amount<0 ? $CreitAmount=$val->amount : ''; //echo $CreitAmount;
								
								$CreitAmount<0 ? $CreitAmounts=number_format(substr($CreitAmount,1),2) : ''; //echo $CreitAmounts;
								$DebitAmount>0 ? $DebitAmounts=number_format($DebitAmount,2) : ''; 
								
								$val->amount>0 ? $debit_ttl+=$val->amount : '';
								$val->amount<0 ? $credit_ttl+=$val->amount : '';
								
							echo "<tr ><td  id='level3'> $acchead</td><td id='currency'>$currencyD</td><td id='right' >$DebitAmounts</td>
							<td id='currency'>$currencyC</td><td id='right'>$CreitAmounts</td></tr>"; 
							}

						
						}
		
			}
		}

	 }// 002

}// 001



					$pl>0 ? $credit_ttl+=$pl  :$credit_ttl+=$pl;
					$op_b<0 ? $debit_ttl+=$op_b : '';
					$op_b>0 ? $credit_ttl-=$op_b : ''; //echo $credit_ttl;
					$debit_ttls=$debit_ttl!=0 ? number_format($debit_ttl,2) : '';
					$credit_ttls=$credit_ttl!=0 ? number_format(substr($credit_ttl,1),2) : '';

					$balance=$debit_ttl+$credit_ttl; //echo $balance;

	echo "<tr id='rpt_bottom'><td  id='right' colspan='1'>Total</td><td id='currency'>".$currency."</td><td id='right' >".$debit_ttls."</td><td id='currency'>".$currency."</td><td id='right'>".$credit_ttls."</td></tr>"; 

	echo "<tr id='rpt_bottom'><td  id='right' colspan='1'>Closing Balance</td><td id='currency'></td><td id='right' ></td><td id='currency'>Tk</td><td id='right'>".number_format(substr($balance,1),2)."</td></tr>"; 
		
	echo "</table>";

	
echo "</div>";

?>