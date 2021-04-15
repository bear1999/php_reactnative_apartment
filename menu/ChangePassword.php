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
      $checkUNIQUE = "SELECT `Password` FROM `login` WHERE idUser = '" . $obj['idUser'] . "'";
      $execUNIQUE = mysqli_query($conn, $checkUNIQUE);
      $row = mysqli_fetch_array($execUNIQUE, MYSQLI_ASSOC);
      if (!strcasecmp($row['Password'], md5($obj['Password'])) == 0) {
        $result = 1; //Password không khớp
        die(json_encode($result));
      }


      //UPDATE password
      $queryStr = "UPDATE `login` SET `Password` = '" . $obj['newPassword'] . "' WHERE idUser = '" . $obj['idUser'] . "'";

      $execQuery = mysqli_query($conn, $queryStr);
      if ($execQuery) {
        $result = 2; //UPDATE thành công
      } else {
        $result = 3; //UPDATE thất bại
      }
      CloseCon($conn); //Close database
      die(json_encode($result));
    }
  }
}
