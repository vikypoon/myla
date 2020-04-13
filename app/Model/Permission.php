<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $table = 'permission';

	public $primaryKey = 'access_id';

	protected $guarded = [];

	public $timestamps = false;

}
