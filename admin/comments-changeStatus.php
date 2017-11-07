<?php
    /*
        接口文档
            url:/admin/comments-changeStatus.php
            type:get,
            data:
                ids:12 / 12，13，15
                changeStatus:改为什么状态
                    状态（held(驳回)/approved(批准)/rejected(拒绝)/trashed(废弃)）
            返回的数据格式
                data:{
                    status:true/false,
                    affectRows:1 受影响行数
                }
    */
    // 引入配置文件
    require_once '../config.php';

    // 引入 函数
    require_once '../functions.php';
    // 接受数据
    $changeIds = $_GET['ids'];
    $changeStatus = $_GET['changeStatus'];

    // 生成sql语句
    $sql = "update comments set status = '$changeStatus' where id in ($changeIds)";

    // 执行sql语句
    $affectRows = my_execute($sql);

    // 设置返回的数据格式为JSON
    header('content-type:application/json;charset=utf-8');

    // 返回结果
    echo json_encode(array(
        'status'=>true,
        'affectRows'=>$affectRows
    ))

?>