<?php

    // 引入 配置
    require_once '../config.php';

    // 引入 函数
    require_once '../functions.php';

    // 接受 提交过来的 id
    $deleteIds = $_GET['deleteIds'];

    // 执行sql语句
    $sql = "delete from categories where id in($deleteIds)";
    $rowNums = my_execute($sql);

    // 跳转回原来的页面
    header('location:'.$_SERVER['HTTP_REFERER']);
?>