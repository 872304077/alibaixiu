<?php
  // 导入 配置
  require_once '../config.php';
  // 引入函数
  require_once '../functions.php';

  // 验证登陆
  checkIsLogin();


  // 新增分类
  // echo '<pre>';
  // print_r($_SERVER);
  // echo '</pre>';
  // 如果是 post提交的
  // 新增 编辑
  if($_SERVER['REQUEST_METHOD']=='POST'){

    // 修改逻辑
    if(!empty($_POST['id'])){
      // 接受数据
      $name = $_POST['name'];
      $slug = $_POST['slug'];
      $id = $_POST['id'];

      // 执行语句
      $sql = " update categories set name='$name' ,slug ='$slug' where id = $id";
      $rowNums = my_execute($sql);

      // 获取结果

    }else{
        // 新增逻辑
        // 接受数据
        $name = $_POST['name'];
        $slug = $_POST['slug'];

        // 生成 sql语句
        // 执行语句
        $sql = "
          insert into categories 
          (slug,name)
          values
          ('$slug','$name')
        ";
        $rowNums = my_execute($sql);
    }
  }else{
    // get逻辑
    // 如果 传递了 deleteIds 过来 删除
    if(isset($_GET['deleteIds'])){
        // 接受 提交过来的 id
        $deleteIds = $_GET['deleteIds'];
    
        // 执行sql语句
        $sql = "delete from categories where id in($deleteIds)";
        $rowNums = my_execute($sql);
    }
  }

  // 判断 有没有id
  // 因为 表单元素 已经添加了 虽然没有设置id值 但是 id还是会被提交过来 只不过 是空而已
  // if(isset($_POST['id'])){
  // 空 true
  // if(!empty($_POST['id'])){
  //   echo '修改';
  // }else{
  //   echo '新增';
  // }

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <!--  如果要提交给自己 action 可以省略 -->
          <form method='post'>
            <h2 class='updateH2'>添加新分类目录</h2>
            <!-- 隐藏的表单元素 目的 是 偷偷的把id存起来 因为编辑的时候需要使用 -->
            <input id='id' name='id' type="text" hidden >
            <div class="form-group">
              <label for="name">名称</label>
              <input required id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input required id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="save btn btn-primary" type="submit">添加</button>
              <button class="cancel btn btn-default btn-cancel" type="button" style="display: none;">取消</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="deleteAll btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input class='checkAll' type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                // 从数据库中 获取 有多少个分类
                $categoriesData = my_query('SELECT * FROM categories');

                // 循环生成tr
                for($i=0;$i<count($categoriesData);$i++){
              ?>
              <tr>
                <td class="text-center"><input value='<?php echo $categoriesData[$i]['id']; ?>' type="checkbox"></td>
                <td><?php echo $categoriesData[$i]['name']; ?></td>
                <td><?php echo $categoriesData[$i]['slug']; ?></td>
                <td class="text-center">
                  <a href="javascript:;" class="updateCurrent btn btn-info btn-xs">编辑</a>
                  <a href="/admin/categories.php?deleteIds=<?php echo $categoriesData[$i]['id'] ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<?php
    // 定义变量
    $pageName ='categories';
  // 引入边栏
  require_once 'inc/aside.php';
?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
<script>
  // 入口函数
  $(function(){
    // 1.全选 反选 类名是 后加的
    $(".checkAll").click(function(){
      // 把 tbody 中的 checkbox 的选中状态变得 跟 全选一样
      $('tbody input[type=checkbox]').prop('checked',$(this).prop('checked'));

      // 3.全选被勾上 出现 反之隐藏
      if($(this).prop('checked')){
        // 类名是后加的 
        $('.deleteAll').fadeIn();
      }else{
        $('.deleteAll').fadeOut();
      }
    })

    // 2.tbody中的 全部被勾选 选中全选 反之 取消选中
    $('tbody input[type=checkbox]').click(function(){
      // 选中的个数
      var checkNum = $('tbody input[type=checkbox]:checked').length;

      // 总个数
      var totalNum = $('tbody input[type=checkbox]').length;

      // 相等
      // 代码写得越凝练 可读性越差
      // 多人开发 建议写if else
      $('.checkAll').prop('checked',checkNum==totalNum);

      // 3.显示 隐藏 批量删除
      if(checkNum!=0){
        $('.deleteAll').fadeIn();
      }else{
        $('.deleteAll').fadeOut();
      }
    })

    // 3.批量删除
    $('.deleteAll').click(function(){
      // tbody中 被选中的 那些 checkbox 进而获取 id 拼接成字符串
      // 拼接的字符串
      var deleteIds ='';
      $('tbody input[type=checkbox]:checked').each(function(index,element){
        // 挨个获取value
        // element.value
        deleteIds+=$(element).val();
        deleteIds+=',';
      })
      // 切掉最后的,
      deleteIds = deleteIds.slice(0,-1);
      console.log(deleteIds);

      // 使用get请求 把数据 发送到 删除页面
      $(this).attr('href','/admin/categories.php?deleteIds='+deleteIds);
    })

    // 4.点击编辑
    $('.updateCurrent').click(function(){
      // 获取 他所在那一行的 name 跟 slug
      // console.log($(this).parent().siblings('td').eq(1).html());
      //        a       td      其他td      索引为1  内容 
      $name = $(this).parent().siblings('td').eq(1).html();
      $slug = $(this).parent().siblings('td').eq(2).html();
      // console.log($slug);

      // 设置到 左边的 form表单中
      $('#name').val($name);
      $('#slug').val($slug);
      
      // 修改h2
      $('.updateH2').html('编辑分类');

      // 显示删除
      $(".cancel").show();

      // 修改保存的内容
      $('.save').html('保存');

      // 把 id 保存到 隐藏的 文本框中
      $('#id').val($(this).parent().siblings('td').eq(0).children('input').val());
    })

    // 5.点击取消
    $('.cancel').click(function(){
      // 自己消失
      $(this).hide();

      // 保存的 内容还原
      $('.save').html('添加');

      // 清空 name slug的值
      $('#name').val('');
      $('#slug').val('');

      // 还原 h2的值
      $('.updateH2').html('添加新分类目录');
    })
  })

</script>
