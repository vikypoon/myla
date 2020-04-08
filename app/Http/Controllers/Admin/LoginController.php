<?php

namespace App\Http\Controllers\Admin;
use Request;
use App\Http\Controllers\Controller;
use App\Model\adminUser;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
   
   public function index()
   {
   	return view('admin.login.index');
   }

   public function login()
   {	
   		$input = Request::all();
   		$adminUserModel = new adminUser();
   		$user = $adminUserModel->exists_user($input['username']);
   		$uid = $user['id'];
   		// dd($id);die;
   		if (!$user) {
   			return json_encode(['msg'=>'嗯哼，查无此人！']);
   			exit;
   		}
         $ps = Crypt::encrypt($input['password']);
         // dump($ps);
         // dump($user['password']);
   		if ($input['password'] == Crypt::decrypt($user['password'])) {
   			session()->put('username',$input['username']);
   			session()->put('user_id',$uid);
         // dd(session('username'));
   			return json_encode(['code'=>200,'msg'=>'登录成功']);
   		}else{
   			return json_encode(['code'=>400,'msg'=>'密码不正确']);
   		}
   		

   }


   // 退出
   public function logout()
   {
   	session()->flush();
   	return redirect('admin/login/index');
   }

   

}
