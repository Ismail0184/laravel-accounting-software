<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Session;
use DB;
abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function comp()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company=DB::table('acc_companies')->where('id',$com_id)->first();
		return $company->name;
	}
    public function dropdown_array($data, $key='id', $value='name')
    {        
        $dropdown[''] = 'Select...';
        foreach($data as $dropdown_data){
            $dropdown[$dropdown_data[$key]] = $dropdown_data[$value];
        }
        
        return $dropdown;
    }
    
	/**
	 * Display a dropdown list for month.
	 *
	 * @return Array
	 */
    public function search_month()
    {        
        return array(
            '' => 'All',
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        );
    }
    
	/**
	 * Display a dropdown list for year.
	 *
	 * @return Array
	 */
    public function search_year()
    {        
        
        for($i=2001; $i<=date('Y'); $i++) {
            $year[$i] = $i;
        }
        
        return $year;
    }

}
