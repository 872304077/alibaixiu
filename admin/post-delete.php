<?php
    // 引入配置文件 
    require_once '../config.php';
    require_once '../functions.php';

    // 引入 函数

    // 接受数据 
    $deleteIds = $_GET['deleteIds'];

    // 生成 sql语句批量删除
    $sql = "delete from posts where id in ($deleteIds)";

    // 删除对应的数据
    $nums = my_execute($sql);

    // 执行完毕之后   $_SERVER 可以获取非常多的信息
    //  HTTP_REFERER 可以获取 从哪个地址跳转过来的
    // echo '<pre>';
    // print_r($_SERVER);
    // echo '</pre>';

    // 跳转会文章首页
    header('location:'.$_SERVER['HTTP_REFERER']);
?>