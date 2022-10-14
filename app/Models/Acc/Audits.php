<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Audits extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_audits';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'vnumber', 'note', 'sendto', 'audit_action', 'reply_id', 'reply_note', 'com_id', 'user_id'];

}