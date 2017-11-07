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
    <title>Comments &laquo; Admin</title>
    <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
    <link rel="stylesheet" href="../static/assets/css/admin.css">
    <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
    <style>
      td {
        /* 最大的 宽度 为 500px */
        max-width: 500px;
      }
    </style>
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
          <h1>所有评论</h1>
        </div>
        <!-- 有错误信息时展示 -->
        <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
        <div class="page-action">
          <!-- show when multiple checked -->
          <div class="btn-batch" style="display: none">
            <button class="approvedAll btn btn-info btn-sm">批量批准</button>
            <button class="heldAll btn btn-warning btn-sm">批量驳回</button>
            <button class="deleteAll btn btn-danger btn-sm">批量删除</button>
          </div>
          <ul class="pagination pagination-sm pull-right">
            <li>
              <a href="#">上一页</a>
            </li>
            <li>
              <a href="#">1</a>
            </li>
            <li>
              <a href="#">2</a>
            </li>
            <li>
              <a href="#">3</a>
            </li>
            <li>
              <a href="#">下一页</a>
            </li>
          </ul>
        </div>
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th class="text-center" width="40">
                <input class='checkAll' type="checkbox">
              </th>
              <th>作者</th>
              <th>评论</th>
              <th>评论在</th>
              <th>提交于</th>
              <th>状态</th>
              <th class="text-center" width="100">操作</th>
            </tr>
          </thead>
          <tbody>
            <tr class="danger">
              <td class="text-center">
                <input type="checkbox">
              </td>
              <td>大大</td>
              <td>楼主好人，顶一个</td>
              <td>《Hello world》</td>
              <td>2016/10/07</td>
              <td>未批准</td>
              <td class="text-center">
                <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
                <a href="javascript:;" class="btn-delete btn btn-danger btn-xs">删除</a>
              </td>
            </tr>
            <tr>
              <td class="text-center">
                <input type="checkbox">
              </td>
              <td>大大</td>
              <td>楼主好人，顶一个</td>
              <td>《Hello world》</td>
              <td>2016/10/07</td>
              <td>已批准</td>
              <td class="text-center">
                <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
              </td>
            </tr>
            <tr>
              <td class="text-center">
                <input type="checkbox">
              </td>
              <td>大大</td>
              <td>楼主好人，顶一个</td>
              <td>《Hello world》</td>
              <td>2016/10/07</td>
              <td>已批准</td>
              <td class="text-center">
                <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
              </td>
            </tr>
          </tbody>
        </table>
    <?php
  // 增加标识变量
    $pageName = 'comments';
  // 引入边栏
    require_once 'inc/aside.php';
    ?>
  </div>
</div>

      <script src="../static/assets/vendors/jquery/jquery.js"></script>
      <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
      <!-- 引入 分页插件 -->
      <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.min.js"></script>
      <script>
        NProgress.done()
      </script>
      <!-- 导入模板引擎 -->
      <script src="../static/assets/vendors/art-template/template-web.js"></script>
      <!-- 定义模板 if(){}else if(){} -->
      <script type='text/html' id='template'>
        {{each data}}
        <tr>
          <td class="text-center">
            <input value='{{$value.id}}' type="checkbox">
          </td>
          <td>{{$value.author}}</td>
          <td>{{$value.content}}</td>
          <td>{{$value.title}}</td>
          <td>{{$value.created}}</td>
          {{if $value.status=='held'}}
          <td>驳回</td>
          {{else if $value.status=='approved'}}
          <td>批准</td>
          {{else if $value.status=='rejected'}}
          <td>拒绝</td>
          {{else if $value.status=='trashed'}}
          <td>废弃</td>
          {{/if}}
          <td class="text-center">
            {{if $value.status=='approved'}}
            <a href="javascript:;" changeId='{{$value.id}}' changeStatus='held' class="btn-change btn btn-warning btn-xs">驳回</a>
            {{else if $value.status=='held'}}
            <a href="javascript:;" changeId='{{$value.id}}' changeStatus='approved' class="btn-change btn btn-info btn-xs">批准</a>
            {{/if}}
            <a href="javascript:;" deleteId="{{$value.id}}" class="btn-delete btn btn-danger btn-xs">删除</a>
          </td>
        </tr>
        {{/each}}
      </script>
  </body>

  </html>
  <script>
/*
    需求们
      1.页面打开 ajax获取 第一页的数据 10条
      2.使用模板引擎把拼接字符串的操作 给省略
        步骤
          定义模板 挖坑 起名字
            起名字的位置 需要根据
          导入模板引擎
          使用对象 去填坑
      3.回调函数中 生成分页的html结构
      4.分页显示
      5.点击删除标签 删除当前的行
        为a标签绑定点击事件
          重点 a标签是动态创建的 不要直接给a标签绑定事件 而是帮给不会被删除的 父元素 使用委托的方式
          删除需要id 
          把id保存到 a标签中
      6.点击批准变为批准&驳回
          修改模板中的a标签
              批准按钮的 href
              增加两个自定义属性 id 状态 
              添加类名
      7.显示隐藏批量操作
        有任何一个 单选被选中 
        反之隐藏
      
      8.全选反选
        添加了类名 checkAll

      9.批量操作
        为tbody中的checkbox 添加 id值  修改模板引擎
        点击批量操作时 获取被选中的 id值 拼接为  12，13，14
          为批量操作 分别添加类名 approvedAll heldAll deleteAll
  */
    $(function () {
      // 定义变量 --页码
      var myPageNum = 1;

      // 抽取函数 --根据页码 获取数据
      function loadData() {
        $.ajax({
          url: '/admin/comments-list.php',
          type: 'get',
          data: {
            pageNum: myPageNum,
            pageSize: 10
          },
          success: function (backData) {
            // console.log(backData);
            // 调用模板引擎
            $('tbody').html(template('template', backData));
          }
        })
      }

      // 直接获取数据
      $.ajax({
        url: '/admin/comments-list.php',
        type: 'get',
        data: {
          pageNum: myPageNum,
          pageSize: 10
        },
        success: function (backData) {
          // console.log(backData);
          // 调用模板引擎
          $('tbody').html(template('template', backData));
          // 初始化分页控件
          $('.pagination').twbsPagination({
            totalPages: backData.totalPage,
            visiblePages: 5,
            // onPageClick 会在我们点击不同页码的时候 触发 可以获取 对应的页码
            onPageClick: function (event, page) {
              console.log(event + '||' + page);
              // 修改变量的值
              myPageNum = page;
              // 调用封装的函数即可
              loadData();
            }
          });
        }

      })

      // 需求5 点击删除一行
      $('tbody').on('click', '.btn-delete', function () {
        // console.log('你把我干掉了哦');
        var deleteId = $(this).attr('deleteid');
        // 调用删除接口
        $.ajax({
          url: '/admin/comments-delete.php',
          type: 'get',
          data: {
            ids: deleteId
          },
          success: function (data) {
            console.log(data);
            // 加载数据
            loadData();
          }
        })
      })

      // 需求6 点击修改状态
      $('tbody').on('click', '.btn-change', function () {
        // 获取保存在标签中的 参数
        var changeId = $(this).attr('changeId');
        var my_changeStatus = $(this).attr('changeStatus');
        $.ajax({
          url: '/admin/comments-changeStatus.php',
          type: 'get',
          data: {
            ids: changeId,
            changeStatus: my_changeStatus
          },
          success: function (data) {
            console.log(data);
            // 重新获取当前这一页的数据
            loadData();
          }
        })
      })

      // 需求7 显示隐藏 批量操作
      // $('tbody input[type=checkbox]').click(function(){
      $('tbody').on('click', 'input[type=checkbox]', function () {
        // 选中的个数 批量操作 显示隐藏
        if ($('tbody input[type=checkbox]:checked').length != 0) {
          $('.btn-batch').fadeIn();
        } else {
          $('.btn-batch').fadeOut();
        }
        // 全选按钮 选中 或者隐藏
        var totalNum = $('tbody input[type=checkbox]').length;
        var checkedNum = $('tbody input[type=checkbox]:checked').length;
        $('.checkAll').prop('checked', totalNum == checkedNum);
      })

      // 需求8 全选反选
      $('.checkAll').click(function () {
        // 修改 tbody中的选中状态 给自己的一样即可
        $('tbody input[type=checkbox]').prop('checked', $(this).prop('checked'));
        // 显示隐藏 顶部的 批量操作按钮
        if ($(this).prop('checked')) {
          $('.btn-batch').fadeIn();
        } else {
          $('.btn-batch').fadeOut();
        }
      })

      // 需求9
      // 批量删除
      $('.deleteAll').click(function () {
        // 定义空字符串拼接数据
        var deleteIds = '';
        // 获取被选中的id
        $('tbody input[type=checkbox]:checked').each(function (i, e) {
          // 生成数据
          deleteIds += e.value;
          deleteIds += ',';
        })
        // 去除最后的,
        deleteIds = deleteIds.slice(0, -1);

        // 调用 接口
        $.ajax({
          url: '/admin/comments-delete.php',
          type: 'get',
          data: {
            ids: deleteIds
          },
          success: function (data) {
            console.log(data);
            // 回调函数中 重新获取数据（
            loadData();
            // 去除 全选的选中状态
            $('.checkAll').prop('checked',false);
          }
        })
      })
      // 批量允许
      $('.approvedAll').click(function () {
        // 定义空字符串拼接数据
        var approvedIds = '';
        // 获取被选中的id
        $('tbody input[type=checkbox]:checked').each(function (i, e) {
          // 生成数据
          approvedIds += e.value;
          approvedIds += ',';
        })
        // 去除最后的,
        approvedIds = approvedIds.slice(0, -1);

        // 调用 接口
        $.ajax({
          url: '/admin/comments-changeStatus.php',
          type: 'get',
          data: {
            ids: approvedIds,
            changeStatus:'approved'
          },
          success: function (data) {
            console.log(data);
            // 回调函数中 重新获取数据（
            loadData();
            // 去除 全选的选中状态
            $('.checkAll').prop('checked',false);
          }
        })

      })
      
      // 批量驳回
      $('.heldAll').click(function () {
        // 定义空字符串拼接数据
        var heldIds = '';
        // 获取被选中的id
        $('tbody input[type=checkbox]:checked').each(function (i, e) {
          // 生成数据
          heldIds += e.value;
          heldIds += ',';
        })
        // 去除最后的,
        heldIds = heldIds.slice(0, -1);

        // 调用 接口
        $.ajax({
          url: '/admin/comments-changeStatus.php',
          type: 'get',
          data: {
            ids: heldIds,
            changeStatus:'held'
          },
          success: function (data) {
            console.log(data);
            // 回调函数中 重新获取数据（
            loadData();
            // 去除 全选的选中状态
            $('.checkAll').prop('checked',false);
          }
        })

      })

    })
  </script>