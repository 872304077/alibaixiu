<?php
    // 保存文件
    move_uploaded_file($_FILES['image']['tmp_name'],'../static/uploads/'.$_FILES['image']['name']);

    // 返回保存的路径 返回绝对路径 因为 最终使用的 前台页面 是在哪 不确定的
    echo '/static/uploads/'.$_FILES['image']['name'];
?>