<?php
    /*
        接口文档
            url:/admin/comments-delete.php
            type:get
            keys:   ids
                需要删除的id们  12  多个 1，2，3，4
            返回的数据格式
                obj:{
                    status:true/false,
                    affectRows:删除的行数
                }
    */ 
    // 导入 配置文件 导入 函数
    require_once '../config.php';
    require_once '../functions.php';

    // 接受数据
    $deleteIds = $_GET['ids'];

    // 生成sql语句
    $sql = "
    delete from comments where id in($deleteIds)
    ";

    // 查询数据库
    $affectRows = my_execute($sql);
    
    // 设置返回的是 json
    header('content-type:application/json;charset=utf-8');

    // 生成结果 返回
    echo  json_encode(array(
        'status'=>true,
        'affectRows'=>$affectRows
    ));

?>