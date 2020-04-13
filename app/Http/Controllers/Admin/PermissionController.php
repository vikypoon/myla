<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permission;

class PermissionController extends Controller
{
    public function index(){
    	return view('admin/permission/list');
    }

    public function add(){
    	return view('admin/permission/add');
    }

    public function doAdd(Request $request){
    	$input = $request->all();
    	$input['create_time'] = time();
    	$input['update_time'] = time();
    	$rs  = Permission::create($input);
    	if ($rs) {
           $data = [
            'code'=>1,
            'msg' =>'添加成功'
           ];
        }else{
            $data = [
            'code'=>0,
            'msg' =>'添加失败'
           ];
        }

        return $data;
    }
}
