<?php

// 判断登陆状态
// if($_COOKIE['isLogin']=='yes'){
// 因为替换成了 session 所以这里要判断session 
// PHPSESSID   cp6of36i94nk6apuqp9apkalc7
/* 很多页面需要使用 抽取到function中即可
  session_start();
  if(isset($_SESSION['login_user_data'])){

      //登陆成功
      print_r($_SESSION['login_user_data']);
  }else{
    // 登陆失败
    // 打回登录页
    header('location:./login.php');
  }
*/


/*
      用到的sql语句
  -- 获取数量 总数量
  select count(*) from posts;

  -- 文章的草稿数量
  select count(*) from posts where status = 'drafted';

  -- 分类的数量
  select count(*) from categories;

  -- 评论数量
  select count(*) from comments;

  -- 待审核评论数量
  select count(*) from comments where status ='held';
 */ 

// 引入配置文件
require_once '../config.php';
// 引入函数
require_once '../functions.php';

// 调用 验证用户是否登陆的函数
checkIsLogin();


// 测试函数
// $data = my_query('select count(*) from posts');

// print_r($data);
// print_r($data[0]['count(*)']);

// 总文章数
$posts_count = my_query('select count(*) from posts')[0]['count(*)'];

// 草稿数
$posts_drafted_count = my_query('select count(*) from posts where status = "drafted"')[0]['count(*)'];

// 分类树
$categories_count = my_query('select count(*) from categories')[0]['count(*)'];

// 总评论数
$comments_count =  my_query('select count(*) from comments')[0]['count(*)'];

// 待审核评论数
$comments_held_count =  my_query('select count(*) from comments where status ="held"')[0]['count(*)'];

// 输出 Ctrl+c ctrl+V ctrl+R
// echo $posts_count,$posts_drafted_count,$categories_count,$comments_count,$comments_held_count;



?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.html" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $posts_count; ?></strong>篇文章（<strong><?php echo $posts_drafted_count; ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $categories_count; ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comments_count; ?></strong>条评论（<strong><?php echo $comments_held_count; ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

<?php
  // 引入 aside
  // include 
  // include_once
  // require
  // require_once

  // 定义变量记录是哪个页面
$pageName = 'index';

  // 引入失败 不能执行
require_once './inc/aside.php';
?>


  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
