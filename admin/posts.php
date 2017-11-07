<?php
  // 引入配置文件
  require_once '../config.php';
  // 引入函数
  require_once '../functions.php';

  // 验证登陆
  checkIsLogin();

  // 抽取 转化数据的函数
  function changeStatus($stausEng){
    switch ($stausEng) {
      case 'drafted':
        return '草稿';
      case 'published':
        return '已发布';
      case 'trashed':
        return '废弃';
    }
  }
  // 变量 - 每一页的数据量
  $pageSize =10;

  // 接受页码 验证数据的正确性
  // 起始的id 计算公式是 
  // 1: 0 (页码-1) * 每页数据量
  // 2：10 (页码-1) * 每页数据量
  // 3：20 (页码-1) * 每页数据量
  $pageNum = 1;
  if(isset($_GET['p'])){
    // 保存页码 
    $pageNum = $_GET['p'];
    // 判断页码是否有效
    // 如果比第一页小 
    // 如果比最大的一页还要大  
  }

  // 变量 - 起始索引
  $startIndex = ($pageNum - 1)* $pageSize;


  // 增加筛选的逻辑

  // 声明变量 -- 文章状态
  $status = null;
  // 声明变量 -- 文章分类
  $category = null;
  // 增加的 sql语句
  // where true 写跟不写 是一样的 这里的目的是 后面好拼接
  $where ='where true';
  // 判断状态 并生成语句
  if(isset($_GET['status'])){
    $status = $_GET['status'];
    // 只有在 不是 all的时候 才需要进行筛选
    if($status!='all'){
     $where .=" and posts.status='$status'";
    }
  }

  // 判断分类 并生成语句
  if(isset($_GET['category'])){
    $category = $_GET['category'];
    if($category!='all'){
      // 因为我们查询的是 posts表 所以这里 使用posts.category_id
      $where.=" and posts.category_id='$category'";
    }
  }

  // 计算总页数
  // 有 101条数据  每页 10条 请问一共几页 101/10 = 10.1 Math.ceil() php中是 ceil() 
  // select count(*) from posts where true and posts.status='published';
  $count_sql = "select count(*) from posts $where";
  print_r($count_sql);
  // 总条数 
  $total_count = my_query($count_sql)[0]['count(*)'];
  // 总页数 
  $total_page = ceil($total_count/ $pageSize);
  // print_r($total_page);


  // 查询数据
  // 查询语句
  $data_sql = "
  select
  posts.id,
  posts.title,
  posts.created,
  posts.status,
  users.nickname,
  categories.name
  from
  posts
  inner join users on posts.user_id = users.id
  inner join categories on posts.category_id = categories.id
  $where
  order by posts.id desc
  limit $startIndex,$pageSize;
  ";
  
  // 获取数据
  $data = my_query($data_sql);

  // 打印 测试数据
  // print_r($data);

?>
  <!DOCTYPE html>
  <html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <title>Posts &laquo; Admin</title>
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
          <h1>所有文章</h1>
          <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
        </div>
        <!-- 有错误信息时展示 -->
        <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
        <div class="page-action">
          <!-- show when multiple checked -->
          <a class="deleteAll btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          <!-- 发送数据 
            表单 
              action
                如果提交给自己这个页面 那么 action可以不写
                get 提交的数据 如果用户 把这个页面收藏到收藏夹中 那么下次继续打开 下次继续访问 还是可以看到同样条件的数据
              method
                不写就是 get
            表单元素 name属性
            提交按钮
         -->
          <form class="form-inline">
            <!-- 文章分类 -->
            <select name="category" class="form-control input-sm">
              <option value="all">所有分类</option>
              <?php 
              // 查询 有多少分类
              $categoriesData = my_query('select * from categories');
              print_r($categoriesData);

              // 获取 提交过来的 category

              for($i=0;$i<count($categoriesData);$i++){
            ?>
              <option <?php echo $category==$categoriesData[$i][ 'id']? 'selected': ''; ?> value="<?php echo $categoriesData[$i]['id'];  ?>"><?php echo $categoriesData[$i]['name'];?>
              </option>
              <?php } ?>
            </select>
            <select name="status" class="form-control input-sm">
              <?php
              // 判断 状态的值是什么
            ?>
                <option value="all">所有状态</option>
                <option <?php echo $status=='drafted' ? 'selected': ''; ?> value="drafted">草稿</option>
                <option <?php echo $status=='published' ? 'selected': ''; ?> value="published">已发布</option>
                <option <?php echo $status=='trashed' ? 'selected': ''; ?> value="trashed">废弃</option>
            </select>
            <button type='submit' class="btn btn-default btn-sm">筛选</button>
          </form>
          <ul class="pagination pagination-sm pull-right">
            <?php
          // 如果 有分类筛选 那么 要把 分类筛选也拼接上去 ?status=published&p=xx
          // 定义 需要拼接的 href
          $href='?';
          if($status!=null){
            $href.="status=$status&";
          }
          if($category!=null){
            $href.="category=$category&";
          }
          // print_r($href);// ?status=drafted& 
        ?>
              <!-- 显示隐藏 上一页 -->
              <?php if($pageNum!=1){ ?>
              <li>
                <a href="<?php echo $href.'p='.($pageNum-1); ?>">上一页</a>
              </li>
              <?php } ?>
              <!-- 循环生成 页数 -->
              <?php for($i=1;$i<=$total_page;$i++){ ?>
              <li <?php echo $pageNum==$i? 'class="active"': ''; ?> >
                <a href="<?php echo $href.'p='.$i; ?>">
                  <?php echo $i; ?>
                </a>
              </li>
              <?php } ?>
              <!-- 显示隐藏 下一页 -->
              <?php if($pageNum!=$total_page){ ?>
              <li>
                <a href="<?php echo $href.'p='.($pageNum+1); ?>">下一页</a>
              </li>
              <?php } ?>
          </ul>
        </div>
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th class="text-center" width="40">
                <input class='checkAll' type="checkbox">
              </th>
              <th>标题</th>
              <th>作者</th>
              <th>分类</th>
              <th class="text-center">发表时间</th>
              <th class="text-center">状态</th>
              <th class="text-center" width="100">操作</th>
            </tr>
          </thead>
          <tbody>
            <!-- 循环生成tr -->
            <?php for($i=0;$i<count($data);$i++){ ?>
            <tr>
              <td class="text-center">
                <input value='<?php echo $data[$i]['id']; ?>' type="checkbox">
              </td>
              <td>
                <?php echo $data[$i]['title']; ?>
              </td>
              <td>
                <?php echo $data[$i]['nickname']; ?>
              </td>
              <td>
                <?php echo $data[$i]['name']; ?>
              </td>
              <td class="text-center">
                <?php echo $data[$i]['created']; ?>
              </td>
              <!-- 把英文状态 替换为 中文的状态 -->
              <td class="text-center">
                <?php echo changeStatus($data[$i]['status']); ?>
              </td>
              <td class="text-center">
                <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                <a href="/admin/post-delete.php?deleteIds=<?php echo $data[$i]['id']; ?>" class="btn btn-danger btn-xs">删除</a>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>

    <?php

  // 定义变量
  $pageName ='posts';
  // 引入边栏
  require_once 'inc/aside.php';
?>

      <script src="../static/assets/vendors/jquery/jquery.js"></script>
      <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
      <script>
        NProgress.done()
      </script>
  </body>

  </html>
  <!-- 自己的js -->
  <script>
    /*
                需求分析
                  1.全选反选
                      在 点击全选checkbox时 
                      把 其他的 checkbox 的 选中状态 变得 跟  全选checkbox一样
                  2. 单项全部被选中 勾上 全选 反之 取消勾选
                    tbody中的 checkbox 绑定点击事件
                  3. 有任何一个 checkbox 被勾选 那么就让 批量删除 出现 反之 隐藏
                      只要被选中的 个数 不为0 显示
                  4. 点击批量删除 获取 选中的 那些 id
              */
    $(function () {
      // 需求1 全选 反选
      $('.checkAll').click(function () {
        // tbody中的 checkbox 的 选中状态 变得 跟 全选一样
        // jQuery 为我们操纵 selected  checked disabled 这一类属性 提供了 prop 这个方法
        // 其他的 属性 href src  attr
        // $('tbody input[type=checkbox]').prop('checked',$(this).prop('checked'));

        var checkAllChecked = $(this).prop('checked');
        $('tbody input[type=checkbox]').prop('checked', checkAllChecked);

        // 如果 checkAllChecked 为 true 显示 批量删除
        if (checkAllChecked == true) {
          $('.deleteAll').fadeIn();
        } else {
          // 反之 隐藏
          $('.deleteAll').fadeOut();
        }
      })
      // 需求2 子选项
      $('tbody input[type=checkbox]').click(function () {
        // 被选中的 checkbox的个数 
        // console.log($('tbody input[type=checkbox]:checked').length);
        // console.log($('tbody input[type=checkbox]:checked'))
        var checkedNum = $('tbody input[type=checkbox]:checked').length;
        // 所有的checkbox的个数
        var totalNum = $('tbody input[type=checkbox]').length;

        // 勾选 全选checkbox的判断
        if (checkedNum == totalNum) {
          // 勾上全选
          $('.checkAll').prop('checked', true);
        } else {
          // 取消勾选
          // 勾上全选
          $('.checkAll').prop('checked', false);
        }
        // 显示 隐藏 批量删除
        if (checkedNum != 0) {
          $('.deleteAll').fadeIn();
        } else {
          $('.deleteAll').fadeOut();
        }
      })

      // 需求4
      $('.deleteAll').click(function () {
        // 获取所有 tbody中 被选中的 checkbox 进而获取value
        // value 无法获取 多个的值
        // console.log($('tbody input[type=checkbox]:checked').val());

        // 定义字符串 拼接数据
        var deleteIds = '';

        // 挨个获取
        // 生成 123,234,44,12                         i 是 索引 e 是 当前循环的dom元素
        $('tbody input[type=checkbox]:checked').each(function (i, e) {
          // 数字 
          deleteIds += e.value;
          // 如果是最后一个 不加,
          if(i!=($('tbody input[type=checkbox]:checked').length-1)){
            // 逗号
            deleteIds += ',';
          }
        })
        // 干掉最后一个
        // deleteIds = deleteIds.slice(0, -1);
        console.log(deleteIds);
        // 把数据 设置给 跳转的 url
        // window.location.href='xxxxx';

        // 设置 href
        $(this).attr('href','/admin/post-delete.php?deleteIds='+deleteIds);
      })
    })
  </script>