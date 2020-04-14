<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'role';

	public $primaryKey = 'role_id';

	protected $guarded = [];

	public $timestamps = false;

}
