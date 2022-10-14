<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * content controller
 */
class content extends Admin_Controller
{

	//--------------------------------------------------------------------


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Transaction.Content.View');
		$this->load->model('transaction_model', null, true);
		$this->load->model('coa/coa_model', null, true);
		$this->load->model('project/project_model', null, true);
		$this->load->model('admission/admission_model', null, true);
		$this->load->model('agent/agent_model', null, true);
		$this->load->model('options/options_model', null, true);
		$this->lang->load('transaction');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::css(null, 'screen');

			//----------- start auto complete--------------
//			Assets::add_js('jquery-1.5.2.js');
//			Assets::add_js('jquery.autocomplete.js');
//			Assets::add_css('jquery.autocomplete.css');
			//----------- end of auto complete
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
			
			
		Template::set_block('sub_nav', 'content/_sub_nav');

		Assets::add_module_js('transaction', 'transaction.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->transaction_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('transaction_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('transaction_delete_failure') . $this->transaction_model->error, 'error');
				}
			}
		}
		$vns=0;$tdate='0000-00-00';$rtype='';
		$this->transaction_model->current_data_view('vn')!=false ?
		list($vns,$fdate,$tdate,$yy,$rtype) =preg_split('[,]',$this->transaction_model->current_data_view('vn')) : '';
		
		$wheres=$rtype=='vn' && $vns=='0' ? array('tdate'=>$tdate) : array('vnumber'=>$vns, 'tdate'=>$tdate);
		
		$records = $this->transaction_model->find_all_by( $wheres);

		Template::set('records', $records);
		Template::set('toolbar_title', $this->coa_model->id_company('company'));
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Transaction object.
	 *
	 * @return void
	 */
	public function create()
	{	
		$this->auth->restrict('Transaction.Content.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_transaction())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('transaction_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'transaction');

				Template::set_message(lang('transaction_create_success'), 'success');
				redirect(SITE_AREA .'/content/transaction');
			}
			else
			{
				Template::set_message(lang('transaction_create_failure') . $this->transaction_model->error, 'error');
			}
		}
		Assets::add_module_js('transaction', 'transaction.js');

		Template::set('toolbar_title', $this->coa_model->id_company('company'));
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Transaction data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('transaction_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/transaction');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Transaction.Content.Edit');

			if ($this->save_transaction('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('transaction_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'transaction');

				Template::set_message(lang('transaction_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('transaction_edit_failure') . $this->transaction_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Transaction.Content.Delete');

			if ($this->transaction_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('transaction_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'transaction');

				Template::set_message(lang('transaction_delete_success'), 'success');

				redirect(SITE_AREA .'/content/transaction');
			}
			else
			{
				Template::set_message(lang('transaction_delete_failure') . $this->transaction_model->error, 'error');
			}
		}
		Template::set('transaction', $this->transaction_model->find($id));
		Template::set('toolbar_title', $this->coa_model->id_company('company'));
		Template::render();
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_transaction($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id_tran'] = $id;
		}
		// make sure we only pass in the fields we want
		
		// debit side
		$this->input->post('ttype')!='xl' ?
			$vn=$this->transaction_model->create_vnumber($this->input->post('transaction_tdate'))
			: $vn=$this->input->post('transaction_vnumber');

		$pp= $this->uri->segment(6);
		!empty($pp) ? '' :
		$this->transaction_model->set_current_data($vn,date('Y-m-d',strtotime($this->input->post('transaction_tdate'))),'','vn','');
		
		$id_coa=$this->coa_model->subhead_parent($this->input->post('transaction_id_coa'));

		$data = array();
		$data['vnumber']        = $this->input->post('transaction_vnumber') ? $this->input->post('transaction_vnumber') : $vn;
		$data['tdate']        = $this->input->post('transaction_tdate') ? date('Y-m-d',strtotime($this->input->post('transaction_tdate'))) : '0000-00-00';
		$data['id_coa']        = $id_coa>0 ? $id_coa :$this->input->post('transaction_id_coa');
		
		$type == 'update' ?
		$data['amount']        = $this->input->post('transaction_amount'):
		$data['amount']        = $this->transaction_model->minusa($this->input->post('transaction_amount'),$this->input->post('ttype') ); 
		
		
		$data['with_coa']        = $this->input->post('ttype')=='jr' || $this->input->post('ttype')=='br' || $this->input->post('ttype')=='be'? $this->input->post('transaction_with_coa') : 
									$type == 'update' ? $this->input->post('transaction_with_coa') 
									: $this->transaction_model->coawitha($this->input->post('ttype')); //$this->input->post('transaction_with_coa');
		$data['id_subhead']        = $id_coa>0 ? $this->input->post('transaction_id_coa') : 0 ;
		$data['id_project']        = $this->input->post('transaction_id_project')!=='' ? $this->input->post('transaction_id_project') : 0;
		$this->input->post('ttype')!='jr' ?
		$data['id_student']        = $this->input->post('transaction_id_student')!=='' ? $this->input->post('transaction_id_student') : 0 : '';
		$data['invoice']        = $this->input->post('transaction_invoice') ? $this->input->post('transaction_invoice') :'';
		$data['idate']        = $this->input->post('transaction_idate') ? $this->input->post('transaction_idate') : '0000-00-00 00:00:00';
		$data['id_user']        = $this->auth->user_id();//$this->input->post('transaction_id_user') ? $this->input->post('transaction_id_user') : '';
		$data['ttype']        = $this->input->post('ttype');
		$data['note']        = $this->input->post('note');
		if($this->transaction_model->options('SC Allowed')=='active'):
			$data['sc_rate']        = $this->input->post('scr');
			$data['sc_amount']        = $this->input->post('scr') * $this->transaction_model->minusa($this->input->post('transaction_amount'),$this->input->post('ttype'));
		endif;
		
		
		if ($type == 'insert')
		{
			// delete credited data
			$id = $this->transaction_model->insert($data);
			
		if ($this->input->post('ttype')!='xl'):	 // XL transaction control
			// credit side total
			$tdate= date('Y-m-d',strtotime($this->input->post('transaction_tdate')));
			
			$wheres=array('flag'=>1,'vnumber'=>$this->input->post('transaction_vnumber'), 'tdate'=>date('Y-m-d',strtotime($this->input->post('transaction_tdate'))));
			$this->transaction_model->delete_where($wheres);
			$this->input->post('flag')=='addmore' ? $amt=$this->transaction_model->sums($this->input->post('transaction_vnumber'),$tdate) : $amt=$this->transaction_model->sums($vn,$tdate);
			//$amt=$this->transaction_model->sums($vn,$tdate) ? $this->transaction_model->sums($vn,$tdate) : 100;
		
			$id_coasub=$this->coa_model->subhead_parent($this->input->post('transaction_with_coa'));
				
			$data = array();
			$data['vnumber']        = $this->input->post('transaction_vnumber') ? $this->input->post('transaction_vnumber') :$vn;
			$data['tdate']        = $this->input->post('transaction_tdate') ? date('Y-m-d',strtotime($this->input->post('transaction_tdate'))) : '0000-00-00';
			$data['id_coa']        =  $this->input->post('ttype')=='jr' || $this->input->post('ttype')=='br' || $this->input->post('ttype')=='be' ? 
									$id_coasub>0 ? $id_coasub : $this->input->post('transaction_with_coa') 
									: $this->transaction_model->coawithb($this->input->post('ttype'));
			
			$data['amount']        = $this->transaction_model->minusb($amt,$this->input->post('ttype'));
			
			$data['with_coa']        = $this->input->post('ttype')=='jr' || $this->input->post('ttype')=='br' ? 
										$this->input->post('transaction_id_coa') : $this->input->post('transaction_id_coa');
										
			$data['id_subhead']        = $id_coasub>0 ? $this->input->post('transaction_with_coa') :  $this->input->post('transaction_id_subhead')!=0 ? $this->input->post('transaction_id_subhead') : 0;
			
			$data['id_project']        = $this->input->post('ttype')!='jr' ? '0': $this->input->post('transaction_id_project')!=='' ? $this->input->post('transaction_id_project') : 0;
			$this->input->post('ttype')=='jr' ?
			$data['id_student']        = $this->input->post('transaction_id_student')!=='' ? $this->input->post('transaction_id_student') : 0 : '';
			$data['flag']        = 1;
			$data['idate']        = $this->input->post('transaction_idate') ? $this->input->post('transaction_idate') : '0000-00-00 00:00:00';
			$data['id_user']        = $this->auth->user_id();//$this->input->post('transaction_id_user') ? $this->input->post('transaction_id_user') : '';
			$data['ttype']        = $this->input->post('ttype');
			$nt=$this->input->post('note_addmore') ? ", ".$this->input->post('note_addmore') : '';
			$data['note']        	= $this->input->post('note').$nt;
			if($this->transaction_model->options('SC Allowed')=='active'): // dual corrency
				$data['sc_rate']        = $this->input->post('scr');
				$data['sc_amount']      = $this->input->post('scr') * $this->transaction_model->minusb($amt,$this->input->post('ttype') );
			endif; // dual corrency
			$id = $this->transaction_model->insert($data);
		
		endif; // XL transaction control

			if (is_numeric($id))
			{
				$return = $id;
			}
			else
			{
				$return = FALSE;
			}
		}
		elseif ($type == 'update')
		{
			$return = $this->transaction_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------
public function report()
	{	
		
		Template::set_view('content/report');
		Template::set('toolbar_title',$this->coa_model->id_company('company'));
        Template::render();
	}

public function ledger()
	{	
		
		Template::set_view('content/ledger');
		Template::set('toolbar_title',$this->coa_model->id_company('company'));
        Template::render();
	}
public function project_cost()
	{	
		
		Template::set_view('content/project_cost');
		Template::set('toolbar_title',$this->coa_model->id_company('company'));
        Template::render();
	}	//--------------------------------------------------------------------
public function project_groupcost()
	{	
		
		Template::set_view('content/project_groupcost');
		Template::set('toolbar_title',$this->coa_model->id_company('company'));
        Template::render();
	}	//-----

public function trial_balance()
	{	
		
		Template::set_view('content/trial_balance');
		Template::set('toolbar_title',' Trial Balance');
        Template::render();
	}	//--------------------------------------------------------------------
public function profit_loss()
	{	
		
		Template::set_view('content/profit_loss');
		Template::set('toolbar_title',' Profit and Loss');
        Template::render();
	}	//--------------------------------------------------------------------
public function balance_sheet()
	{	
		
		Template::set_view('content/balance_sheet');
        Template::render();
	}	//--------------------------------------------------------------------
public function voucher_report()
	{	
		
		Template::set_view('content/voucher_report');
        Template::render();
	}	//--------------------------------------------------------------------
public function group_balance()
	{	
		
		Template::set_view('content/group_balance');
        Template::render();
	}	//--------------------------------------------------------------------
public function daily_expense()
	{	
		
		Template::set_view('content/daily_expense');
        Template::render();
	}	//--------------------------------------------------------------------
	
public function invoice_expense()
	{	
		
		Template::set_view('content/invoice_expense');
        Template::render();
	}	//----
public function rcvd_payment()
	{	
		
		Template::set_view('content/rcvd_payment');
        Template::render();
	}	//----
}