<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  ManagerAccount::LoadDSAccount();
}

class ManagerAccount
{
  public static function LoadDSAccount()
  {
    $obj = file_get_contents('php://input');
    $obj = json_decode($obj, true);

    $Item_In_Page = 6;
    $Trang = $obj['Page'];
    $From = $Trang * $Item_In_Page;

    $conn = OpenCon(); //Kết nối tới database
    //Load nếu có tìm và có vị trí
    if (isset($obj['TimKiem']) || isset($obj['Position'])) {
      if ($obj['Position'] == 0) {
        //Load với chức vụ là tất cả
        $stmt = $conn->prepare("SELECT *
                        FROM `login` a 
                        JOIN account c ON c.idUser = a.idUser
                        JOIN position b ON c.idPosition = b.idPosition
                        WHERE a.idUser LIKE '%" . $obj['TimKiem'] . "%'
                        OR c.Username LIKE '%" . $obj['TimKiem'] . "%'
                        OR a.PhoneNumber LIKE '%" . $obj['TimKiem'] . "%'
                        OR a.Email LIKE '%" . $obj['TimKiem'] . "%'
                        ORDER BY a.idUser DESC LIMIT $From, $Item_In_Page");
      } else {
        //Load với chức vụ theo chọn
        $stmt = $conn->prepare("SELECT *
                        FROM account a
                        JOIN `login` c ON a.idUser = c.idUser
                        JOIN position b ON a.idPosition = b.idPosition
                        WHERE (c.idUser LIKE '%" . $obj['TimKiem'] . "%'
                        OR a.Username LIKE '%" . $obj['TimKiem'] . "%'
                        OR c.PhoneNumber LIKE '%" . $obj['TimKiem'] . "%'
                        OR c.Email LIKE '%" . $obj['TimKiem'] . "%')
                        AND a.idPosition = '" . $obj['Position'] . "'
                        ORDER BY c.idUser DESC LIMIT $From, $Item_In_Page");
      }
    } else { //Load khi mới open screen
      $stmt = $conn->prepare("SELECT *
                      FROM account a 
                      JOIN `login` c ON c.idUser = a.idUser
                      JOIN position b ON a.idPosition = b.idPosition
                      ORDER BY c.idUser DESC LIMIT $From, $Item_In_Page");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);

    CloseCon($conn); //Close database
    die();
  }
}
