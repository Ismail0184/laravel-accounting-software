<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Fabricmasters extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_fabricmasters';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['jobno','booking_id','order_id', 'gtype_id', 'pogarment_id', 'dia_sl', 'diatype_id', 'dmu_id', 'dia_id','structure_id','lycraratio_id','elasten','ydrepeat','fcomposition', 'gsm_id','noyarn','ftype_id', 'unit_id', 'ytype_id', 'ycount_id', 'yconsumption_id', 'ydstripe_id', 'finishing_id', 'washing_id', 'ccuff_id', 'aop_id',  'cprocess_id','consumption','wastage','loss','com_id','user_id'];

	public function gtype() {
        return $this->belongsTo('App\Models\merchandizing\Gtypes', 'gtype_id');
    }
	public function pogarment() {
        return $this->belongsTo('App\Models\merchandizing\Pogarments', 'pogarment_id');
    }
	public function dia() {
        return $this->belongsTo('App\Models\merchandizing\Dias', 'dia_id');
    }
	public function diatype() {
        return $this->belongsTo('App\Models\merchandizing\Diatypes', 'diatype_id');
    }
	public function structure() {
        return $this->belongsTo('App\Models\merchandizing\Structures', 'structure_id');
    }
	public function fcomposition() {
        return $this->belongsTo('App\Models\merchandizing\Fcompositions', 'fcomposition_id');
    }

	public function gsm() {
        return $this->belongsTo('App\Models\merchandizing\Gsms', 'gsm_id');
    }
	public function ftype() {
        return $this->belongsTo('App\Models\merchandizing\Ftypes', 'ftype_id');
    }
	public function unit() {
        return $this->belongsTo('App\Models\merchandizing\munits', 'unit_id');
    }
	public function ytype() {
        return $this->belongsTo('App\Models\merchandizing\Ytypes', 'ytype_id');
    }
	public function ycount() {
        return $this->belongsTo('App\Models\merchandizing\Ycounts', 'ycount_id');
    }
	public function ydstripe() {
        return $this->belongsTo('App\Models\merchandizing\Ydstripes', 'ydstripe_id');
    }
	public function washing() {
        return $this->belongsTo('App\Models\merchandizing\Washings', 'washing_id'); 
    }
	public function ccuff() {
        return $this->belongsTo('App\Models\merchandizing\Ccuffs', 'ccuff_id'); //aop_id
    }
	public function aop() {
        return $this->belongsTo('App\Models\merchandizing\Aops', 'aop_id'); //aop_id
    }
	public function lycraratio() {
        return $this->belongsTo('App\Models\merchandizing\Lycraratios', 'lycraratio_id'); //tycraratio_id
    }
	public function yconsumption() {
        return $this->belongsTo('App\Models\merchandizing\Yconsumptions', 'yconsumption_id'); //tycraratio_id
    }
	public function finishing() {
        return $this->belongsTo('App\Models\merchandizing\Finishings', 'finishing_id'); //tycraratio_id
    }

}