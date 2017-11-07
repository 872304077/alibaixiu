<?php
  // 获取 请求的方式
  // 可以获取到很多详细的信息
  // print_r($_SERVER);
  // print_r($_SERVER['REQUEST_METHOD']);

  $method = $_SERVER['REQUEST_METHOD'];
  // 被打过来是 get请求

  // 定义了一个变量 保存 提示信息
  $message = null;

  // 自己提交给自己 是 post请求
  // 如果是 post提交过来的 我们要去验证用户名 密码 是否正确
  if($method=='POST'){
    // 获取提交过来的数据
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 去数据库验证是否正确
    // 引入 配置
    require_once '../config.php';
    // 引入 函数
    require_once '../functions.php';

    $data = my_query("SELECT * FROM users WHERE email ='$email' and password = '$password'");

    // print_r($data);

    if(count($data)==1){
      // 记录登陆状态
      // setcookie('isLogin','yes');
      // cookie不安全 使用 session来记录用户的登陆状态
      session_start();
      // 超全局变量来操纵session
      // 直接保存登陆的用户信息 方便其他的地方使用
      $_SESSION['login_user_data'] = $data ;

      // 对
      header('location:./index.php');
    }else{
      // 不对
      $message = '用户名,或密码错误';
    }

  }

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form method="post" action="" class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if($message!=null){ ?>
        <div class="alert alert-danger">
          <strong>错误！</strong><?php echo $message; ?>
        </div>
      <?php } ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name='email' type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name='password' type="password" class="form-control" placeholder="密码">
      </div>
      <input type="submit"class="btn btn-primary btn-block" value='登陆' >
    </form>
  </div>
</body>
</html>
