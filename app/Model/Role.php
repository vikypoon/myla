<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'role';

	public $primaryKey = 'role_id';

	protected $guarded = [];

	public $timestamps = false;

	public function permission(){
		return $this->belongsToMany('App\Model\Permission','role_permission','role_id','permission_id');
	}

}
