<?php
  // 引入配置
  require_once './config.php';

  // 引入函数
  require_once './functions.php';

  // 查询很多数据
  // 导航数据
  // $navData = my_query("select * from options where `key` = 'nav_menus';")[0]['value'];
  $navData = json_decode(my_query("select * from options where `key` = 'nav_menus';")[0]['value'],true);

  // 轮播图数据
  $slidesData = json_decode(my_query("select * from options where `key` = 'home_slides';")[0]['value'],true);

  // 获取 随机的 5篇文章 
  $postData = my_query("select * from posts order by rand() limit 0,5;");

  // 获取 随机的 5篇文章的 详细信息
  $detailPostData =my_query("select 
  posts.id,
  posts.title,
  posts.created,
  posts.content,
  posts.feature,
  posts.views,
  posts.likes,
  users.nickname,
  categories.name
  from posts 
  inner join users on posts.user_id = users.id
  inner join categories on posts.category_id = categories.id
  order by rand()
  limit 0,5;");

  // 获取 所有的 id
  $detailPostid = array();
  // 评论个数
  $detailPostCommentCount = array();
  for($i=0;$i<count($detailPostData);$i++){
    $detailPostid[] = $detailPostData[$i]['id'];
    $currentId = $detailPostData[$i]['id'];
    // 要获取 每一个 id对应的 评论个数
    $detailPostCommentCount[] = my_query("select count(*) from comments where id =$currentId ")[0]['count(*)'];
  }
  

  echo '<pre>';
  // print_r($navData);
  // 如果只传入字符串 那么 格式是对象的话会被转化为 PHP的对象 参数2 传入 true 就会把对象转化为 php的关系型数组
  // print_r(json_decode($navData,true));
  // print_r($slidesData);
  // print_r($postData);
  // print_r($detailPostData); 
  // print_r($detailPostid);
  // print_r($detailPostCommentCount);
  echo '</pre>';

  // 渲染到页面上
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="/static/assets/css/style.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <?php for($i=0;$i<count($navData);$i++){ ?>
        <li><a href="javascript:;"><i class="<?php echo $navData[$i]['icon']; ?>"></i><?php echo $navData[$i]['title']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
    <div class="header">
      <h1 class="logo"><a href="index.html"><img src="/static/assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
      <?php for($i=0;$i<count($navData);$i++){ ?>
        <li><a href="javascript:;"><i class="<?php echo $navData[$i]['icon']; ?>"></i><?php echo $navData[$i]['title']; ?></a></li>
        <?php } ?>
      </ul>
      <div class="search">
        <form>
          <input type="text" class="keys" placeholder="输入关键字">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
      </div>
    </div>
    <div class="aside">
      <div class="widgets">
        <h4>搜索</h4>
        <div class="body search">
          <form>
            <input type="text" class="keys" placeholder="输入关键字">
            <input type="submit" class="btn" value="搜索">
          </form>
        </div>
      </div>
      <div class="widgets">
        <h4>随机推荐</h4>
        <ul class="body random">
          <li>
            <a href="javascript:;">
              <p class="title">废灯泡的14种玩法 妹子见了都会心动</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="/static/uploads/widget_1.jpg" alt="">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <p class="title">可爱卡通造型 iPhone 6防水手机套</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="/static/uploads/widget_2.jpg" alt="">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <p class="title">变废为宝！将手机旧电池变为充电宝的Better</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="/static/uploads/widget_3.jpg" alt="">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <p class="title">老外偷拍桂林芦笛岩洞 美如“地下彩虹”</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="/static/uploads/widget_4.jpg" alt="">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <p class="title">doge神烦狗打底南瓜裤 就是如此魔性</p>
              <p class="reading">阅读(819)</p>
              <div class="pic">
                <img src="/static/uploads/widget_5.jpg" alt="">
              </div>
            </a>
          </li>
        </ul>
      </div>
      <div class="widgets">
        <h4>最新评论</h4>
        <ul class="body discuz">
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="/static/uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="/static/uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="/static/uploads/avatar_2.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="/static/uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="/static/uploads/avatar_2.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="/static/uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="content">
      <div class="swipe">
        <ul class="swipe-wrapper">
        <?php for($i=0;$i<count($slidesData);$i++){ ?>
          <li>
            <a href="#">
              <img src="<?php echo $slidesData[$i]['image']; ?>">
              <span><?php echo $slidesData[$i]['text']; ?></span>
            </a>
          </li>
        <?php } ?>
          <li>
            <a href="#">
              <img src="/static/uploads/slide_2.jpg">
              <span>XIU主题演示</span>
            </a>
          </li>
          <li>
            <a href="#">
              <img src="/static/uploads/slide_1.jpg">
              <span>XIU主题演示</span>
            </a>
          </li>
          <li>
            <a href="#">
              <img src="/static/uploads/slide_2.jpg">
              <span>XIU主题演示</span>
            </a>
          </li>
        </ul>
        <p class="cursor"><span class="active"></span><span></span><span></span><span></span></p>
        <a href="javascript:;" class="arrow prev"><i class="fa fa-chevron-left"></i></a>
        <a href="javascript:;" class="arrow next"><i class="fa fa-chevron-right"></i></a>
      </div>
      <div class="panel focus">
        <h3>焦点关注</h3>
        <ul>
        <?php for($i=0;$i<count($postData);$i++){ ?>
          <?php if($i==0){ ?>
            <li class="large">
              <a href="javascript:;">
                <img src="<?php echo $postData[$i]['feature'] ?>" alt="">
                <span><?php echo $postData[$i]['title'] ?></span>
              </a>
            </li>
          <?php } else{ ?>
            <li >
              <a href="javascript:;">
                <img src="<?php echo $postData[$i]['feature'] ?>" alt="">
                <span><?php echo $postData[$i]['title'] ?></span>
              </a>
            </li>
          <?php } ?>
        <?php } ?>
         
        </ul>
      </div>
      <div class="panel top">
        <h3>一周热门排行</h3>
        <ol>
        <?php for($i=0;$i<count($postData);$i++){ ?>
          <li>
            <i><?php echo $i+1; ?></i>
            <a href="javascript:;"><?php echo $postData[$i]['title']; ?></a>
            <a href="javascript:;" class="like">赞(<?php echo $postData[$i]['likes']; ?>)</a>
            <span>阅读 (<?php echo $postData[$i]['views']; ?>)</span>
          </li>
        <?php } ?>
      
        </ol>
      </div>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
        <?php for($i=1;$i<count($postData);$i++){?>
          <li>
            <a href="javascript:;">
              <img src="<?php echo $postData[$i]['feature']; ?>" alt="">
              <span><?php echo $postData[$i]['title']; ?></span>
            </a>
          </li>
        <?php } ?>
        </ul>
      </div>
      <div class="panel new">
        <h3>最新发布</h3>
      <?php for($i=0;$i<count($detailPostData);$i++){ ?>
        <div class="entry">
          <div class="head">
            <span class="sort"><?php echo $detailPostData[$i]['name']; ?></span>
            <a href="./detail.php?postId=<?php echo $detailPostData[$i]['id']; ?>"><?php echo $detailPostData[$i]['title']; ?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $detailPostData[$i]['nickname']; ?> 发表于 <?php echo $detailPostData[$i]['created']; ?></p>
            <p class="brief"><?php echo $detailPostData[$i]['content']; ?></p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $detailPostData[$i]['views']; ?>)</span>
              <span class="comment">评论(<?php echo $detailPostCommentCount[$i]; ?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php echo $detailPostData[$i]['likes']; ?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $detailPostData[$i]['name']; ?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="<?php echo $detailPostData[$i]['feature']; ?>" alt="">
            </a>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/swipe/swipe.js"></script>
  <script>
    //
    var swiper = Swipe(document.querySelector('.swipe'), {
      auto: 3000,
      transitionEnd: function (index) {
        // index++;

        $('.cursor span').eq(index).addClass('active').siblings('.active').removeClass('active');
      }
    });

    // 上/下一张
    $('.swipe .arrow').on('click', function () {
      var _this = $(this);

      if(_this.is('.prev')) {
        swiper.prev();
      } else if(_this.is('.next')) {
        swiper.next();
      }
    })
  </script>
</body>
</html>
