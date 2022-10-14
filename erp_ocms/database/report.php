<style>
	#center{text-align:center;}
	#space { height:100px}
	table { font-size:18px;}
	#lebel { text-align:right}
	#body { background-color:#; margin-top:2%; margin-left:25%; margin-right:25%; padding:5%; border: 3px solid #CCC; max-height:200px;}
</style>

<!--start Reload script-->
	<SCRIPT language=JavaScript>
            function reload(form)
            {
                    var val=form.rpt.options[form.rpt.options.selectedIndex].value;
                    self.location='?rpt=' + val ;
            }
    
    </script>
    
    <SCRIPT language=JavaScript>
            function reload2(form)
            { 		
					var val=form.rpt.options[form.rpt.options.selectedIndex].value;
                    var val2=form.stat.options[form.stat.options.selectedIndex].value;
                   self.location='?rpt=' + val + '&stat=' + val2 ;
            }
    
    </script>
<!--end Reload script-->

<?php
//echo "hasan habib";
//echo "<div align='center' style='font-size:29px; color:red'>ERMS Ltd.</div>";

isset($_GET['rpt']) ? $rpt=$_GET['rpt'] : $rpt='';
isset($_GET['stat']) ? $stat=$_GET['stat'] : $stat='';
$iv=$this->transaction_model->options('Jute Export');

$tdate='';$id_coa='';
if (isset($_POST['save'])){	
		$tdate=date('Y-m-d',strtotime($_POST['tdate']));
		$fdate=date('Y-m-d',strtotime($_POST['fdate']));
		$id_coa=$_POST['id_coa'];
		$vnumber=$_POST['vnumber'];
		$id_project=$_POST['id_project'];
		$invoice=$_POST['invoice'];

		if ($rpt=='Project Report'):
			$this->transaction_model->set_current_data($id_project,$tdate,$fdate,'pro','');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/project_cost'));
		elseif ($rpt=='Ledger Report'):
			$this->transaction_model->set_current_data($id_coa,$tdate,$fdate,'rpt','');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/ledger'));
		elseif ($rpt=='Receipt and Payment'):
			$this->transaction_model->set_current_data($id_coa,$tdate,$fdate,'rpt','');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/rcvd_payment'));
		elseif ($rpt=='Voucher'):
			$this->transaction_model->set_current_data($vnumber,$tdate,$fdate,'vn','');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/voucher_report'));
		elseif ($stat=='Trial Balance'):
			$this->transaction_model->set_current_data($id_coa,$tdate,$fdate,'rpt','');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/trial_balance'));
		elseif ($stat=='Profit and Loss'):
			$this->transaction_model->set_current_data($id_coa,$tdate,$fdate,'rpt','');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/profit_loss'));
		elseif ($stat=='Balance Sheet'):
			$this->transaction_model->set_current_data($id_coa,$tdate,$fdate,'rpt','');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/balance_sheet'));
		elseif ($stat=='Group Balance'):
			$this->transaction_model->set_current_data($id_coa,$tdate,$fdate,'rpt','Group Balance');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/group_balance'));
		elseif ($rpt=='Daily Expense'):
			$this->transaction_model->set_current_data($id_coa,$tdate,$fdate,'rpt','Daily Expense');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/daily_expense'));
		elseif ($rpt=='Invoice Cost' && $iv=='active'):
			$this->transaction_model->set_current_data($id_coa,$tdate,$fdate,'rpt','Invoice');
			header('location: ' .site_url(SITE_AREA .'/content/transaction/invoice_expense/'.$invoice));
		endif;
		
}
// project accounting activation
$pa=$this->transaction_model->options('Project Account');

?>

          <div class="control-group <?php echo form_error('tdate') ? 'error' : ''; ?>">
				<div class='controls'>
					<span class='help-inline'><?php echo form_error('tdate'); ?></span>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" >
                     <div align='center' id="body"><form method="post" action=""> <?php //echo site_url(SITE_AREA .'/content/transaction/') ?>
                        <table >
                        <tr><td id="lebel">Report Category: </td><td><select onchange="javascript:reload(this.form)" name="rpt" id="rpt">
                            <option >Select Category</option>
                            <option <?php echo $rpt=='Ledger Report' ? 'selected' : '';?>>Ledger Report</option>
                            <option <?php echo $rpt=='Voucher' ? 'selected' : '';?>>Voucher</option>
                            <option <?php echo $rpt=='Daily Expense' ? 'selected' : '';?>>Daily Expense</option>
                             <option <?php echo $rpt=='Receipt and Payment' ? 'selected' : '';?>>Receipt and Payment</option>
                           
                             <?php if ($iv=='active'): ?>
                            <option <?php echo $rpt=='Invoice Cost' ? 'selected' : '';?>>Invoice Cost</option>
                            <?php endif; ?>
							<?php if ($pa=='active'): ?>
                            <option <?php echo $rpt=='Project Report' ? 'selected' : '';?>>Project Report</option>
                            <?php endif; ?>
                            <option <?php echo $rpt=='Financial Statement' ? 'selected' : '';?>>Financial Statement</option>
                        </select>
						</td></tr>
						  <?php if ($rpt=='Financial Statement'):?>
                        <tr><td id="lebel">Report Name: </td><td>
                        <select onchange="javascript:reload2(this.form)" name="stat" id="stat">
                            <option >Select Report</option>
                            <option <?php echo $stat=='Group Balance' ? 'selected' : '';?>>Group Balance</option>
                            <option <?php echo $stat=='Trial Balance' ? 'selected' : '';?>>Trial Balance</option>
                            <option <?php echo $stat=='Profit and Loss' ? 'selected' : '';?>>Profit and Loss</option>
                            <option <?php echo $stat=='Balance Sheet' ? 'selected' : '';?>>Balance Sheet</option>
                        </select>
                        </td></tr>
                        <?php endif;
							$fdt=''; //echo $rpt;
							$rpt=='Voucher' ? $fdt='none' : 
							$rpt=='Select Category' ? $fdt='none' : 
							$rpt=='Invoice Cost' ? $fdt='none' : 
							$stat=='Group Balance' && $rpt=='Financial Statement' ? $fdt='none' :
							$stat=='Trial Balance' && $rpt=='Financial Statement' ? $fdt='none' :
							$stat=='Balance Sheet' && $rpt=='Financial Statement' ? $fdt='none' : 
							$rpt=='' ? $fdt='none' : '';
							
							$rpt=='Project Report' ? $vn='none' : 
							$rpt=='Invoice Cost' ? $vn='none' : 
							$rpt=='Ledger Report' ? $vn='none' : 
							$rpt=='Receipt and Payment' ? $vn='none' : 
							$rpt=='Daily Expense' ? $vn='none' : 
							$rpt=='Select Category' ? $vn='none' : 
							$stat=='Group Balance' ? $vn='none' : 
							$stat=='Trial Balance' ? $vn='none' : 
							$stat=='Profit and Loss' ? $vn='none' : 
							$stat=='Balance Sheet' ? $vn='none' : 
							$rpt=='' ? $vn='none' : $vn='';
							$rpt=='Invoice Cost' ? $iv='' : $iv='none';
							
							
							$rpt=='Select Category' ? $tdt='none' : 
							$rpt=='Invoice Cost' ? $tdt='none' : 
							$rpt=='' ? $tdt='none' : $tdt='';
							
							$rpt=='Select Category' ? $fdt='none' : '';
							$rpt=='Select Category' ? $sav='none' : 
							$rpt=='' ? $sav='none' :  $sav='';

						?>
                            <tr style="display:<?php echo $fdt ?>"><td id='lebel'>From: 
                            </td><td><input type="text" name="fdate" id="fdate"  value=""  placeholder="Date from"/></td></tr>
                            <tr style="display:<?php echo $tdt ?>"><td id='lebel'>To: 
                            </td><td><input type="text" name="tdate"  id="tdate" value="" placeholder="Date to"/></td></tr>
                            <tr style="display:<?php echo $vn ?>"><td id='lebel'>Voucher Number:
                            </td><td><input type="text" name="vnumber"    placeholder="Voucher No"/></td></tr>
                            
                            <tr style="display:<?php echo $iv ?>"><td id='lebel'>Invoice:
                            </td><td><input type="text" name="invoice"    placeholder="Invoice No"/></td></tr>
                        <?php
                            if ($rpt=='Ledger Report' || $stat=='Group Balance'):
							echo "<tr><td id='lebel'>Account Head: </td><td>";
								
								if ($rpt=='Ledger Report'): $options=$this->transaction_model->dropdown('id_coa','acchead'); endif;
								 
								if ($stat=='Group Balance'): $options=$this->transaction_model->dropdown_group('id_coa','acchead'); endif;
								
								echo form_dropdown('id_coa', $options, set_value('id_coa', isset($coa['tid_coa']) ? $coa['id_coa'] : ''),'');
  								echo "</td></tr>";
                           	else:
							echo "<input type='hidden' name='id_coa' />";
							endif;
							if ($rpt=='Project Report'):
							echo "<tr><td id='lebel'>Project Name : </td><td>";
                            	$options=$this->transaction_model->dropdown_project('id_project','name');
								echo form_dropdown('id_project', $options, set_value('id_coa', isset($coa['tid_coa']) ? $coa['id_coa'] : ''),'');
 								echo "</td></tr>";                     
                            else:
							echo "<input type='hidden' name='id_project' />";
							endif;  
							?>
                       <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" >
                        <?php echo isset($rpt) ? '<tr><td></td><td><input type="submit" name="save" value="Get Report"  style="display:'.$sav.'"/></td></tr>': '';?>
				   </table>
                   <div id='space'>&nbsp;</div>

            </form></div>				
            </div>
	</div>
