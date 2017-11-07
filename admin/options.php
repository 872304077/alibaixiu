<?php
    /*
        接口文档
        获取网站设置信息
            url:/admin/options.php
            type:get
            keys:
                type:web 获取网站整体信息
                type:nav 获取导航信息
                type:slides 获取轮播信息
        新增导航栏
            url:/admin/options.php
            type:post
            keys:
                type:'nav'/'slides'  指定操纵的数据
                data:JSON格式字符串  // JSON.stringify

 */
    // 引入配置
require_once '../config.php';

    // 引入函数
require_once '../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // 创建Sql语句
    $sql = null;
                // 设置返回的数据格式
    header('content-type:application/json;charset=utf-8');
        // get逻辑
    switch ($_GET['type']) {
        case 'web' :
            $sql = "select * from options where true";
            die(json_encode(array(
                'status' => true,
                'data' => my_query($sql)
            )));
            break;
        case 'nav' :
            $sql = "select * from options where `key` ='nav_menus' ";
            die(json_encode(array(
                'status' => true,
                'data' => my_query($sql)[0]
            )));
            break;
        case 'slides' :
            $sql = "select * from options  where `key` ='home_slides' ";
            die(json_encode(array(
                'status' => true,
                'data' => my_query($sql)[0]
            )));
        default :
                # code...
            break;
    }

}
else {
    // post逻辑
    // 修改内容
    $sql = '';
    // 提交的数据
    $postData = $_POST['data'];
    switch ($_POST['type']) {
        case 'nav' :
            $sql = "update options set value = '$postData' where `key`='nav_menus' ";
            die(json_encode(array(
                'status' => true,
                'affectRows' => my_execute($sql)
            )));
            break;
        case 'slides' :
            $sql = "update options set value = '$postData' where `key`='home_slides' ";
            die(json_encode(array(
                'status' => true,
                'affectRows' => my_execute($sql)
            )));
            break;
        default :
            # code...
            break;
    }

}

?>