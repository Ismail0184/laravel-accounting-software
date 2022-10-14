<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Fileentry extends Model {

	//
    protected $table = 'acc_fileentries';


    protected $fillable = ['filename','mime','original_filename', 'module','vnumber', 'com_id', 'user_id'];

}
