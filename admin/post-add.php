<?php
  // 导入配置
  require_once '../config.php';
  // 引入函数
  require_once '../functions.php';

  // 验证登陆
  checkIsLogin();

  // 如果是get请求来的这个页面 
  // 如果是post 新增文章
  if($_SERVER['REQUEST_METHOD']=='POST'){
    // echo '保存';
    // 接受提交过来的数据
    // 标题
    $title=$_POST['title'];
    // 内容 
    $content=$_POST['content'];
    // 别名 
    $slug=$_POST['slug'];

    // print_r($_FILES);
    // 把文件的完整路径保存起来
    // print_r(randomNameWithType($_FILES['feature']['name']));
    $randomFileName = randomNameWithType($_FILES['feature']['name']);
    // 将临时文件  保存起来 static/uploads中
    upload('feature','../static/uploads/'.$randomFileName);
    // 图片 文件的路径  建议 保存的路径 使用 绝对路径  / 从网站的根目录中 往下找
    $feature='/static/uploads/'.$randomFileName; 



    // 分类 
    $category=$_POST['category'];
    // 时间 
    $created=$_POST['created'];
    // 状态 
    $status=$_POST['status'];
    // 用户id 通过session 去获取即可
    $user_id = $_SESSION['login_user_data'][0]['id'];

    // 执行插入语句
    $sql = "
    insert into posts
    (slug,title,feature,created,content,status,user_id,category_id)
    values
    ('$slug','$title','$feature','$created','$content','$status',$user_id,$category);
    ";
    // print_r($sql);

    // 获取受影响的行数
    $rowNums = my_execute($sql);
    // 跳转到 所有文章页面
    header('location:http://www.alibaixiu01.net/admin/posts.php');
  }else{
    // echo '普通访问';
  }

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <!-- 因为要上传文件 需要设置 enctype属性 -->
      <form class="row" method='post' enctype="multipart/form-data" >
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input required id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea  id="content" style='display:none'  class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
            <div class='richText '></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input required id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong class='urlStrong'>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="preview-img help-block thumbnail" style="display: none">
            <input required id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select required id="category" class="form-control" name="category">
              <?php 
                // 执行查询语句
                $sql = 'SELECT * FROM categories';

                // 循环获取的数据 生成 option标签
                $categoriesData = my_query($sql);
                for($i=0;$i<count($categoriesData);$i++){
              ?>
                <option value="<?php echo $categoriesData[$i]['id']; ?>"><?php echo $categoriesData[$i]['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input required id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select required id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <!-- 保存按钮 -->
            <button class="btn-save btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php
    // 定义变量
    $pageName ='post-add';
  // 引入边栏
  require_once 'inc/aside.php';
?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!--  导入 mement.js  -->
  <script  src="../static/assets/vendors/moment/moment.js"></script>
  <!-- 导入富文本编辑器 -->
  <script src='../static/assets/vendors/wangEditor/wangEditor.js'></script>
  <script>NProgress.done()</script>
</body>
</html>
<script>
  /*需求们
    1.别名文本框输入文字时 把 下方的 地址边掉 变为 输入的内容
      输入内容时
        把输入的内容 设置到 下方
    2.选择图片之后 本地预览
      获取本地的图片url
      利用MDN 找到了 如何创建URL 根据文档 找到了 如何传递参数
      HTML5中还会继续讲解
    3.打开页面之后 获取当前的时间 设置给 时间选择input标签
    4.使用富文本编辑器
    5.点击保存时
        获取富文本编辑器中的内容
        设置给textarea
    
  */
  $(function(){
    // 值改变事件
    // onchange 会在 值改变的时候 
    // document.querySelector('#slug').onchange = function(){
    //   console.log('123');
    // }
    // document.querySelector('#slug').oninput = function(){
    //   console.log('input');
    // }
    // jQuery没有提供对应方法的事件 可以使用 on来进行绑定
    // 需求1
    $('#slug').on('input',function(){
      console.log('123');
      // 自己的value
      var thisValue = $(this).val();
      // 修改
      $('.urlStrong').html(thisValue);
    })

    // 需求2
    $('#feature').on('change',function(){
      // 获取files
      $(this)[0].files[0];
      var file = this.files[0];

      // 创建url
      var result = URL.createObjectURL(file);
      // 设置给语言的图片
      $('.preview-img').attr('src',result).show();
    })

    // 需求3 设置当前时间
    // 格式化时间字符串 yyyy-MM-ddThh:mm
    // var data = Date.now()
    // console.log(data);
    // var data = new Date();
    // console.log(data.getDate());
    // console.log(data.getFullYear());
    // input标签 要的是 "2017-10-13T12:12"
    var dateNow = moment().format('YYYY-MM-DDThh:mm');
    console.log(dateNow);
    $('#created').val(dateNow);

    // 4.初始化富文本
    // textarea 用不了这个富文本
    var E = window.wangEditor;
    // var editor2 = new E('#content');
    var editor2 = new E('.richText');
    editor2.create()

    // 5.点击保存按钮 获取内容 设置给 textarea
    $('.btn-save').click(function(event){
      $('#content').val(editor2.txt.html());
      // 阻止默认行为 默认的行为是 提交 现在要测试 所以先阻止他
      // event.preventDefault();
    })
  })

</script>
