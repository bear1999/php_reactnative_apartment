<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

use Firebase\JWT\JWT;

require('../db_connection.php');
require("../JWT/JWT.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  checkToken::LoadInfoUser();
}

class checkToken
{
  public static function LoadInfoUser()
  {
    $obj = file_get_contents('php://input');
    $obj = json_decode($obj, true);

    $Token = $obj;
    $Key = "wuBZ!Qmy@WyqbjnncB@6qMZ^99b&yjbZ?E@Xq^2QMGWspsmsL+d3xU!&?54zVa37yVn_cjZHJCCgFwR6yzG5ZawP8^dvA!CmWpT!6sv@zD4A?_2QWX6gbm&w5J=hNXrZn^y#P$=5-7sKHMD?%2-S6j8A8NS#ZLy?pcLxfk%4smRLMVhAh3m8yU^MYXT*8^vC!a+-Z!j=6ba$6Z+knp2v%BQ*WCh9NzBT2K?z?@Z2ctsN-Jwt@KUtFZ%Rwx*s7AS";
    $jwt = JWT::decode($Token, $Key, array('HS256'));

    $idUser = null;
    $Time = null;
    foreach ($jwt as $key => $value) {
      if ($key == "idUser")
        $idUser = $value;
      else if ($key == "Time")
        $Time = new DateTime($value);
    }

    //Hết hạn token
    $DateTimeNow = new DateTime();
    if ($Time < $DateTimeNow)
      die(json_encode(1)); //Code 1 sai thông tin đăng nhập, cũng là hết hạn token

    $conn = OpenCon(); //Kết nối tới database
    $checkLogin = "SELECT b.Username, b.Sex, b.Birthday, a.Email, a.PhoneNumber, b.pathAvatar, a.idUser, b.idPosition, a.Disable
                    FROM `login` a 
                    INNER JOIN account b ON a.idUser = b.idUser
                    WHERE a.idUser = '$idUser' ";
    $execLogin = mysqli_query($conn, $checkLogin);
    if (mysqli_num_rows($execLogin) == 0) die(json_encode(1)); //Code 1 sai thông tin đăng nhập

    $userInfo = array();
    while ($row = mysqli_fetch_array($execLogin, MYSQLI_ASSOC)) {
      if($row['Disable'] == true) die(json_encode(2)); // Tài khoản vô hiệu hóa
      $userInfo['Birthday'] = $row['Birthday'];
      $userInfo["idUser"] = $row["idUser"];
      $userInfo["Username"] = $row["Username"];
      $userInfo["Sex"] = $row["Sex"];
      $userInfo["Email"] = $row["Email"];
      $userInfo["PhoneNumber"] = $row["PhoneNumber"];
      $userInfo["pathAvatar"] = $row["pathAvatar"];
      $userInfo["Position"] = $row["idPosition"];
    }
    CloseCon($conn); //Close database

    die(json_encode($userInfo));
  }
}
