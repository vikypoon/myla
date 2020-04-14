<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permission;
use App\Model\Role;
class RoleController extends Controller
{
    public function index(){
    	return view('admin/role/list');
    }

    public function add(){
    	$per = Permission::all();
    	return view('admin/role/add',compact('per'));
    }

    public function doAdd(Request $request){
    	$input = $request->except('_token');
    	if (!empty($input)) {
    		$role = Role::create($input['role_name']);
    	}
    	foreach ($input['permission'] as $value) {
    		\Db::table('role_permission')->insert(['role_id'=>$v['role_id'],'access_id'=>$v]);
    	}
    }
}
