<?php


    // 执行 查询语句
function my_query($sql)
{
        // 链接数据库
    $link = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

    // 执行查询语句
    $result = mysqli_query($link, $sql);

    // 解析结果
    $data = array();
    $row = mysqli_fetch_assoc($result);
    while ($row) {
        $data[] = $row;
        $row = mysqli_fetch_assoc($result);
    }

    // 释放内存
    mysqli_free_result($result);

    // 关闭链接
    mysqli_close($link);
    // 返回结果
    return $data;
}

// 执行 删除 新增 修改的 函数
function my_execute($sql){
    // 链接数据库
    $link = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);

    // 执行查询语句
    mysqli_query($link,$sql);

    // 关闭数据库链接
    $rowNum = mysqli_affected_rows($link);
    mysqli_close($link);

    // 返回受影响的行数
    return $rowNum;
}

// 验证用户是否登陆函数
function checkIsLogin(){
    session_start();
    if(isset($_SESSION['login_user_data'])){
  
        //登陆成功
        print_r($_SESSION['login_user_data']);
    }else{
      // 登陆失败
      // 打回登录页
      header('location:./login.php');
    }
}

  // 上传成功了 返回true 失败 返回 false
  function upload($fileName, $targetPath)
  {
      // 允许的数组
      $allowTypes = array('image/png','image/jpeg','image/gif');
      // 上传的类型 是否允许
      $uploadType = $_FILES[$fileName]['type'];
      if (in_array($uploadType, $allowTypes)) {
        // 允许 上传
          move_uploaded_file($_FILES[$fileName]['tmp_name'], $targetPath);
          return true;
      } else {
        // 不允许 提示用户
        // echo '兄弟不要乱传';
          return false;
      }
  }
  
  
    // 传入一个 文件名 包含后缀的
  function randomNameWithType($oldName)
  {
      $newName ='';
      // 获取当前时间
      $newName .=date('Y_m_d_H_i_s_');
  
      // 随机来几个字母
      $letter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      for ($i=0; $i<6; $i++) {
          $newName .=$letter[mt_rand(0, 25)];
      }
  
      // 截取传入的文件名
      $type = strrchr($oldName, '.');
  
      // 拼接后缀
      $newName.=$type;
      // 返回拼接了后缀的文件名
      return $newName;
  }

?>