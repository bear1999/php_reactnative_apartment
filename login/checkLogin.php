<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

//use Firebase\JWT\JsonHelper;
use Firebase\JWT\JWT;

require("../JWT/JWT.php");
require("../db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  checkLogin::Login();
}

class checkLogin
{
  public static function Login()
  {
    $Key = "wuBZ!Qmy@WyqbjnncB@6qMZ^99b&yjbZ?E@Xq^2QMGWspsmsL+d3xU!&?54zVa37yVn_cjZHJCCgFwR6yzG5ZawP8^dvA!CmWpT!6sv@zD4A?_2QWX6gbm&w5J=hNXrZn^y#P$=5-7sKHMD?%2-S6j8A8NS#ZLy?pcLxfk%4smRLMVhAh3m8yU^MYXT*8^vC!a+-Z!j=6ba$6Z+knp2v%BQ*WCh9NzBT2K?z?@Z2ctsN-Jwt@KUtFZ%Rwx*s7AS";

    //Nếu không up image thì xài cái này
    $obj = file_get_contents('php://input');
    $obj = json_decode($obj, true);

    $Login = $obj['Login'];
    $Password = md5($obj['Password']);

    //Time Token
    $date = new DateTime();
    $interval = new DateInterval('P7D'); //Add 7 ngày vô datetime lúc đăng nhập
    $datenow = $date->add($interval);
    $datenow = $datenow->format('Y-m-d H:i:s');

    $conn = OpenCon(); //Kết nối tới database
    //Check password
    $checkLogin = "SELECT idUser, Disable FROM `login` WHERE (Email = '$Login' OR PhoneNumber = '$Login') AND `Password` = '$Password'";

    $execLogin = mysqli_query($conn, $checkLogin);
    if (mysqli_num_rows($execLogin) == 0) die(json_encode(1)); //Code 1 sai thông tin đăng nhập

    $Token = array();
    while ($row = mysqli_fetch_array($execLogin, MYSQLI_ASSOC)) {
      if($row['Disable'] == true) die(json_encode(2));
      $Token["idUser"] = $row["idUser"];
      $Token["Time"] = $datenow;
    }
    CloseCon($conn); //Close database

    $jwt = JWT::encode($Token, $Key);
    //echo JsonHelper::getJson("Token", $jwt);
    echo json_encode($jwt);
  }
}
