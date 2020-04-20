<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminUser;
use App\Model\Role;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

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

     public function edit($user_id)
    {   
        $user = AdminUser::find($user_id);
        return view('admin.admin.edit',compact('user'));
    }

    public function auth($user_id){
        $user = AdminUser::find($user_id);
        $role = Role::get();
        $my_role = \DB::table('user_role')->where('user_id',$user_id)->get();
        // dd($my_role);
        $my_p = [];
        foreach ($my_role as $v) {
            $my_p[] = $v->role_id;
        }
        return view('admin.admin.auth',compact('user','role','my_p'));
    }

    //授权
    public function doAuth(Request $request){
        $input = $request->all();
        // dd($input);
        $user_id = $input['user_id'];
        DB::beginTransaction();
        try{
            if (!empty($input['role_id'])) {
                \DB::table('user_role')->where('user_id',$input['user_id'])->delete();
                foreach ($input['role_id'] as $v) {
                    \DB::table('user_role')->insert(['user_id'=>$user_id,'role_id'=>$v,'create_time'=>time()]);
                }
                
            }
            DB::commit();
            $data = array('code'=>1,'msg'=>'授权成功');
        }catch (\Exception $e) {
            return $e->getMessage();
            DB::rollBack();
            $data = array('code'=>0,'msg'=>'授权失败');
        }

        return $data;
    }

    public function update(Request $request)
    {
       $input = $request->all();
       $pass = Crypt::encrypt($input['pass']);
       $rs = AdminUser::where(['user_id' => $input['uid']])->update(['user_name' => $input['username'],'email' => $input['email'],'update_time'=>time()]);
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


    public function del($user_id)
    {
        $user = AdminUser::find($user_id);
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
        $user = AdminUser::where('user_id',$rs['user_id'])->first();
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
