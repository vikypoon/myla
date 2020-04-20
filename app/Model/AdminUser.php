<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{	
    public $table = 'admin_user';

	public $primaryKey = 'user_id';

	protected $guarded = [];

	public $timestamps = false;

	public function role(){
		return $this->belongsToMany('App\Model\Role','user_role','user_id','role_id');
	}

    public function exists_user($username)
    {	
    	$user = $this->where(['user_name'=>$username])->first()->toArray();
    	return $user;
    }
}
