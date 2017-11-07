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
    <title>Slides &laquo; Admin</title>
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
            <a href="profile.html">
              <i class="fa fa-user"></i>个人中心</a>
          </li>
          <li>
            <a href="login.html">
              <i class="fa fa-sign-out"></i>退出</a>
          </li>
        </ul>
      </nav>
      <div class="container-fluid">
        <div class="page-title">
          <h1>图片轮播</h1>
        </div>
        <!-- 有错误信息时展示 -->
        <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
        <div class="row">
          <div class="col-md-4">
            <form>
              <h2>添加新轮播内容</h2>
              <div class="form-group">
                <label for="image">图片</label>
                <!-- show when image chose -->
                <img class="help-block thumbnail" style="display: none">
                <input id="image" class="form-control" name="image" type="file">
              </div>
              <div class="form-group">
                <label for="text">文本</label>
                <input id="text" class="form-control" name="text" type="text" placeholder="文本">
              </div>
              <div class="form-group">
                <label for="link">链接</label>
                <input id="link" class="form-control" name="link" type="text" placeholder="链接">
              </div>
              <div class="form-group">
                <button class="btn-save btn btn-primary"  type="submit">添加</button>
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
                  <th class="text-center">图片</th>
                  <th>文本</th>
                  <th>链接</th>
                  <th class="text-center" width="100">操作</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center">
                    <input type="checkbox">
                  </td>
                  <td class="text-center">
                    <img class="slide" src="../static/uploads/slide_1.jpg">
                  </td>
                  <td>XIU功能演示</td>
                  <td>#</td>
                  <td class="text-center">
                    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    <input type="checkbox">
                  </td>
                  <td class="text-center">
                    <img class="slide" src="../static/uploads/slide_2.jpg">
                  </td>
                  <td>XIU功能演示</td>
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
  $pageName = 'slides';
  // 引入边栏
  require_once 'inc/aside.php';
  ?>

      <script src="../static/assets/vendors/jquery/jquery.js"></script>
      <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
      <script>
        NProgress.done()
      </script>
      <!-- 导入模板引擎 -->
      <script src="../static/assets/vendors/art-template/template-web.js"></script>
      <!-- 定义模板 -->
      <script type='text/html' id='slides'>
        {{each data.value}}
        <tr>
          <td class="text-center">
            <input type="checkbox">
          </td>
          <td class="text-center">
            <img class="slide" src="{{$value.image}}">
          </td>
          <td>{{$value.text}}</td>
          <td>{{$value.link}}</td>
          <td class="text-center">
            <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
          </td>
        </tr>
        {{/each}}
      </script>
  </body>

  </html>
  <!-- 需求们
  1.用户选择图片 ajax上传 预览
  2.页面打开 获取数据 配合模板引擎 渲染到页面上
    导入模板引擎
    定义模板 挖坑
    填坑 使用
  3.点击添加按钮 获取输入的信息  添加到 页面中的一个 js数组中  调用ajax接口 回调函数中 重新获取数据
-->
  <script>
    $(function () {
      // 需求1
      $('#image').change(function () {
        // formData
        var formData = new FormData($('form')[0]);

        // ajax发送formData
        $.ajax({
          url: './upload.php',
          type: 'post',
          data: formData,
          contentType: false, // 当有文件要上传时，此项是必须的，否则后台无法识别文件流的起始位置(详见：#1)
          processData: false, // 是否序列化data属性，默认true(注意：false时type必须是post，详见：#2)
          success: function (data) {
            console.log(data);
            $('.help-block').attr('src', data).fadeIn();
          }
        })
      })

      // 定义数据 一会来操纵他
      var slidesDataArr = null;

      // 抽取为 函数
      function loadData() {
        $.ajax({
          url: '/admin/options.php',
          type: 'get',
          data: {
            type: 'slides'
          },
          success: function (backData) {
            console.log(backData);
            // 转化为 对应的 js对象
            backData.data.value = JSON.parse(backData.data.value);
            console.log(backData);
            $('tbody').html(template('slides', backData));
            // 保存数据
            slidesDataArr = backData.data.value;
          }
        })
      }

      // 需求2
      loadData();

      // 需求3
      $('.btn-save').click(function(event){
        // 阻止默认行为
        event.preventDefault();

        // 获取 输入的内容
        //定义对象 保存数据
        var obj = {};
        $('form input').each(function(i,e){
          obj[e.name] = e.value;
        })
        // 修改 image这个可以
        obj['image'] = $('.help-block').attr('src');
        console.log(obj);

        // 添加到 数组中
        slidesDataArr.push(obj);

        // 调用接口 添加到 数据库
        $.ajax({
          url:'/admin/options.php',
          type:'post',
          data:{
            type:'slides',
            data:JSON.stringify(slidesDataArr)
          },
          success:function(data){
            console.log(data);
            // 重新获取数据
            loadData();
          }
        })
      })

    })
  </script>