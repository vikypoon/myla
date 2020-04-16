<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Permission;
use App\Model\Role;
class RoleController extends Controller
{
    public function index(){
    	 $role = Role::paginate(5);
    	return view('admin/role/list',compact('role'));
    }

    public function add(){
    	$per = Permission::all();
    	return view('admin/role/add',compact('per'));
    }

    public function doAdd(Request $request){
    	$input = $request->except('_token');
    	
	    	try{ 
			     // dump(0000);
	    		if (!empty($input)) {
		    		DB::beginTransaction();
		    		// dd($input);
		    		$role = [
		    			'role_name' => $input['role_name'],
		    			'sort'      => $input['sort'],
		    			'create_time' => time(),
		    			'update_time' => time()
		    		];
		    		// dump(222);
		    		$id = DB::table('role')->insertGetId($role);
		    	// dump($id);
			    	foreach ($input['permission'] as $v) {
			    		\DB::table('role_permission')->insert(['role_id'=>$id,'permission_id'=>$v,'create_time'=>time()]);
			    	}
		    	}
			      DB::commit(); 
			}catch (\Exception $e) { 
			      	//接收异常处理并回滚
					return $e->getMessage();
			      	DB::rollBack(); 
			}

			return redirect('admin/role/index');
    }

    public function edit($id){
    	$role = Role::find($id);
    	$per = $role->permission;
    	$pers = [];
    	// dump($per);
    	$permission = Permission::get();
    	foreach ($per as $v) {
    		$pers[] = $v->permission_id;
    	}
    	// dd($pers);
    	return view('admin/role/edit',compact('role','permission','pers'));
    }
}
