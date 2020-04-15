<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/css/font.css">
        <link rel="stylesheet" href="/css/xadmin.css">
        <script type="text/javascript" src="/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/js/xadmin.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>角色</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_email" name="role_name" class="layui-input"></div>
                        </div>
                    <div class="layui-form-item" style="width:500px;">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>权限</label>
                            @foreach ($per as $v)
                        <div class="layui-input-inline" style="width:50px;">
                            <input type="checkbox" name="permission[]" title="{{$v->name}}" value="{{$v->permission_id}}" lay-skin="primary">
                        </div>
                        @endforeach
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            <span class="x-red">*</span>序号</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_repass" name="sort"  class="layui-input" value="100"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer','jquery'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                
                //监听提交
                form.on('submit(add)',
                function(data) {
                    console.log(data);
                    //发异步，把数据提交给php

                    $.ajax({
                        method:'post',
                        url:'/index.php/admin/role/doAdd',
                        data:data.field,
                        dataType:'JSON',   
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                                if (data.code == 1) {
                                    layer.msg(data.msg,{icon:6,time:3000},function(){ 
                                         // 获得frame索引
                                        var index = parent.layer.getFrameIndex(window.name);
                                        //关闭当前frame
                                        parent.layer.close(index);
                                        parent.location.reload(true);
                                    });
                                }else if(data.code == 0){
                                    layer.alert(data.msg,{icon:5,time:3000},function(){
                                        // parent.location.reload(true);
                                    });
                                }
                        },
                        error:function(){

                        }

                    });

                    // layer.alert("增加成功", {
                    //     icon: 6
                    // },
                    // function() {
                    //     //关闭当前frame
                    //     xadmin.close();

                    //     // 可以对父窗口进行刷新 
                    //     xadmin.father_reload();
                    // });
                    return false;
                });

            });</script>
        <script>var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();</script>
    </body>

</html>