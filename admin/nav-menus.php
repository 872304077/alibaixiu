<?php
  // 引入函数
  require_once '../functions.php';

  // 验证登陆
  checkIsLogin();
?>
  <!DOCTYPE html>
  <html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <title>Navigation menus &laquo; Admin</title>
    <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
    <link rel="stylesheet" href="../static/assets/css/admin.css">
    <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
  </head>

  <body>
    <script>
      NProgress.start()
    </script>

    <div class="main">
      <nav class="navbar">
        <button class="btn btn-default navbar-btn fa fa-bars"></button>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="profile.php">
              <i class="fa fa-user"></i>个人中心</a>
          </li>
          <li>
            <a href="logout.php">
              <i class="fa fa-sign-out"></i>退出</a>
          </li>
        </ul>
      </nav>
      <div class="container-fluid">
        <div class="page-title">
          <h1>导航菜单</h1>
        </div>
        <!-- 有错误信息时展示 -->
        <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
        <div class="row">
          <div class="col-md-4">
            <form>
              <h2>添加新导航链接</h2>
              <div class="form-group">
                  <label for="icon">图标类名</label>
                  <input id="icon" class="form-control" name="icon" type="text" placeholder="文本">
                </div>
              <div class="form-group">
                <label for="text">文本</label>
                <input id="text" class="form-control" name="text" type="text" placeholder="文本">
              </div>
              <div class="form-group">
                <label for="title">标题</label>
                <input id="title" class="form-control" name="title" type="text" placeholder="标题">
              </div>
              <div class="form-group">
                <label for="href">链接</label>
                <input id="href" class="form-control" name="link" type="text" placeholder="链接">
              </div>
              <div class="form-group">
                <button class="btn-save btn btn-primary">添加</button>
              </div>
            </form>
          </div>
          <div class="col-md-8">
            <div class="page-action">
              <!-- show when multiple checked -->
              <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
            </div>
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center" width="40">
                    <input type="checkbox">
                  </th>
                  <th>文本</th>
                  <th>标题</th>
                  <th>链接</th>
                  <th class="text-center" width="100">操作</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center">
                    <input type="checkbox">
                  </td>
                  <td>
                    <i class="fa fa-glass"></i>奇趣事</td>
                  <td>奇趣事</td>
                  <td>#</td>
                  <td class="text-center">
                    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    <input type="checkbox">
                  </td>
                  <td>
                    <i class="fa fa-phone"></i>潮科技</td>
                  <td>潮科技</td>
                  <td>#</td>
                  <td class="text-center">
                    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    <input type="checkbox">
                  </td>
                  <td>
                    <i class="fa fa-fire"></i>会生活</td>
                  <td>会生活</td>
                  <td>#</td>
                  <td class="text-center">
                    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <?php
  // 定义变量
  $pageName = 'nav-menus';
  // 引入边栏
  require_once 'inc/aside.php';
?>

      <script src="../static/assets/vendors/jquery/jquery.js"></script>
      <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
      <script>
        NProgress.done()
      </script>
      <!-- 导入模板引擎 -->
      <script src='../static/assets/vendors/art-template/template-web.js'></script>
      <!-- 定义模板 -->
      <script type='text/html' id='template'>
        {{each data.value}}
        <tr>
          <td class="text-center">
            <input type="checkbox">
          </td>
          <td>
            <i class="{{$value.icon}}"></i>{{$value.text}}</td>
          <td>{{$value.title}}</td>
          <td>{{$value.link}}</td>
          <td class="text-center">
            <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
          </td>
        </tr>
        {{/each}}
      </script>
  </body>

  </html>
  <!-- 
  需求们
    1.页面打开获取数据 渲染到页面上
    2.循环数据 生成html结构
      导入模板引擎
      定义模板 挖坑 
      填坑 使用
    3.点击添加 保存数据 到js数组中 发送给服务器
 -->
  <script>
    // dom元素 加载完毕
    $(function () {
      // 定义一个变量 保存 当前页面的选项
      var navDataArr = null;

      // 抽取获取数据的代码
      function loadData(){
          $.ajax({
          url: '/admin/options.php',
          type: 'get',
          data: {
            type: 'nav'
          },
          success: function (backData) {
            console.log(backData);
            // 返回过来的数据中 这部分数据 还是 JSON格式的字符串
            backData.data.value = JSON.parse(backData.data.value);
            console.log(backData);
            var result = template('template', backData);
            console.log(result);
            // 设置给tbody
            $('tbody').html(result);

            // 保存数据到去定义的变量中
            navDataArr = backData.data.value;
          }
        })
      }

      // 默认调用一次
      loadData();



      // 需求2
      $('.btn-save').click(function (event) {
        //阻止默认行为
        event.preventDefault();

        // 获取值  添加到数组中
        // 定义对象
        var obj = {};

        // 获取form表单中的input标签
        $('form input').each(function(i,e){
          obj[e.name] = e.value;
        })
        console.log(obj);

        // 添加到
        navDataArr.push(obj);
        // console.log(navDataArr);

        // 调用接口 把 数据添加进去
        $.ajax({
          url:'/admin/options.php',
          type:'post',
          data:{
            type:'nav',
            data:JSON.stringify(navDataArr)
          },
          success:function(data){
            console.log(data);

            // 再次获取当前页的数据
            loadData();
          }
        })
      })


    })
  </script>