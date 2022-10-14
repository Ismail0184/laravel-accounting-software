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
	#level1 { padding-left:20px; font-weight:bold}
	#level2 { padding-left:40px ; font-weight:bold}
	#level3 { padding-left:60px}
	#level4 { padding-left:80px}
	#level5 { padding-left:100px}
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
				echo $sca=='active' ? "<h4  align='center' id='rpt'><a href=".site_url(SITE_AREA .'/content/transaction/trial_balance/'.$scs).">Trial Balance</a></h4>" : "<h4  align='center' id='rpt'>Trial Balance</h4>";
		echo "</div>";

echo $sc=='sc' ? "<div align='right'>Currency converted rate : $second_currency_rate</div>" : '';
		
echo  "<div id='report_body'>";
echo "<table  cellpadding='10' width='100%' >";

	// Dual currency support

echo "<tr id='rpt_top'><th >Account Head</th><th id='atype'>Account Type</th><td id='currency'></td><th id='right' class='amount'>Debit</th><td id='currency'></td><th id='right' class='amount'><a href=".site_url(SITE_AREA .'/content/transaction/trial_balance/'.$scc).">Credit</a></th></tr>";
//
 $credit_ttl=0;$debit_ttls=0;
 
 // Grand Mother level
$records=$this->coa_model->find_all_by('id_parent',0);
if (is_array($records)){ // 001
	foreach($records as $record){ // 002
	if ($record->atype=='Group') :
	echo "<tr ><td  id='level1'>$record->acchead</td><td >$record->atype</td><td id='currency'></td><td id='right' ></td><td id='currency'></td><td id='right'></td></tr>"; 
	endif;
// first group level	
$records=$this->coa_model->find_all_by(array('id_parent'=>$record->id_coa)); //echo $record->id_coa;
if (is_array($records)){ // 003
	
	foreach($records as $record){ // 004
	
	$tran_check=$this->transaction_model->transaction_check($record->id_coa);
		if ($tran_check){ // 005
		$query=$this->transaction_model->trial_balance($tdate,$record->id_coa,$flag);
		$n=0;$val='';
		if ($query && is_array($query)){ // 0010
			$ttl=0;
				foreach($query as $val){
					$n=$n+1;
					//echo $val->amount;
					$debit_amount=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					$debit_ttl+=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					$credit_amount=$val->amount<0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					
					$credit_ttl=$credit_ttl+$credit_amount;
					
					$ttl+=$val->amount;
					$ttls=number_format($ttl,2)<0 ? '('.(number_format(substr($ttl,1),2)).')' : number_format($ttl,2);
					$credit_amounts= $credit_amount!=0 ? number_format(substr($credit_amount,1),2) : '';
					$debit_amounts=$debit_amount!=0 ? number_format($debit_amount,2) : '';
					$currencyD=$debit_amounts<>0 && $debit_amounts!='' ? $currency : '' ;
					$currencyC=$credit_amounts<>0 && $credit_amounts!='' ? $currency : '' ;
					
					echo "<tr><td id='level4' >".$this->coa_model->get_field($val->id_coa,'acchead')." </td><td id='atype' >$record->atype</td><td id='currency'>".$currencyD."</td><td id='right'>".$debit_amounts."</td><td id='currency'>".$currencyC."</td><td id='right'>".$credit_amounts."</td></tr>"; 
								}
							} // 010
			
		}
		else { // 005

	echo "<tr ><td  id='level2'>$record->acchead </td><td id='atype'>$record->atype</td><td></td><td></td><td id='right' ></td><td id='right'></td></tr>"; 

			//=================================================================================================================================
		 $pl=''; //echo $record->acchead."<br>";
		 if ($record->acchead=='Profit/loss'): //echo "hasan habib";
		 		$profitloss_D=''; $profitloss_C='';
				
				$this->transaction_model->tb_previos_profit($tdate)>0 ? $profitloss_D= number_format($this->transaction_model->tb_previos_profit($tdate),2) : 
				$profitloss_C= number_format(substr($this->transaction_model->tb_previos_profit($tdate),1),2);
				
				$this->transaction_model->tb_previos_profit($tdate)!=0 ? $pl=$this->transaction_model->tb_previos_profit($tdate) : '';
				
					$st=$pl>0 ? "(Loss before $period_1)" : "(Profit before $period_1)";
					echo "<tr><td id='level4' >".$record->acchead."$st</td><td id='atype'>$record->atype</td><td id='currency'></td><td id='right'>$profitloss_D</td><td id='currency'></td><td id='right'>$profitloss_C</td></tr>"; 
 		endif;
		//=====================================================================================================================================

$records=$this->coa_model->find_all_by('id_parent',$record->id_coa);
if (is_array($records)){ // 006
	foreach($records as $record){ // 007
	$tran_check=$this->transaction_model->transaction_check($record->id_coa);
		if ($tran_check){ // 005
		
		$query=$this->transaction_model->trial_balance($tdate,$record->id_coa,$flag);
		$n=0;$val='';
		if ($query && is_array($query)){ // 0010
			$ttl=0;
				foreach( $query as $val){
					$n=$n+1;
					//echo $val->amount;
					$debit_amount=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					$debit_ttl+=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					$credit_amount=$val->amount<0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					
					$credit_ttl=$credit_ttl+$credit_amount;
					
					$ttl+=$val->amount;
					$ttls=number_format($ttl,2)<0 ? '('.(number_format(substr($ttl,1),2)).')' : number_format($ttl,2);
					$credit_amounts= $credit_amount!=0 ? number_format(substr($credit_amount,1),2) : '';
					$debit_amounts=$debit_amount!=0 ? number_format($debit_amount,2) : '';
					$currencyD=$debit_amounts<>0 && $debit_amounts!='' ? $currency : '' ;
					$currencyC=$credit_amounts<>0 && $credit_amounts!='' ? $currency : '' ;
					
					echo "<tr><td id='level4' >".$this->coa_model->get_field($val->id_coa,'acchead')."</td><td id='atype'>$record->atype</td><td id='currency'>".$currencyD."</td><td id='right'>".$debit_amounts."</td><td id='currency'>".$currencyC."</td><td id='right'>".$credit_amounts."</td></tr>"; 

								}
							} // 010
			
		}
		else { // 005	
$records=$this->coa_model->find_all_by('id_parent',$record->id_coa);
if (is_array($records)){ // 008
	foreach($records as $record){ // 009
	if ($record->atype=='Group') :
	echo "<tr ><td  id='level3'>$record->acchead </td><td id='atype'>$record->atype</td><td></td><td></td><td id='right' ></td><td id='right'></td></tr>"; 
		endif;
		$query=$this->transaction_model->trial_balance($tdate,$record->id_coa,$flag);
		$n=0;
		if ($query && is_array($query)){ // 0010
			$ttl=0;
				foreach( $query as $val){
					$n=$n+1;
					//echo $val->amount;
					$debit_amount=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					$debit_ttl+=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					$credit_amount=$val->amount<0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
					
					$credit_ttl=$credit_ttl+$credit_amount;
					
					$ttl+=$val->amount;
					$ttls=number_format($ttl,2)<0 ? '('.(number_format(substr($ttl,1),2)).')' : number_format($ttl,2);
					$credit_amounts= $credit_amount!=0 ? number_format(substr($credit_amount,1),2) : '';
					$debit_amounts=$debit_amount!=0 ? number_format($debit_amount,2) : '';
					
					$currencyD=$debit_amounts<>0 && $debit_amounts!='' ? $currency : '' ;
					$currencyC=$credit_amounts<>0 && $credit_amounts!='' ? $currency : '' ;

					echo "<tr><td id='level4' >".$this->coa_model->get_field($val->id_coa,'acchead')."</td><td id='atype'>$record->atype</td><td id='currency'>".$currencyD."</td><td id='right'>".$debit_amounts."</td><td id='currency'>".$currencyC."</td><td id='right'>".$credit_amounts."</td></tr>"; 
								}
							}  else {// 011 else
					
					$records=$this->coa_model->find_all_by(array('id_parent'=>$record->id_coa));
					if (is_array($records)){ // 008
						foreach($records as $record){ // 009
						
						if ($record->atype=='Group') :
						echo "<tr ><td  id='level4'>$record->acchead </td><td id='atype'>$record->atype</td><td></td><td></td><td id='right' ></td><td id='right'></td></tr>"; 						endif;
							
							$query=$this->transaction_model->trial_balance($tdate,$record->id_coa,$flag);
							$n=0;
							if ($query && is_array($query)){ // 0012
								$ttl=0;
									foreach( $query as $val){
										$n=$n+1;
										//echo $val->amount;
										$debit_amount=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
										$debit_ttl+=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
										$credit_amount=$val->amount<0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
										
										$credit_ttl=$credit_ttl+$credit_amount;
										
										$ttl+=$val->amount;
										$ttls=number_format($ttl,2)<0 ? '('.(number_format(substr($ttl,1),2)).')' : number_format($ttl,2);
										$credit_amounts= $credit_amount!=0 ? number_format(substr($credit_amount,1),2) : '';
										$debit_amounts=$debit_amount!=0 ? number_format($debit_amount,2) : '';
										
										$currencyD=$debit_amounts<>0 && $debit_amounts!='' ? $currency : '' ;
										$currencyC=$credit_amounts<>0 && $credit_amounts!='' ? $currency : '' ;
					
										echo "<tr><td id='level5' >".$this->coa_model->get_field($val->id_coa,'acchead')."</td><td id='atype'>$record->atype</td><td id='currency'>".$currencyD."</td><td id='right'>".$debit_amounts."</td><td id='currency'>".$currencyC."</td><td id='right'>".$credit_amounts."</td></tr>"; 
													}
												}	else { // 013
					$records=$this->coa_model->find_all_by('id_parent',$record->id_coa);
					if (is_array($records)){ // 008
						foreach($records as $record){ // 009
					
						
							$query=$this->transaction_model->trial_balance($tdate,$record->id_coa,$flag);
							$n=0;
							if ($query && is_array($query)){ // 0012
								$ttl=0;
									foreach( $query as $val){
										$n=$n+1;
										//echo $val->amount;
										$debit_amount=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
										$debit_ttl+=$val->amount>0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
										$credit_amount=$val->amount<0 ? $this->transaction_model->sc($val->amount,$sc) : 0;
										
										$credit_ttl=$credit_ttl+$credit_amount;
										
										$ttl+=$val->amount;
										$ttls=number_format($ttl,2)<0 ? '('.(number_format(substr($ttl,1),2)).')' : number_format($ttl,2);
										$credit_amounts= $credit_amount!=0 ? number_format(substr($credit_amount,1),2) : '';
										$debit_amounts=$debit_amount!=0 ? number_format($debit_amount,2) : '';
										
										$currencyD=$debit_amounts<>0 && $debit_amounts!='' ? $currency : '' ;
										$currencyC=$credit_amounts<>0 && $credit_amounts!='' ? $currency : '' ;
					
										echo "<tr><td id='level5' >".$this->coa_model->get_field($val->id_coa,'acchead')."</td><td id='atype'>$record->atype</td><td id='currency'>".$currencyD."</td><td id='right'>".$debit_amounts."</td><td id='currency'>".$currencyC."</td><td id='right'>".$credit_amounts."</td></tr>"; 
													}
												}	// 012	 					
						}}
													}// 013	 					
						}}
							} // 011
						}// 009

					}// 008
		}	
				}// 007

			}// 006
		} // 005
	  }// 004

	 }// 003
  }// 002

}// 001
					$pl>0 ? $credit_ttl+=$pl  :$credit_ttl+=$pl;
					$debit_ttls=$debit_ttl!=0 ? number_format($debit_ttl,2) : '';
					$credit_ttls=$credit_ttl!=0 ? number_format(substr($credit_ttl,1),2) : '';

	echo "<tr id='rpt_bottom'><td  id='right'>Total</td><td></td><td id='currency'>".$currency."</td><td id='right' >".$debit_ttls."</td><td id='currency'>".$currency."</td><td id='right'>".$credit_ttls."</td></tr>"; 
		
	echo "</table>";

	
echo "</div>";
//echo "<div id='report_footer'> 
//<div id='header_left'>
//					<p  id='p'></p>
//				<p id='p'>File Location: /content/transaction/trial_balance</p>
//				</div>
//				<div id='header_right'>
//				<p  id='p'>Printed By: Hasan Habib</p>
//				<p id='p'>Printed Date: ".date('d-m-Y')."</p>
//				</div>
//</div>";

?>