<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminUser;
use Illuminate\Support\Facades\Crypt;

class AdminUserController extends Controller
{
    public function index(){
    	$admin = AdminUser::get();
    	return view('admin/admin/list',compact('admin'));
    }

    public function add(){
    	return view('admin/admin/add');
    }

    public function doAdd(Request $request)
    {
        $input = $request->all();
        $user = AdminUser::where(['user_name'=>$input['username']])->first();
        if ($user) {
            $data = [
            'code'=>0,
            'msg' =>'昵称已被占用，换一个'
           ];
           return $data;
        }
        $pass = Crypt::encrypt($input['pass']);
        $info = [
            'user_name'=>$input['username'],
            'password'=>$pass,
            'email'=>$input['email'],
            'create_time'=>time(),
            'update_time'=>time(),
        ];
        $rs = AdminUser::create($info);

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

     public function edit($id)
    {   
        $user = AdminUser::find($id);
        return view('admin.admin.edit',compact('user'));
    }

    public function update(Request $request)
    {
       $input = $request->all();
       $pass = Crypt::encrypt($input['pass']);
       $rs = AdminUser::where(['id' => $input['uid']])->update(['user_name' => $input['username'],'email' => $input['email'],'update_time'=>time()]);
        if ($rs) {
           $data = [
            'code'=> 1,
            'msg' => '修改成功'
           ];
        }else{
            $data = [
            'code'=> 0,
            'msg' => '修改失败'
           ];
        }

        return $data;
       

    }


    public function del($id)
    {
        $user = AdminUser::find($id);
        $rs = $user->delete();
        if ($rs) {
           $data = [
            'code'=> 1,
            'msg' => '删除成功'
           ];
        }else{
            $data = [
            'code'=> 0,
            'msg' => '删除失败'
           ];
        }

        return $data;
    }

    public function status(Request $request)
    {   
        $rs = $request->all();
        // dd($rs);
        $user = AdminUser::where('id',$rs['id'])->first();
        $rs = $user->update(['active'=>$rs['active']]);
        if ($rs) {
           $data = [
            'code'=> 1,
            'msg' => '修改成功'
           ];
        }else{
            $data = [
            'code'=> 0,
            'msg' => '修改失败'
           ];
        }

        return $data;
    }


}
