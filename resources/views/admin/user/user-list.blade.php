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
        <script src="/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/js/xadmin.js"></script>
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a>
              <cite>导航元素</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5">
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加用户','./user-add.html',600,400)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>
                                      <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                                    </th>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>性别</th>
                                    <th>邮箱</th>
                                    <!-- <th>地址</th> -->
                                    <th>状态</th>
                                    <th>操作</th></tr>
                                </thead>
                                <tbody>
                                  @foreach ($user as $v)
                                  <tr>
                                    <td>
                                      <input type="checkbox" name="id"  lay-skin="primary"  data-id="{{$v->id}}"> 
                                    </td>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->username}}</td>
                                    <td>男</td>
                                    <td>{{$v->email}}</td>
                                    <!-- <td>北京市 海淀区</td> -->
                                    <td class="td-status">
                                      <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></td>
                                    <td class="td-manage">
                                      <a onclick="member_stop(this,'{{$v->id}}')" href="javascript:;"  title="启用">
                                        <i class="layui-icon">&#xe601;</i>
                                      </a>
                                      <a title="编辑"  onclick="xadmin.open('编辑','{{url('admin/user/edit/'.$v->id.'')}}',600,400)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                      </a>
                                      <!-- <a onclick="xadmin.open('修改密码','{{url('admin/user/del/'.$v->id.'')}}',600,400)" title="修改密码" href="javascript:;">
                                        <i class="layui-icon">&#xe631;</i>
                                      </a> -->
                                      <a title="删除" onclick="member_del(this,'{{$v->id}}')" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                      </a>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                 {!!$user->render()!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function(data){

          if(data.elem.checked){
            $('tbody input').prop('checked',true);
          }else{
            $('tbody input').prop('checked',false);
          }
          form.render('checkbox');
        }); 
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });


      });

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){
              if($(obj).attr('title')=='启用'){
                $.ajax({
                  url:'/index.php/admin/user/status',
                  type:'post',
                  data:{"id":id,"active":"1"},
                  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success:function(data){
                    // alert(666);
                    if (data.code == 1) {
                        $(obj).attr('title','停用')
                        $(obj).find('i').html('&#xe62f;');
                        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                        layer.msg('已停用!',{icon: 5,time:1000});

                    }
                  }
                })
              }else{
                $.ajax({
                  url:'/index.php/admin/user/status',
                  type:'post',
                  data:{"id":id,"active":"0"},
                  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success:function(data){
                    // alert(666);
                    if (data.code == 1) {
                        $(obj).attr('title','启用')
                        $(obj).find('i').html('&#xe601;');

                        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                        layer.msg('已启用!',{icon: 5,time:1000});

                    }
                  }
                })
              }
              
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
        
          layer.confirm('确认要删除吗？',function(index){
             $.post('/index.php/admin/user/del/'+id,{"_method":"post","_token":"{{csrf_token()}}"},function(data){
                if (data.code == 1) {
                  $(obj).parents("tr").remove();
                  layer.msg(data.msg,{icon:1,time:3000});
                  // parent.location.reload(true);
                }
             })
              
          });
      }



      function delAll (argument) {
        var ids = [];

        // 获取选中的id 
        $(".layui-form-checked").not('.header').each(function(i,v) {
            if($(this).prop('checked')){
               ids.push($(this).val())
            }
            // var u = $(v).attr('data-id');
            // ids.push(u);
        });
  
            alert(ids);
        layer.confirm('确认要删除吗？',function(index){
            //捉到所有被选中的，发异步进行删除
            $.post('/index.php/admin/user/delAll',{"id":ids,"_token":"{{csrf_token()}}"},function(){
              if (data.code == 1) {
                 $(".layui-form-checked").not('.header').parents('tr').remove();
                  layer.msg(data.msg,{icon:6,time:3000});
                  // parent.location.reload(true);
                }else{
                  layer.msg(data.msg,{icon:5,time:3000});
                }
            });
        });
      }
    </script>
</html>