<div class="aside">
    <div class="profile">
    <!-- 通过session获取 用户信息 -->
      <img class="avatar" src="<?php echo $_SESSION['login_user_data'][0]['avatar']; ?>">
      <h3 class="name"><?php echo $_SESSION['login_user_data'][0]['nickname']; ?></h3>
    </div> 
    <ul class="nav">
    <!-- 首页  -->
      <li <?php
        if($pageName=='index'){
          echo 'class="active"';
        }else{
          echo '';
        }
      ?> >
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
    <!-- 文章 -->
      <li
        <?php
            if(in_array($pageName,array('posts','post-add','categories'))){
              echo 'class="active"';
            }else{
              echo '';
            }
          ?>
      >
        <a href="#menu-posts"
            <?php
              if(in_array($pageName,array('posts','post-add','categories'))){
                echo '';
              }else{
                echo 'class="collapsed"';
              }
            ?>
         data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" <?php echo in_array($pageName,array('posts','post-add','categories'))?'class="collapse in"':'class="collapse"'; ?>  >
          <li <?php echo $pageName=='posts'?'class="active"':''; ?> ><a href="posts.php">所有文章</a></li>
          <li <?php echo $pageName=='post-add'?'class="active"':''; ?> ><a href="post-add.php">写文章</a></li>
          <li <?php echo $pageName=='categories'?'class="active"':''; ?> ><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
    <!-- 评论 3元表达式 -->
      <li <?php echo $pageName=='comments'?'class="active"':''; ?>>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
    <!-- 用户 -->
      <li <?php echo $pageName=='users'?'class="active"':''; ?>>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
    <!-- 设置
          使用3元表达式 设置 父节点 子节点 箭头等的 样式
    -->
      <li <?php echo in_array($pageName,array('nav-menus','slides','settings'))?'class="active"':''; ?> >
        <a <?php echo in_array($pageName,array('nav-menus','slides','settings'))?'':'class="collapsed"'; ?> href="#menu-settings"  data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul class="collapse <?php echo in_array($pageName,array('nav-menus','slides','settings'))?' in':''; ?>"  id="menu-settings" >
          <li <?php echo $pageName=="nav-menus"?'class="active"':''; ?> ><a href="nav-menus.php">导航菜单</a></li>
          <li <?php echo $pageName=="slides"?'class="active"':''; ?> ><a href="slides.php">图片轮播</a></li>
          <li <?php echo $pageName=="settings"?'class="active"':''; ?> ><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>