<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  ChangePassword::DoiMatKhau();
}

class ChangePassword
{
  public static function DoiMatKhau()
  {
    //Nếu không up image thì xài cái này
    $obj = file_get_contents('php://input');
    $obj = json_decode($obj, true);

    if (isset($obj)) { //Kiểm tra xem có dữ liệu 
      $obj['newPassword'] = md5($obj['newPassword']); //Mã hóa password
      //Upload profile
      $conn = OpenCon(); //Kết nối tới database
      //Check password

      //UPDATE password
      $queryStr = "UPDATE `login` SET `Password` = '" . $obj['newPassword'] . "' WHERE idUser = '" . $obj['idUser'] . "'";

      $execQuery = mysqli_query($conn, $queryStr);
      if ($execQuery) {
        $result = 1; //UPDATE thành công
      } else {
        $result = 2; //UPDATE thất bại
      }
      CloseCon($conn); //Close database
      die(json_encode($result));
    }
  }
}
