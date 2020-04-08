<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{	
	public $primaryKey = 'id';

	protected $guarded = [];

	public $timestamps = false;
    public $table = 'admin_user';
    public function exists_user($username)
    {	
    	$user = $this->where(['user_name'=>$username])->first()->toArray();
    	return $user;
    }
}
