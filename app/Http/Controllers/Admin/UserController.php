<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Model\User;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   


        $user = [];
        $listkey = "LIST:USER";
        $haskey = "HASH:USER";
        if (Redis::exists($listkey)) {
            $lists = Redis::lrange($listkey,0,-1);
            foreach ($lists as  $c) {
                $user[] = Redis::hgetall($haskey.$c);
            }
                // foreach ($user as  $d) {
                //     # code...
                // }
            // dd($user);
        }else{
            $user = User::get()->toarray();
            foreach ($user as $a) {
                    Redis::rpush($listkey,$a['id']);
                    Redis::expire($listkey,60);
                    Redis::hmset($haskey.$a['id'],$a);
                    Redis::expire($haskey.$a['id'],60);
            }
        }
        //$user = User::paginate(5);
       return view('admin.user.list',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doAdd(Request $request)
    {
        $input = $request->all();
        $user = User::where(['username'=>$input['username']])->first();
        if ($user) {
            $data = [
            'code'=>0,
            'msg' =>'昵称已被占用，换一个'
           ];
           return $data;
        }
        $pass = Crypt::encrypt($input['pass']);
        $info = [
            'username'=>$input['username'],
            'password'=>$pass,
            'email'=>$input['email']
        ];
        $rs = User::create($info);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $user = User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $input = $request->all();
       // $pass = Crypt::encrypt($input['pass']);
       $rs = User::where(['id' => $input['uid']])->update(['username' => $input['username'],'email' => $input['email']]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del($id)
    {
        $user = User::find($id);
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


    public function delAll(Request $request){
        $input =$request->input('ids');
        dd($input);
        $rs = User::destroy($input);
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
        $user = User::where('id',$rs['id'])->first();
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
