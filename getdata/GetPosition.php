<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

GetPosition::_getPosition();

class GetPosition
{
  public static function _getPosition()
  {
    $conn = OpenCon(); //Kết nối tới database

    $stmt = $conn->prepare("SELECT * FROM position");
    $stmt->execute();
    $result = $stmt->get_result();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);

    CloseCon($conn); //Close database
    die();
  }
}
