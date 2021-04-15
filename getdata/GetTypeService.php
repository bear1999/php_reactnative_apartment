<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

getTypeService::_getTypeService();

class getTypeService
{
  public static function _getTypeService()
  {
    $conn = OpenCon(); //Kết nối tới database

    $stmt = $conn->prepare("SELECT idType_service, name_service FROM type_service");
    $stmt->execute();
    $result = $stmt->get_result();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);

    CloseCon($conn); //Close database
    die();
  }
}
