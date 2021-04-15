<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  UpdateAccount::CapNhatTaiKhoan();
}

class UpdateAccount
{
  public static function CapNhatTaiKhoan()
  {
    //Nếu không up image thì xài cái này
    //$obj = file_get_contents('php://input');
    //$obj = json_decode($obj, true);

    $obj = $_POST;
    $files = $_FILES;
    if (isset($obj) || isset($files['photo']['tmp_name'])) { //Kiểm tra xem có dữ liệu
      //Upload Avatar
      if (isset($files['photo']['tmp_name'])) {
        $folderUpload = "../assets/avatar";
        $pathAvatar = rand() . "-" . time() . ".jpg";
        if (!move_uploaded_file($files['photo']['tmp_name'], $folderUpload . "/" . $pathAvatar)) {
          die(json_encode('Upload ảnh đại diện thất bại!'));
        }
      }

      //Upload profile
      $conn = OpenCon(); //Kết nối tới database
      //Check trùng Email vs SĐT
      $checkUNIEQUE = "SELECT Email, PhoneNumber FROM `login` WHERE idUser != '" . $obj["idUser"] . "'";
      $checkUNIEQUE = mysqli_query($conn, $checkUNIEQUE);
      while ($row = mysqli_fetch_array($checkUNIEQUE, MYSQLI_ASSOC)) {
        if (strcasecmp($row['Email'], $obj['Email']) == 0) {
          $result = 1; //Địa chỉ Email này đã có người sử dụng
          die(json_encode($result));
        } else if (strcasecmp($row['PhoneNumber'], $obj['PhoneNumber']) == 0) {
          $result = 2; //Số điện thoại này đã có người sử dụng
          die(json_encode($result));
        }
      }

      $obj['Birthday'] = str_replace('/', '-', $obj['Birthday']); //format 01/01/2020 => 01-01-2020 
      $obj['Birthday'] = date('Y-m-d', strtotime($obj['Birthday'])); //Format ngày giống với react native và php vào mysql
      //UPDATE data
      if (isset($files['photo']['tmp_name']) && isset($obj['Position'])) {
        unlink($folderUpload . "/" . $obj['pathAvatar']);
        $obj['pathAvatar'] = $pathAvatar;
        $queryStr = "UPDATE account, `login` SET Username = '" . $obj['Username'] . "', Birthday = '" . $obj['Birthday'] . "', Sex = '" . $obj['Sex'] . "', idPosition = '" . $obj['Position'] . "', pathAvatar = '" . $obj['pathAvatar'] . "',
                      IDCard = '" . $obj['IDCard'] . "', PhoneNumber = '" . $obj['PhoneNumber'] . "', Email = '" . $obj['Email'] . "'
                      WHERE `login`.idUser = '" . $obj['idUser'] . "' AND account.idUser = '" . $obj['idUser'] . "'";
      } else if (!isset($files['photo']['tmp_name']) && !isset($obj['Position'])) { //Thông tin cá nhân
        $queryStr = "UPDATE account, `login` SET Username = '" . $obj['Username'] . "', Birthday = '" . $obj['Birthday'] . "', Sex = '" . $obj['Sex'] . "',
                      PhoneNumber = '" . $obj['PhoneNumber'] . "', Email = '" . $obj['Email'] . "'
                      WHERE `login`.idUser = '" . $obj['idUser'] . "' AND account.idUser = '" . $obj['idUser'] . "'";
      } else if (isset($files['photo']['tmp_name']) && !isset($obj['Position'])) { //Thông tin cá nhân
        unlink($folderUpload . "/" . $obj['pathAvatar']);
        $obj['pathAvatar'] = $pathAvatar;
        $queryStr = "UPDATE account, `login` SET Username = '" . $obj['Username'] . "', Birthday = '" . $obj['Birthday'] . "', Sex = '" . $obj['Sex'] . "', pathAvatar = '" . $obj['pathAvatar'] . "',
                      PhoneNumber = '" . $obj['PhoneNumber'] . "', Email = '" . $obj['Email'] . "'
                      WHERE `login`.idUser = '" . $obj['idUser'] . "' AND account.idUser = '" . $obj['idUser'] . "'";
      } else if (!isset($files['photo']['tmp_name']) && isset($obj['Position'])) {
        $queryStr = "UPDATE account, `login` SET Username = '" . $obj['Username'] . "', Birthday = '" . $obj['Birthday'] . "', Sex = '" . $obj['Sex'] . "', idPosition = '" . $obj['Position'] . "', IDCard = '" . $obj['IDCard'] . "',
                      PhoneNumber = '" . $obj['PhoneNumber'] . "', Email = '" . $obj['Email'] . "'
                      WHERE `login`.idUser = '" . $obj['idUser'] . "' AND account.idUser = '" . $obj['idUser'] . "'";
      }
      $execQuery = mysqli_query($conn, $queryStr);
      if ($execQuery) {
        $result = 3; //UPDATE thành công
      } else {
        $result = 4; //UPDATE thất bại
      }
      CloseCon($conn); //Close database
      die(json_encode($result));
    }
  }
}
