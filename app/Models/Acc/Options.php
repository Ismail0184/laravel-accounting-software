<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Options extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_options';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['bstype', 'currency_id', 'yo_date', 'yc_date','export', 'import', 'scenter', 'budget', 'project', 'audit', 'inventory','ipah_id','pcheck_id','cwh_id','olb','scheck_id','invcheck_id', 'tcheck_id', 'tappr_id', 'icheck_id', 'iappr_id', 'rcheck_id', 'rappr_id', 'frcheck_id', 'frappr_id','audit_id','max_pay','mlctd_id','mlctc_id','tlctd_id','tlctc_id','b2btd_id','business','inven_auto_update', 'com_id','user_id'];

}