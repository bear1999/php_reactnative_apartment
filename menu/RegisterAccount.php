<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  RegisterAccount::DangKyTaiKhoan();
}

class RegisterAccount
{
  public static function DangKyTaiKhoan()
  {
    //Nếu không up image thì xài cái này
    //$obj = file_get_contents('php://input');
    //$obj = json_decode($obj, true);
    $obj = $_POST;
    $files = $_FILES;

    if (isset($obj) && isset($files['photo']['tmp_name'])) { //Kiểm tra xem có dữ liệu 
      //Upload Avatar
      $folderUpload = "../assets/avatar";
      $pathAvatar = rand() . "-" . time() . ".jpg";
      if (!move_uploaded_file($files['photo']['tmp_name'], $folderUpload . "/" . $pathAvatar)) {
        die(json_encode('Upload ảnh đại diện thất bại!'));
      }

      //Upload profile
      $conn = OpenCon(); //Kết nối tới database
      //Check trùng Email vs SĐT
      $checkEmail = "SELECT Email FROM `login` WHERE Email = '" . $obj['Email'] . "'";
      $checkEmail = mysqli_query($conn, $checkEmail);
      $row = mysqli_fetch_array($checkEmail, MYSQLI_ASSOC);
      if (isset($row['Email'])) {
        $result = 1; //Địa chỉ Email này đã có người sử dụng
        die(json_encode($result));
      }
      $checkPhone = "SELECT PhoneNumber FROM `login` WHERE PhoneNumber = '" . $obj['PhoneNumber'] . "'";
      $checkPhone = mysqli_query($conn, $checkPhone);
      $row = mysqli_fetch_array($checkPhone, MYSQLI_ASSOC);
      if (isset($row['PhoneNumber'])) {
        $result = 2; //Số điện thoại này đã có người sử dụng
        die(json_encode($result));
      }

      if ($obj['idPosition'] == 1) {
        $checkUNIQUEHome = "SELECT idMain FROM apartment WHERE type_apartment = 4 AND idMain = '" . $obj['idHome'] . "'";
        $checkUNIQUEHome = mysqli_query($conn, $checkUNIQUEHome);
        $row = mysqli_fetch_array($checkUNIQUEHome, MYSQLI_ASSOC);
        if (!isset($row['idMain'])) {
          $result = 5; //Mã căn hộ ko tồn tại
          die(json_encode($result));
        }
      }

      //Bỏ data POST vào mảng queryStr
      $obj['Birthday'] = str_replace('/', '-', $obj['Birthday']); //format 01/01/2020 => 01-01-2020 
      $obj['Birthday'] = date('Y-m-d', strtotime($obj['Birthday'])); //Format ngày giống với react native và php vào mysql
      $obj['Password'] = md5($obj['Password']); //Mã hóa MD5
      $obj['pathAvatar'] = $pathAvatar;

      $queryStr = "INSERT INTO `login` (idUser, Email, PhoneNumber, `Password`) VALUES ('', '" . $obj['Email'] . "', '" . $obj['PhoneNumber'] . "', '" . $obj['Password'] . "');";
      $queryStr .= "SET @idNe = LAST_INSERT_ID();";
      $queryStr .= "INSERT INTO `account` (idSql, idUser, Username, Sex, Birthday, IDCard, idPosition, regDate, pathAvatar) VALUES ('', @idNe, '" . $obj['Username'] . "', '" . $obj['Sex'] . "', '" . $obj['Birthday'] . "', '" . $obj['CMND'] . "', '" . $obj['idPosition'] . "', NOW(), '" . $obj["pathAvatar"] . "');";
      if ($obj['idPosition'] == 1)
        $queryStr .= "INSERT INTO `owner_home` (idUser, idHome) VALUES (@idNe, '" . $obj['idHome'] . "')";
      $execQuery = $conn->multi_query($queryStr);
      if ($execQuery) {
        $result = 3; //Đăng ký thành công
      } else {
        $result = 4; //Đăng ký thất bại
      }
      CloseCon($conn); //Close database
      echo json_encode($result);
    }
  }
}
