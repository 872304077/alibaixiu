<?php
    /*
     接口文档 分页
        url:/admin/comments-list.php
        method:get
            为了测试方便
        keys:
            pageNum: 页码
            pageSize:页容量
        返回的数据格式
            一般商业数据会复杂一点
            obj:{
                data:[]//当前这一页的数据,
                status://true false,
                totalPage://总页数
            }
    */ 
    // 引入配置文件 
    require_once '../config.php';
    // 引入函数
    require_once '../functions.php';

    // 接受get提交的数据
    $pageNum = $_GET['pageNum'];
    $pageSize = $_GET['pageSize'];

    // 根据页码 计算 开始的所用
    $startIndex = ($pageNum-1)*$pageSize;

    // 根据数据 获取对应的那一页的数据
    // 生成分页查询的语句
    $pageDataSql = "
        select 
        comments.id,
        comments.author,
        comments.content,
        posts.title,
        comments.created,
        comments.status
        from comments
        inner join posts on comments.post_id = posts.id
        order by comments.id desc
        limit $startIndex,$pageSize
    ";

    // 数据库
    $pageData = my_query($pageDataSql);

    // 计算总页数  ceil(总条数 / pageSize)
    // 总条数
    $totalCount = my_query('select count(*) from comments')[0]['count(*)'];
    // 总页数
    $totalPage = ceil($totalCount/$pageSize);

    // 数据包装一下 返回给用户 JSON
    $backData = array(
        'data'=>$pageData,
        'status'=>true,
        'totalPage'=>$totalPage
    );

    // 设置返回的是 json格式
    header('content-type:application/json;charset=utf-8');

    // 因为是字符串
    echo json_encode($backData);
?>