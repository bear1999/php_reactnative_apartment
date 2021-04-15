<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

getStatus::_getStatus();

class getStatus
{
  public static function _getStatus()
  {
    $conn = OpenCon(); //Kết nối tới database

    $stmt = $conn->prepare("SELECT * FROM status_general WHERE groupStatus = 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);

    CloseCon($conn); //Close database
    die();
  }
}
