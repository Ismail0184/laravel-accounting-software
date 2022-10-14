<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Invenmasters extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_invenmasters';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['vnumber', 'idate', 'client_id' ,'client' ,'client_address' ,'wh_id' ,'person', 'itype', 'req_id', 'amount', 'note', 'pm_id','im_id','sm_id','currency_id', 'check_id', 'check_action', 'check_note', 'audit_id', 'audit_action', 'audit_note','audit_note', 'com_id', 'proj_id','user_id'];



		public function client() {
        return $this->belongsTo('App\Models\Acc\Clients', 'client_id');
    }

}